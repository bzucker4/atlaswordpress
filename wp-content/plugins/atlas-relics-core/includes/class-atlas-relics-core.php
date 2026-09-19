<?php
/**
 * Main plugin bootstrap class.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Singleton that wires up the plugin's feature classes.
 *
 * Fulfillment automation, order/reminder workflows, and the admin
 * operations dashboard are added in Phase 3 as their own classes
 * registered here, following the same pattern.
 */
final class Atlas_Relics_Core {

	/**
	 * Singleton instance.
	 *
	 * @var Atlas_Relics_Core|null
	 */
	private static $instance = null;

	/**
	 * Get (and lazily create) the singleton instance.
	 *
	 * @return Atlas_Relics_Core
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Wire up feature classes. Private: use instance().
	 */
	private function __construct() {
		load_plugin_textdomain( 'atlas-relics-core', false, dirname( plugin_basename( ATLAS_RELICS_CORE_FILE ) ) . '/languages' );

		new Atlas_Relics_Core_Security();
		new Atlas_Relics_Core_Setup();
		new Atlas_Relics_Core_Settings();
		new Atlas_Relics_Core_SEO();
		new Atlas_Relics_Core_Newsletter();

		// Everything below genuinely depends on WooCommerce being active
		// (product objects, cart, order data) rather than merely declaring
		// it in "Requires Plugins" — keep the guard so a WooCommerce
		// deactivation degrades gracefully instead of fataling.
		if ( class_exists( 'WooCommerce' ) ) {
			new Atlas_Relics_Core_Bundles();
			new Atlas_Relics_Core_Beacons_Importer();
		}
	}

	/**
	 * Activation callback: record the installed version and scaffold the
	 * Phase 2 journey pages and navigation.
	 */
	public static function activate() {
		add_option( 'atlas_relics_core_version', ATLAS_RELICS_CORE_VERSION );
		Atlas_Relics_Core_Pages::create_default_content();
		flush_rewrite_rules();
	}

	/**
	 * Deactivation callback: flush rewrite rules cleanly.
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	/**
	 * Prevent cloning of the singleton.
	 */
	private function __clone() {}

	/**
	 * Prevent unserializing of the singleton.
	 */
	public function __wakeup() {
		throw new \Exception( 'Cannot unserialize a singleton.' );
	}
}
