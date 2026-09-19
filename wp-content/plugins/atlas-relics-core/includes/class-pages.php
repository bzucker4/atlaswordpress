<?php
/**
 * Default page and navigation scaffolding.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the Phase 2 journey pages, sets up the Journal as the site's
 * posts page, and builds the primary/footer navigation menus — all
 * idempotently, so re-running activation (or a future deploy) never
 * duplicates content or clobbers an admin's manual changes.
 *
 * Runs once from Atlas_Relics_Core::activate(); there are no runtime
 * hooks in this class.
 */
class Atlas_Relics_Core_Pages {

	/**
	 * Journey pages: slug => [ title, pattern slug or null ].
	 *
	 * @var array
	 */
	private static $pages = array(
		'start-here'       => array( 'Start Here', 'atlas-relics/start-here' ),
		'conscious-mirror' => array( 'Conscious Mirror', 'atlas-relics/conscious-mirror' ),
		'caves'            => array( 'Caves', 'atlas-relics/caves' ),
		'relics'           => array( 'Relics', 'atlas-relics/relics' ),
		'pattern-map'      => array( 'Pattern Map', 'atlas-relics/pattern-map' ),
		'about'            => array( 'About', 'atlas-relics/about' ),
	);

	/**
	 * Create default pages, wire up the Journal as the posts page, and
	 * build the navigation menus. Safe to call on every activation.
	 */
	public static function create_default_content() {
		$page_ids = array();

		foreach ( self::$pages as $slug => $definition ) {
			$page_ids[ $slug ] = self::get_or_create_page( $slug, $definition[0], $definition[1] );
		}

		$page_ids['home']    = self::get_or_create_page( 'home', __( 'Home', 'atlas-relics-core' ), null );
		$page_ids['journal'] = self::get_or_create_page( 'journal', __( 'Journal', 'atlas-relics-core' ), null );

		self::maybe_configure_reading_settings( $page_ids['home'], $page_ids['journal'] );
		self::build_menu( 'primary', __( 'Primary', 'atlas-relics-core' ), $page_ids, true );
		self::build_menu( 'footer', __( 'Footer', 'atlas-relics-core' ), $page_ids, false );
	}

	/**
	 * Get an existing page by slug, or create it.
	 *
	 * @param string      $slug         Page slug.
	 * @param string      $title        Page title (used only when creating).
	 * @param string|null $pattern_slug Registered pattern slug to use as content, or null for empty content.
	 * @return int Page ID.
	 */
	private static function get_or_create_page( $slug, $title, $pattern_slug ) {
		$existing = get_page_by_path( $slug );

		if ( $existing instanceof WP_Post ) {
			return $existing->ID;
		}

		$content = $pattern_slug ? '<!-- wp:pattern {"slug":"' . $pattern_slug . '"} /-->' : '';

		$page_id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_content' => $content,
			),
			true
		);

		return is_wp_error( $page_id ) ? 0 : $page_id;
	}

	/**
	 * Set the Journal as the posts page, but only if the site is still on
	 * WordPress's out-of-the-box Reading settings — never override a
	 * deliberate admin configuration.
	 *
	 * @param int $home_id    "Home" page ID.
	 * @param int $journal_id "Journal" page ID.
	 */
	private static function maybe_configure_reading_settings( $home_id, $journal_id ) {
		$already_configured = 'page' === get_option( 'show_on_front' ) && get_option( 'page_on_front' );

		if ( $already_configured || ! $home_id || ! $journal_id ) {
			return;
		}

		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home_id );
		update_option( 'page_for_posts', $journal_id );
	}

	/**
	 * Create a nav menu (if it doesn't already exist) and assign it to a
	 * theme location.
	 *
	 * @param string $location  Registered nav menu location (see functions.php).
	 * @param string $menu_name Menu display name.
	 * @param array  $page_ids  slug => page ID map.
	 * @param bool   $full      True for the full journey menu, false for a shorter footer set.
	 */
	private static function build_menu( $location, $menu_name, array $page_ids, $full ) {
		$existing_menu = wp_get_nav_menu_object( $menu_name );

		if ( $existing_menu ) {
			$menu_id = $existing_menu->term_id;
		} else {
			$menu_id = wp_create_nav_menu( $menu_name );

			if ( is_wp_error( $menu_id ) ) {
				return;
			}

			$slugs = $full
				? array( 'start-here', 'conscious-mirror', 'caves', 'relics', 'pattern-map', 'journal', 'about' )
				: array( 'about', 'journal', 'start-here' );

			foreach ( $slugs as $slug ) {
				if ( empty( $page_ids[ $slug ] ) ) {
					continue;
				}

				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-object-id' => $page_ids[ $slug ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}

			if ( $full && function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-object-id' => wc_get_page_id( 'shop' ),
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
					)
				);
			}
		}

		$locations = get_theme_mod( 'nav_menu_locations', array() );

		if ( empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
}
