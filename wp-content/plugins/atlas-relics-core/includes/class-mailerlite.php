<?php
/**
 * MailerLite API wrapper.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Thin wrapper around the MailerLite Connect API so no other class makes
 * an HTTP call or handles the API key directly.
 *
 * @see https://developers.mailerlite.com/docs/subscribers.html
 */
class Atlas_Relics_Core_MailerLite {

	const API_BASE = 'https://connect.mailerlite.com/api';

	/**
	 * Subscribe an email address, optionally into a specific group.
	 *
	 * @param string $email    Subscriber email.
	 * @param string $group_id MailerLite group ID, or '' for no group.
	 * @return true|WP_Error
	 */
	public static function subscribe( $email, $group_id = '' ) {
		$api_key = Atlas_Relics_Core_Settings::get( 'mailerlite_api_key' );

		if ( empty( $api_key ) ) {
			return new WP_Error(
				'atlas_relics_mailerlite_not_configured',
				__( 'MailerLite is not configured yet.', 'atlas-relics-core' )
			);
		}

		if ( ! is_email( $email ) ) {
			return new WP_Error(
				'atlas_relics_mailerlite_invalid_email',
				__( 'That doesn\'t look like a valid email address.', 'atlas-relics-core' )
			);
		}

		$body = array( 'email' => $email );

		if ( ! empty( $group_id ) ) {
			$body['groups'] = array( $group_id );
		}

		$response = wp_remote_post(
			self::API_BASE . '/subscribers',
			array(
				'timeout' => 15,
				'headers' => array(
					'Authorization' => 'Bearer ' . $api_key,
					'Content-Type'  => 'application/json',
					'Accept'        => 'application/json',
				),
				'body'    => wp_json_encode( $body ),
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$status = wp_remote_retrieve_response_code( $response );

		if ( $status < 200 || $status >= 300 ) {
			return new WP_Error(
				'atlas_relics_mailerlite_api_error',
				__( 'MailerLite could not add that subscriber right now.', 'atlas-relics-core' ),
				array( 'status' => $status )
			);
		}

		return true;
	}
}
