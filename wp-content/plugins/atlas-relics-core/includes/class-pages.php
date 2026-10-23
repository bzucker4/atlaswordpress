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
	 * Site pages: slug => [ title, pattern slug ]. Every pattern here opens
	 * with its own H1, so these pages use the "page-no-title" template.
	 *
	 * @var array
	 */
	private static $pages = array(
		'begin'                   => array( 'Begin', 'atlas-relics/begin' ),
		'caves'                   => array( 'Caves', 'atlas-relics/caves' ),
		'essays'                  => array( 'Essays', 'atlas-relics/essays' ),
		'courses'                 => array( 'Courses', 'atlas-relics/courses' ),
		'four-stages'             => array( 'The Four Stages of Consciousness', 'atlas-relics/four-stages' ),
		'conscious-mirror-course' => array( 'The Conscious Mirror', 'atlas-relics/conscious-mirror-course' ),
		'vedic-life-advisor'      => array( 'Vedic Life Advisor', 'atlas-relics/vedic-life-advisor' ),
		'about'                   => array( 'About', 'atlas-relics/about' ),
	);

	/**
	 * Menu contents by location.
	 *
	 * @var array
	 */
	private static $menu_slugs = array(
		'primary' => array( 'begin', 'caves', 'essays', 'courses', 'vedic-life-advisor', 'about' ),
		'footer'  => array( 'about', 'essays', 'begin' ),
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

			$slugs = self::$menu_slugs[ $location ];

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

		$present = array();
		foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $item ) {
			$present[] = (int) $item->object_id;
		}

		foreach ( self::$menu_slugs[ $location ] as $slug ) {
			if ( empty( $page_ids[ $slug ] ) || in_array( (int) $page_ids[ $slug ], $present, true ) ) {
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

		update_option( $flag, 1 );
	}
}
