<?php
/**
 * Newsletter signup handling.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the AJAX submission behind the newsletter signup form (see the
 * "Newsletter Signup" pattern in the theme) and routes each submission to
 * the MailerLite group configured for that segment in Settings → Atlas
 * Relics, so the same form markup can be reused on the footer, Start Here,
 * and Conscious Mirror pages while still segmenting the audience.
 */
class Atlas_Relics_Core_Newsletter {

	/**
	 * Segment keys allowed from the client, mapped to their settings key.
	 *
	 * @var array
	 */
	private $segments = array(
		'footer'           => 'mailerlite_group_footer',
		'start-here'       => 'mailerlite_group_start_here',
		'conscious-mirror' => 'mailerlite_group_conscious_mirror',
	);

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
		add_action( 'wp_ajax_atlas_relics_newsletter_signup', array( $this, 'handle_signup' ) );
		add_action( 'wp_ajax_nopriv_atlas_relics_newsletter_signup', array( $this, 'handle_signup' ) );
	}

	/**
	 * Enqueue the small fetch()-based submit handler and localize its config.
	 */
	public function enqueue_script() {
		wp_enqueue_script(
			'atlas-relics-newsletter',
			ATLAS_RELICS_CORE_URL . 'assets/js/newsletter.js',
			array(),
			ATLAS_RELICS_CORE_VERSION,
			true
		);

		wp_localize_script(
			'atlas-relics-newsletter',
			'atlasRelicsNewsletter',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'atlas_relics_newsletter_signup' ),
			)
		);
	}

	/**
	 * AJAX callback: validate, resolve the segment's group ID, subscribe.
	 */
	public function handle_signup() {
		check_ajax_referer( 'atlas_relics_newsletter_signup', 'nonce' );

		$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$segment = isset( $_POST['segment'] ) ? sanitize_key( wp_unslash( $_POST['segment'] ) ) : 'footer';

		if ( ! is_email( $email ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Please enter a valid email address.', 'atlas-relics-core' ) ),
				400
			);
		}

		if ( ! isset( $this->segments[ $segment ] ) ) {
			$segment = 'footer';
		}

		$group_id = Atlas_Relics_Core_Settings::get( $this->segments[ $segment ] );
		$result   = Atlas_Relics_Core_MailerLite::subscribe( $email, $group_id );

		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ), 502 );
		}

		wp_send_json_success(
			array( 'message' => __( 'You\'re in. Look for The Weekly Mirror in your inbox.', 'atlas-relics-core' ) )
		);
	}
}
