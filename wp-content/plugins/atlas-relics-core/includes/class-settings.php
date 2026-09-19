<?php
/**
 * Plugin settings screen.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A single Settings API page (Settings → Atlas Relics) holding the API
 * keys and segmentation IDs other classes need, so secrets live in the
 * options table (never in committed code) and have one place to be
 * rotated. Values are read via Atlas_Relics_Core_Settings::get().
 */
class Atlas_Relics_Core_Settings {

	const OPTION_KEY = 'atlas_relics_core_settings';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_settings_page' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	/**
	 * Get a single setting value.
	 *
	 * @param string $key     Setting key.
	 * @param string $default Fallback if unset.
	 * @return string
	 */
	public static function get( $key, $default = '' ) {
		$settings = get_option( self::OPTION_KEY, array() );
		return isset( $settings[ $key ] ) && '' !== $settings[ $key ] ? $settings[ $key ] : $default;
	}

	/**
	 * Add the "Atlas Relics" settings page under Settings.
	 */
	public function register_settings_page() {
		add_options_page(
			__( 'Atlas Relics', 'atlas-relics-core' ),
			__( 'Atlas Relics', 'atlas-relics-core' ),
			'manage_options',
			'atlas-relics-core',
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Register the settings field group.
	 */
	public function register_settings() {
		register_setting(
			'atlas_relics_core_settings_group',
			self::OPTION_KEY,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'sanitize_settings' ),
				'default'           => array(),
			)
		);

		$sections = array(
			'atlas_relics_core_mailerlite'   => array(
				'label'       => __( 'MailerLite', 'atlas-relics-core' ),
				'description' => __( 'Used by the newsletter signup form. Create an API key at MailerLite → Integrations → API, and group IDs at MailerLite → Subscribers → Groups.', 'atlas-relics-core' ),
				'fields'      => array(
					'mailerlite_api_key'                => array( __( 'API Key', 'atlas-relics-core' ), 'password' ),
					'mailerlite_group_footer'           => array( __( 'Footer Signup Group ID', 'atlas-relics-core' ), 'text' ),
					'mailerlite_group_start_here'       => array( __( 'Start Here Group ID', 'atlas-relics-core' ), 'text' ),
					'mailerlite_group_conscious_mirror' => array( __( 'Conscious Mirror Group ID', 'atlas-relics-core' ), 'text' ),
				),
			),
			'atlas_relics_core_tally'        => array(
				'label'       => __( 'Tally', 'atlas-relics-core' ),
				'description' => __( 'Used for the Conscious Mirror and Pattern Map questionnaires. Create a webhook on each Tally form pointing to the URL shown below, with the same secret entered here.', 'atlas-relics-core' ),
				'fields'      => array(
					'tally_webhook_secret'         => array( __( 'Webhook Signing Secret', 'atlas-relics-core' ), 'password' ),
					'tally_conscious_mirror_form_url' => array( __( 'Conscious Mirror Form URL', 'atlas-relics-core' ), 'text' ),
					'tally_pattern_map_form_url'    => array( __( 'Pattern Map Form URL', 'atlas-relics-core' ), 'text' ),
				),
			),
			'atlas_relics_core_fulfillment'  => array(
				'label'       => __( 'Fulfillment', 'atlas-relics-core' ),
				'description' => __( 'Controls the automated reminder emails and admin notifications in Atlas Relics Ops.', 'atlas-relics-core' ),
				'fields'      => array(
					'fulfillment_notify_email' => array( __( 'Admin Notification Email', 'atlas-relics-core' ), 'text' ),
					'fulfillment_reminder_days' => array( __( 'Reminder After (days)', 'atlas-relics-core' ), 'text' ),
				),
			),
		);

		foreach ( $sections as $section_key => $section ) {
			add_settings_section(
				$section_key,
				$section['label'],
				function () use ( $section, $section_key ) {
					echo '<p>' . esc_html( $section['description'] ) . '</p>';
					if ( 'atlas_relics_core_tally' === $section_key ) {
						printf(
							'<p><code>%s</code></p>',
							esc_html( rest_url( 'atlas-relics/v1/tally-webhook' ) )
						);
					}
				},
				'atlas-relics-core'
			);

			foreach ( $section['fields'] as $field_key => $field ) {
				add_settings_field(
					$field_key,
					$field[0],
					array( $this, 'render_text_field' ),
					'atlas-relics-core',
					$section_key,
					array(
						'key'  => $field_key,
						'type' => $field[1],
					)
				);
			}
		}
	}

	/**
	 * Render a single text/password field bound to the settings array.
	 *
	 * @param array $args Field args (key, type).
	 */
	public function render_text_field( $args ) {
		$value = self::get( $args['key'] );
		printf(
			'<input type="%1$s" class="regular-text" name="%2$s[%3$s]" value="%4$s" autocomplete="off" />',
			esc_attr( $args['type'] ),
			esc_attr( self::OPTION_KEY ),
			esc_attr( $args['key'] ),
			esc_attr( $value )
		);
	}

	/**
	 * Sanitize the settings array on save.
	 *
	 * @param array $input Raw posted values.
	 * @return array
	 */
	public function sanitize_settings( $input ) {
		$clean = array();

		if ( ! is_array( $input ) ) {
			return $clean;
		}

		foreach ( $input as $key => $value ) {
			$clean[ sanitize_key( $key ) ] = sanitize_text_field( $value );
		}

		return $clean;
	}

	/**
	 * Render the settings page shell.
	 */
	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Atlas Relics', 'atlas-relics-core' ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'atlas_relics_core_settings_group' );
				do_settings_sections( 'atlas-relics-core' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
