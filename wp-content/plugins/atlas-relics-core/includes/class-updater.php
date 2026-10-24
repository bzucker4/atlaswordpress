<?php
/**
 * One-click updates from GitHub.
 *
 * Pulls the Atlas Relics theme and this plugin from the public repository
 * and replaces the installed copies. Keeps one backup so a bad update can be
 * rolled back from the same screen. Content, settings and other plugins are
 * never touched.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin screen and updater for the theme and plugin.
 */
class Atlas_Relics_Core_Updater {

	const REPO       = 'bzucker4/atlaswordpress';
	const BRANCH     = 'main';
	const THEME_SLUG = 'atlas-relics';
	const PLUGIN_DIR = 'atlas-relics-core';
	const SHA_OPTION = 'atlas_relics_deployed_sha';
	const AUTO_OPT   = 'atlas_relics_auto_update';
	const CRON_HOOK  = 'atlas_relics_auto_update_check';

	/**
	 * Register hooks.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'menu' ) );
		add_action( 'admin_post_atlas_relics_update', array( __CLASS__, 'handle_update' ) );
		add_action( 'admin_post_atlas_relics_restore', array( __CLASS__, 'handle_restore' ) );
		add_action( 'admin_post_atlas_relics_auto', array( __CLASS__, 'handle_auto' ) );
		add_filter( 'cron_schedules', array( __CLASS__, 'schedules' ) );
		add_action( self::CRON_HOOK, array( __CLASS__, 'cron_check' ) );
		add_action( 'init', array( __CLASS__, 'sync_schedule' ) );
	}

	/**
	 * Add a 15 minute cron interval.
	 *
	 * @param array $schedules Existing schedules.
	 * @return array
	 */
	public static function schedules( $schedules ) {
		$schedules['atlas_fifteen_minutes'] = array(
			'interval' => 900,
			'display'  => __( 'Every 15 minutes', 'atlas-relics-core' ),
		);
		return $schedules;
	}

	/**
	 * Keep the cron event in step with the auto-update setting.
	 */
	public static function sync_schedule() {
		$scheduled = wp_next_scheduled( self::CRON_HOOK );
		if ( get_option( self::AUTO_OPT ) && ! $scheduled ) {
			wp_schedule_event( time() + 300, 'atlas_fifteen_minutes', self::CRON_HOOK );
		} elseif ( ! get_option( self::AUTO_OPT ) && $scheduled ) {
			wp_clear_scheduled_hook( self::CRON_HOOK );
		}
	}

	/**
	 * Scheduled check: update when GitHub has something newer.
	 */
	public static function cron_check() {
		if ( ! get_option( self::AUTO_OPT ) ) {
			return;
		}
		$latest = self::latest_sha();
		if ( is_string( $latest ) && get_option( self::SHA_OPTION ) !== $latest ) {
			self::run_update( $latest );
		}
	}

	/**
	 * Register the admin page under Tools.
	 */
	public static function menu() {
		add_management_page(
			__( 'Atlas Relics Updates', 'atlas-relics-core' ),
			__( 'Atlas Updates', 'atlas-relics-core' ),
			'manage_options',
			'atlas-relics-updates',
			array( __CLASS__, 'render' )
		);
	}

	/**
	 * Latest commit SHA on the branch, or a WP_Error.
	 *
	 * @return string|WP_Error
	 */
	public static function latest_sha() {
		$response = wp_remote_get(
			'https://api.github.com/repos/' . self::REPO . '/commits/' . self::BRANCH,
			array(
				'timeout' => 15,
				'headers' => array(
					'Accept'     => 'application/vnd.github.sha',
					'User-Agent' => 'atlas-relics-core-updater',
				),
			)
		);
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$code = wp_remote_retrieve_response_code( $response );
		$body = trim( wp_remote_retrieve_body( $response ) );
		if ( 200 !== $code || ! preg_match( '/^[0-9a-f]{40}$/', $body ) ) {
			return new WP_Error( 'atlas_sha', sprintf( /* translators: %d: HTTP status */ __( 'GitHub answered with status %d.', 'atlas-relics-core' ), $code ) );
		}
		return $body;
	}

	/**
	 * Download the branch, replace the theme and plugin, keep a backup.
	 *
	 * @param string $sha Commit SHA being deployed.
	 * @return true|WP_Error
	 */
	public static function run_update( $sha = '' ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		if ( ! WP_Filesystem() || ! $wp_filesystem ) {
			return new WP_Error( 'atlas_fs', __( 'WordPress could not get write access to the files.', 'atlas-relics-core' ) );
		}

		$zip = download_url( 'https://github.com/' . self::REPO . '/archive/refs/heads/' . self::BRANCH . '.zip', 180 );
		if ( is_wp_error( $zip ) ) {
			return $zip;
		}

		$work = trailingslashit( get_temp_dir() ) . 'atlas-update-' . wp_generate_password( 8, false );
		wp_mkdir_p( $work );
		$unzipped = unzip_file( $zip, $work );
		@unlink( $zip ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		if ( is_wp_error( $unzipped ) ) {
			$wp_filesystem->delete( $work, true );
			return $unzipped;
		}

		$roots = glob( $work . '/*', GLOB_ONLYDIR );
		$root  = $roots ? $roots[0] : '';
		$theme_src  = $root . '/wp-content/themes/' . self::THEME_SLUG;
		$plugin_src = $root . '/wp-content/plugins/' . self::PLUGIN_DIR;

		if ( ! $root || ! file_exists( $theme_src . '/style.css' ) || ! file_exists( $plugin_src . '/atlas-relics-core.php' ) ) {
			$wp_filesystem->delete( $work, true );
			return new WP_Error( 'atlas_pkg', __( 'The download did not contain the expected theme and plugin.', 'atlas-relics-core' ) );
		}

		$theme_dest  = trailingslashit( get_theme_root() ) . self::THEME_SLUG;
		$plugin_dest = trailingslashit( WP_PLUGIN_DIR ) . self::PLUGIN_DIR;
		$backup      = trailingslashit( WP_CONTENT_DIR ) . 'upgrade/atlas-relics-backup';

		// Keep exactly one backup: the version running right now.
		$wp_filesystem->delete( $backup, true );
		wp_mkdir_p( $backup );
		if ( is_dir( $theme_dest ) ) {
			copy_dir( $theme_dest, $backup . '/theme' );
		}
		if ( is_dir( $plugin_dest ) ) {
			copy_dir( $plugin_dest, $backup . '/plugin' );
		}

		// Theme: replace the folder so removed files disappear.
		$wp_filesystem->delete( $theme_dest, true );
		wp_mkdir_p( $theme_dest );
		$copied = copy_dir( $theme_src, $theme_dest );
		if ( is_wp_error( $copied ) ) {
			$wp_filesystem->delete( $theme_dest, true );
			wp_mkdir_p( $theme_dest );
			copy_dir( $backup . '/theme', $theme_dest );
			$wp_filesystem->delete( $work, true );
			return $copied;
		}

		// Plugin: overlay last, since this code is running from it.
		$copied = copy_dir( $plugin_src, $plugin_dest );
		$wp_filesystem->delete( $work, true );
		if ( is_wp_error( $copied ) ) {
			return $copied;
		}

		if ( $sha ) {
			update_option( self::SHA_OPTION, $sha, false );
		}
		update_option( 'atlas_relics_deployed_at', time(), false );
		self::purge_caches();
		return true;
	}

	/**
	 * Put the previous version back.
	 *
	 * @return true|WP_Error
	 */
	public static function run_restore() {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		if ( ! WP_Filesystem() || ! $wp_filesystem ) {
			return new WP_Error( 'atlas_fs', __( 'WordPress could not get write access to the files.', 'atlas-relics-core' ) );
		}
		$backup = trailingslashit( WP_CONTENT_DIR ) . 'upgrade/atlas-relics-backup';
		if ( ! is_dir( $backup . '/theme' ) ) {
			return new WP_Error( 'atlas_nobackup', __( 'There is no backup to restore.', 'atlas-relics-core' ) );
		}
		$theme_dest = trailingslashit( get_theme_root() ) . self::THEME_SLUG;
		$wp_filesystem->delete( $theme_dest, true );
		wp_mkdir_p( $theme_dest );
		$result = copy_dir( $backup . '/theme', $theme_dest );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
		if ( is_dir( $backup . '/plugin' ) ) {
			copy_dir( $backup . '/plugin', trailingslashit( WP_PLUGIN_DIR ) . self::PLUGIN_DIR );
		}
		delete_option( self::SHA_OPTION );
		self::purge_caches();
		return true;
	}

	/**
	 * Clear WordPress and SiteGround caches.
	 */
	private static function purge_caches() {
		wp_cache_flush();
		if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
			sg_cachepress_purge_cache();
		}
		if ( function_exists( 'opcache_reset' ) ) {
			@opcache_reset(); // phpcs:ignore WordPress.PHP.NoSilencedErrors
		}
	}

	/**
	 * Handle the update button.
	 */
	public static function handle_update() {
		check_admin_referer( 'atlas_relics_update' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to do this.', 'atlas-relics-core' ) );
		}
		$latest = self::latest_sha();
		$sha    = is_string( $latest ) ? $latest : '';
		$result = self::run_update( $sha );
		self::back( is_wp_error( $result ) ? 'error' : 'updated', is_wp_error( $result ) ? $result->get_error_message() : '' );
	}

	/**
	 * Handle the restore button.
	 */
	public static function handle_restore() {
		check_admin_referer( 'atlas_relics_restore' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to do this.', 'atlas-relics-core' ) );
		}
		$result = self::run_restore();
		self::back( is_wp_error( $result ) ? 'error' : 'restored', is_wp_error( $result ) ? $result->get_error_message() : '' );
	}

	/**
	 * Handle the automatic updates toggle.
	 */
	public static function handle_auto() {
		check_admin_referer( 'atlas_relics_auto' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to do this.', 'atlas-relics-core' ) );
		}
		update_option( self::AUTO_OPT, empty( $_POST['auto'] ) ? 0 : 1, false );
		self::back( 'saved' );
	}

	/**
	 * Redirect back to the admin page with a status.
	 *
	 * @param string $status  Status key.
	 * @param string $message Optional error text.
	 */
	private static function back( $status, $message = '' ) {
		$args = array(
			'page'         => 'atlas-relics-updates',
			'atlas_status' => $status,
		);
		if ( $message ) {
			$args['atlas_msg'] = rawurlencode( $message );
		}
		wp_safe_redirect( add_query_arg( $args, admin_url( 'tools.php' ) ) );
		exit;
	}

	/**
	 * Render the admin page.
	 */
	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$theme    = wp_get_theme( self::THEME_SLUG );
		$latest   = self::latest_sha();
		$deployed = (string) get_option( self::SHA_OPTION, '' );
		$auto     = (bool) get_option( self::AUTO_OPT );
		$backup   = is_dir( trailingslashit( WP_CONTENT_DIR ) . 'upgrade/atlas-relics-backup/theme' );
		$status   = isset( $_GET['atlas_status'] ) ? sanitize_key( wp_unslash( $_GET['atlas_status'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		$msg      = isset( $_GET['atlas_msg'] ) ? sanitize_text_field( rawurldecode( wp_unslash( $_GET['atlas_msg'] ) ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

		echo '<div class="wrap"><h1>' . esc_html__( 'Atlas Relics Updates', 'atlas-relics-core' ) . '</h1>';

		if ( 'updated' === $status ) {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Updated. The theme and plugin now match GitHub, and the cache was cleared.', 'atlas-relics-core' ) . '</p></div>';
		} elseif ( 'restored' === $status ) {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'The previous version is back.', 'atlas-relics-core' ) . '</p></div>';
		} elseif ( 'saved' === $status ) {
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Saved.', 'atlas-relics-core' ) . '</p></div>';
		} elseif ( 'error' === $status ) {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'The update did not finish:', 'atlas-relics-core' ) . ' ' . esc_html( $msg ) . '</p></div>';
		}

		echo '<table class="widefat striped" style="max-width:640px"><tbody>';
		echo '<tr><td>' . esc_html__( 'Theme version', 'atlas-relics-core' ) . '</td><td>' . esc_html( $theme->exists() ? $theme->get( 'Version' ) : '-' ) . '</td></tr>';
		echo '<tr><td>' . esc_html__( 'Plugin version', 'atlas-relics-core' ) . '</td><td>' . esc_html( ATLAS_RELICS_CORE_VERSION ) . '</td></tr>';
		echo '<tr><td>' . esc_html__( 'Installed from commit', 'atlas-relics-core' ) . '</td><td>' . esc_html( $deployed ? substr( $deployed, 0, 7 ) : __( 'not recorded yet', 'atlas-relics-core' ) ) . '</td></tr>';
		echo '<tr><td>' . esc_html__( 'Latest on GitHub', 'atlas-relics-core' ) . '</td><td>' . esc_html( is_string( $latest ) ? substr( $latest, 0, 7 ) : $latest->get_error_message() ) . '</td></tr>';
		echo '</tbody></table>';

		if ( is_string( $latest ) ) {
			$current = ( $deployed === $latest );
			echo '<p><strong>' . esc_html( $current ? __( 'Up to date.', 'atlas-relics-core' ) : __( 'An update is available.', 'atlas-relics-core' ) ) . '</strong></p>';
		}

		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:1em 0">';
		wp_nonce_field( 'atlas_relics_update' );
		echo '<input type="hidden" name="action" value="atlas_relics_update" />';
		submit_button( __( 'Update from GitHub', 'atlas-relics-core' ), 'primary', 'submit', false );
		echo '</form>';

		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:1em 0">';
		wp_nonce_field( 'atlas_relics_auto' );
		echo '<input type="hidden" name="action" value="atlas_relics_auto" />';
		echo '<label><input type="checkbox" name="auto" value="1" ' . checked( $auto, true, false ) . ' /> ' . esc_html__( 'Update automatically (checks every 15 minutes)', 'atlas-relics-core' ) . '</label> ';
		submit_button( __( 'Save', 'atlas-relics-core' ), 'secondary', 'submit', false );
		echo '</form>';

		if ( $backup ) {
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="margin:1em 0">';
			wp_nonce_field( 'atlas_relics_restore' );
			echo '<input type="hidden" name="action" value="atlas_relics_restore" />';
			submit_button( __( 'Restore the previous version', 'atlas-relics-core' ), 'secondary', 'submit', false );
			echo '</form>';
		}

		echo '<p class="description">' . esc_html__( 'Replaces the Atlas Relics theme and this plugin with the latest from GitHub. Your pages, settings and other plugins are not touched. One backup of the previous version is kept.', 'atlas-relics-core' ) . '</p>';
		echo '</div>';
	}
}
