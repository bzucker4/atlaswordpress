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
 * posts page, and builds the primary/footer navigation menus, all
 * idempotently, so re-running activation (or a future deploy) never
 * duplicates content or clobbers an admin's manual changes.
 *
 * Runs once from Atlas_Relics_Core::activate(); there are no runtime
 * hooks in this class.
 */
class Atlas_Relics_Core_Pages {

	/**
	 * Site pages: slug => [ title, pattern slug ]. Every pattern here opens
	 * with its own H1, so these pages use the "page-no-title" template.
	 *
	 * @var array
	 */
	private static $pages = array(
		'begin'                   => array( 'Begin', 'atlas-relics/begin' ),
		'caves'                   => array( 'Caves', 'atlas-relics/caves' ),
		'courses'                 => array( 'Courses', 'atlas-relics/courses' ),
		'four-stages'             => array( 'The Four Stages of Consciousness', 'atlas-relics/four-stages' ),
		'conscious-mirror-course' => array( 'The Conscious Mirror', 'atlas-relics/conscious-mirror-course' ),
		'vedic-life-advisor'      => array( 'Vedic Life Advisor', 'atlas-relics/vedic-life-advisor' ),
		'about'                   => array( 'About', 'atlas-relics/about' ),
		'shop'                    => array( 'Shop', 'atlas-relics/shop' ),
	);

	/**
	 * Menu contents by location.
	 *
	 * @var array
	 */
	private static $menu_slugs = array(
		'primary' => array( 'begin', 'caves', 'courses', 'link:essays', 'vedic-life-advisor', 'about' ),
		'footer'  => array( 'about', 'begin' ),
	);

	/**
	 * Custom (non-page) menu links, referenced from the menu lists above as
	 * "link:<key>": key => [ title, url ].
	 *
	 * @var array
	 */
	private static $menu_links = array(
		'essays' => array( 'Essays', 'https://medium.com/the-conscious-path' ),
	);

	/**
	 * Add one menu entry: a page, or a "link:<key>" custom link.
	 *
	 * @param int    $menu_id  Menu term ID.
	 * @param string $entry    Page slug or "link:<key>".
	 * @param array  $page_ids slug => page ID map.
	 */
	private static function add_menu_entry( $menu_id, $entry, array $page_ids ) {
		if ( 0 === strpos( $entry, 'link:' ) ) {
			$key = substr( $entry, 5 );
			if ( empty( self::$menu_links[ $key ] ) ) {
				return;
			}

			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-type'   => 'custom',
					'menu-item-title'  => self::$menu_links[ $key ][0],
					'menu-item-url'    => self::$menu_links[ $key ][1],
					'menu-item-status' => 'publish',
				)
			);
			return;
		}

		if ( empty( $page_ids[ $entry ] ) ) {
			return;
		}

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-object-id' => $page_ids[ $entry ],
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}

	/**
	 * Create any default page that is missing, once per plugin version.
	 * Used after a one-click update, which does not re-run activation.
	 * Menus and reading settings are left alone.
	 */
	public static function ensure_pages() {
		if ( get_option( 'atlas_relics_core_pages_version' ) === ATLAS_RELICS_CORE_VERSION ) {
			return;
		}

		foreach ( self::$pages as $slug => $definition ) {
			self::get_or_create_page( $slug, $definition[0], $definition[1] );
		}

		update_option( 'atlas_relics_core_pages_version', ATLAS_RELICS_CORE_VERSION );
	}

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
		self::build_menu( 'primary', __( 'Primary', 'atlas-relics-core' ), $page_ids );
		self::build_menu( 'footer', __( 'Footer', 'atlas-relics-core' ), $page_ids );
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
				'page_template' => $pattern_slug ? 'page-no-title' : '',
			),
			true
		);

		return is_wp_error( $page_id ) ? 0 : $page_id;
	}

	/**
	 * Set the Journal as the posts page, but only if the site is still on
	 * WordPress's out-of-the-box Reading settings, never override a
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
	 */
	private static function build_menu( $location, $menu_name, array $page_ids ) {
		$existing_menu = wp_get_nav_menu_object( $menu_name );

		if ( $existing_menu ) {
			$menu_id = $existing_menu->term_id;
		} else {
			$menu_id = wp_create_nav_menu( $menu_name );

			if ( is_wp_error( $menu_id ) ) {
				return;
			}

			foreach ( self::$menu_slugs[ $location ] as $entry ) {
				self::add_menu_entry( $menu_id, $entry, $page_ids );
			}
		}

		self::append_missing_items( $menu_id, $location, $page_ids );

		$locations = get_theme_mod( 'nav_menu_locations', array() );

		if ( empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}

	/**
	 * One time per menu location, add any site pages missing from a menu
	 * that already existed (older installs). Guarded by an option so an
	 * admin who later removes an item is never overridden.
	 *
	 * @param int    $menu_id  Menu term ID.
	 * @param string $location Menu location.
	 * @param array  $page_ids slug => page ID map.
	 */
	private static function append_missing_items( $menu_id, $location, array $page_ids ) {
		$flag = 'atlas_relics_menu_synced_' . $location;

		if ( get_option( $flag ) ) {
			return;
		}

		$present_ids  = array();
		$present_urls = array();
		foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
			$present_ids[]  = (int) $item->object_id;
			$present_urls[] = untrailingslashit( $item->url );
		}

		foreach ( self::$menu_slugs[ $location ] as $entry ) {
			if ( 0 === strpos( $entry, 'link:' ) ) {
				$link = self::$menu_links[ substr( $entry, 5 ) ] ?? null;
				if ( ! $link || in_array( untrailingslashit( $link[1] ), $present_urls, true ) ) {
					continue;
				}
			} elseif ( empty( $page_ids[ $entry ] ) || in_array( (int) $page_ids[ $entry ], $present_ids, true ) ) {
				continue;
			}

			self::add_menu_entry( $menu_id, $entry, $page_ids );
		}

		update_option( $flag, 1 );
	}
}
