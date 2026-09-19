<?php
/**
 * Uninstall cleanup.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'atlas_relics_core_version' );
