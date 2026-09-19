<?php
/**
 * Structural setup scaffolding.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Phase 1 scaffolding for site structure.
 *
 * This class intentionally stays minimal in Phase 1: it exists so later
 * phases have a single, obvious place to register the custom post types,
 * taxonomies, and admin dashboard pages that the storefront (Phase 2) and
 * operations automation (Phase 3) need, instead of scattering `init` hooks
 * across the codebase as the plugin grows.
 */
class Atlas_Relics_Core_Setup {

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_content_types' ) );
	}

	/**
	 * Register custom post types and taxonomies.
	 *
	 * Empty in Phase 1 on purpose — Phase 2 adds the Beacons product-import
	 * data model here, and Phase 3 adds fulfillment/order-status types.
	 */
	public function register_content_types() {
		/**
		 * Fires after Atlas Relics Core has registered its content types,
		 * so later phases (or the theme) can hook in without editing core.
		 */
		do_action( 'atlas_relics_core_registered_content_types' );
	}
}
