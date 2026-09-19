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
 * Phase 1 only wires security hardening and setup scaffolding. Fulfillment
 * automation, order/reminder workflows, and the admin operations dashboard
 * are added in later phases as their own classes registered here.
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
	}

	/**
	 * Activation callback: record the installed version.
	 */
	public static function activate() {
		add_option( 'atlas_relics_core_version', ATLAS_RELICS_CORE_VERSION );
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
