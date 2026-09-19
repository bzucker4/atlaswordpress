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

		add_settings_section(
			'atlas_relics_core_mailerlite',
			__( 'MailerLite', 'atlas-relics-core' ),
			function () {
				echo '<p>' . esc_html__( 'Used by the newsletter signup form. Create an API key at MailerLite → Integrations → API, and group IDs at MailerLite → Subscribers → Groups.', 'atlas-relics-core' ) . '</p>';
			},
			'atlas-relics-core'
		);

		$fields = array(
			'mailerlite_api_key'             => __( 'API Key', 'atlas-relics-core' ),
			'mailerlite_group_footer'        => __( 'Footer Signup Group ID', 'atlas-relics-core' ),
			'mailerlite_group_start_here'    => __( 'Start Here Group ID', 'atlas-relics-core' ),
			'mailerlite_group_conscious_mirror' => __( 'Conscious Mirror Group ID', 'atlas-relics-core' ),
		);

		foreach ( $fields as $field_key => $label ) {
			add_settings_field(
				$field_key,
				$label,
				array( $this, 'render_text_field' ),
				'atlas-relics-core',
				'atlas_relics_core_mailerlite',
				array(
					'key'  => $field_key,
					'type' => 'mailerlite_api_key' === $field_key ? 'password' : 'text',
				)
			);
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
