<?php
/**
 * Plugin Name: Atlas Relics Core
 * Plugin URI: https://atlasrelics.com
 * Description: Companion plugin for the Atlas Relics theme. Provides security hardening, storefront scaffolding (bundles, Beacons import, MailerLite signup), and will grow into fulfillment automation and the admin operations dashboard in Phase 3.
 * Version: 0.2.0
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * Requires Plugins: woocommerce
 * Author: Atlas Relics
 * Author URI: https://atlasrelics.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: atlas-relics-core
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ATLAS_RELICS_CORE_VERSION', '0.2.0' );
define( 'ATLAS_RELICS_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'ATLAS_RELICS_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'ATLAS_RELICS_CORE_FILE', __FILE__ );

require_once ATLAS_RELICS_CORE_PATH . 'includes/class-atlas-relics-core.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-security.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-setup.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-pages.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-settings.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-seo.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-mailerlite.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-newsletter.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-bundles.php';
require_once ATLAS_RELICS_CORE_PATH . 'includes/class-beacons-importer.php';

/**
 * Boot the plugin once all plugins are loaded.
 */
function atlas_relics_core_boot() {
	Atlas_Relics_Core::instance();
}
add_action( 'plugins_loaded', 'atlas_relics_core_boot' );

register_activation_hook( __FILE__, array( 'Atlas_Relics_Core', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Atlas_Relics_Core', 'deactivate' ) );
