<?php
/**
 * Tally questionnaire integration.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Receives Tally webhook submissions for the Conscious Mirror and Pattern
 * Map questionnaires and hands them to Atlas_Relics_Core_Fulfillment to
 * match against a pending fulfillment record.
 *
 * Tally's exact webhook payload shape is not something this codebase can
 * verify without a live Tally account and form — the field extraction
 * below is written defensively (never fatals on an unexpected shape) and
 * should be confirmed against a real payload during setup. Log the raw
 * body once (temporarily) via `error_log( $request->get_body() )` in
 * `handle_webhook()` if a submission isn't matching as expected, then
 * adjust `extract_field()`.
 *
 * @see https://tally.so/help/webhooks
 */
class Atlas_Relics_Core_Tally {

	const HIDDEN_FIELD_FULFILLMENT_ID = 'fulfillment_id';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register the webhook REST route.
	 */
	public function register_routes() {
		register_rest_route(
			'atlas-relics/v1',
			'/tally-webhook',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_webhook' ),
				'permission_callback' => array( $this, 'verify_signature' ),
			)
		);
	}

	/**
	 * Verify the Tally webhook signature before the callback runs.
	 *
	 * Tally signs each webhook request with HMAC-SHA256 of the raw body,
	 * using the signing secret configured on the Tally form, in a
	 * `Tally-Signature` header. Reject anything that doesn't match rather
	 * than trusting an unauthenticated POST to this endpoint.
	 *
	 * @param WP_REST_Request $request Incoming request.
	 * @return bool|WP_Error
	 */
	public function verify_signature( WP_REST_Request $request ) {
		$secret = Atlas_Relics_Core_Settings::get( 'tally_webhook_secret' );

		if ( empty( $secret ) ) {
			return new WP_Error( 'atlas_relics_tally_not_configured', __( 'Tally webhook secret is not configured.', 'atlas-relics-core' ), array( 'status' => 503 ) );
		}

		$signature = $request->get_header( 'tally-signature' );

		if ( empty( $signature ) ) {
			return new WP_Error( 'atlas_relics_tally_missing_signature', __( 'Missing webhook signature.', 'atlas-relics-core' ), array( 'status' => 401 ) );
		}

		$expected = base64_encode( hash_hmac( 'sha256', $request->get_body(), $secret, true ) );

		if ( ! hash_equals( $expected, $signature ) ) {
			return new WP_Error( 'atlas_relics_tally_bad_signature', __( 'Invalid webhook signature.', 'atlas-relics-core' ), array( 'status' => 401 ) );
		}

		return true;
	}

	/**
	 * Handle a verified webhook submission.
	 *
	 * @param WP_REST_Request $request Incoming request.
	 * @return WP_REST_Response
	 */
	public function handle_webhook( WP_REST_Request $request ) {
		$payload = $request->get_json_params();

		if ( empty( $payload['data'] ) || empty( $payload['data']['fields'] ) || ! is_array( $payload['data']['fields'] ) ) {
			return new WP_REST_Response( array( 'received' => true, 'matched' => false ), 200 );
		}

		$fields         = $payload['data']['fields'];
		$fulfillment_id = absint( $this->extract_field( $fields, self::HIDDEN_FIELD_FULFILLMENT_ID ) );
		$email          = sanitize_email( (string) $this->extract_field_by_type( $fields, 'EMAIL' ) );
		$submission_id  = isset( $payload['data']['submissionId'] ) ? sanitize_text_field( $payload['data']['submissionId'] ) : '';

		/**
		 * Fires when a Tally submission has been received and parsed,
		 * before fulfillment matching. Fulfillment automation listens
		 * here rather than this class reaching into fulfillment internals.
		 *
		 * @param int    $fulfillment_id Fulfillment record ID from the form's hidden field, or 0 if absent.
		 * @param string $email          Respondent email, if a field of type EMAIL was found.
		 * @param string $submission_id  Tally's submission ID.
		 * @param array  $fields         Raw field list from the payload, for callers that need more.
		 */
		do_action( 'atlas_relics_core_tally_submission_received', $fulfillment_id, $email, $submission_id, $fields );

		return new WP_REST_Response( array( 'received' => true ), 200 );
	}

	/**
	 * Find a field's value by its key or label (used for hidden fields).
	 *
	 * @param array  $fields Field list from the webhook payload.
	 * @param string $key    Field key to find.
	 * @return string|null
	 */
	private function extract_field( array $fields, $key ) {
		foreach ( $fields as $field ) {
			if ( ! is_array( $field ) ) {
				continue;
			}

			// Tally reports hidden fields with an auto-generated `key`
			// (e.g. "question_abc123") and the hidden field's name in
			// `label`, so match on either.
			$matches_key   = isset( $field['key'] ) && is_string( $field['key'] ) && 0 === strcasecmp( $field['key'], $key );
			$matches_label = isset( $field['label'] ) && is_string( $field['label'] ) && 0 === strcasecmp( $field['label'], $key );

			if ( $matches_key || $matches_label ) {
				return is_scalar( $field['value'] ?? null ) ? (string) $field['value'] : null;
			}
		}

		return null;
	}

	/**
	 * Find the first field of a given Tally field type (e.g. "EMAIL"), to
	 * locate the respondent's email without depending on a specific
	 * question key.
	 *
	 * @param array  $fields Field list from the webhook payload.
	 * @param string $type   Substring to match against the field's `type`.
	 * @return string|null
	 */
	private function extract_field_by_type( array $fields, $type ) {
		foreach ( $fields as $field ) {
			if ( is_array( $field ) && isset( $field['type'] ) && is_string( $field['type'] ) && false !== stripos( $field['type'], $type ) ) {
				return is_scalar( $field['value'] ?? null ) ? (string) $field['value'] : null;
			}
		}

		return null;
	}

	/**
	 * Build a personalized Tally link for a fulfillment record, pre-filling
	 * the hidden "fulfillment_id" field so the webhook can match the
	 * response back to it.
	 *
	 * @param string $form_url       Base Tally form URL from settings.
	 * @param int    $fulfillment_id Fulfillment record ID.
	 * @return string
	 */
	public static function build_form_link( $form_url, $fulfillment_id ) {
		if ( empty( $form_url ) ) {
			return '';
		}

		return add_query_arg( self::HIDDEN_FIELD_FULFILLMENT_ID, absint( $fulfillment_id ), $form_url );
	}
}
