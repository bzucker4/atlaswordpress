<?php
/**
 * Latest essays from the Medium publication, cached.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetch and cache the publication feed.
 *
 * Returns an empty array on any failure so the theme can fall back to its
 * hand written list.
 *
 * @param int $limit Number of posts.
 * @return array[] Each item has title, url, date and summary.
 */
function atlas_relics_core_medium_posts( $limit = 4 ) {
	$key    = 'atlas_relics_medium_posts';
	$cached = get_transient( $key );

	if ( is_array( $cached ) ) {
		return array_slice( $cached, 0, $limit );
	}

	$posts = array();

	if ( ! function_exists( 'fetch_feed' ) ) {
		require_once ABSPATH . WPINC . '/feed.php';
	}

	$feed = fetch_feed( 'https://medium.com/feed/the-conscious-path' );

	if ( ! is_wp_error( $feed ) ) {
		foreach ( $feed->get_items( 0, 10 ) as $item ) {
			$url = $item->get_link();
			if ( ! $url ) {
				continue;
			}

			$summary = wp_trim_words( wp_strip_all_tags( $item->get_description() ), 24 );
			$posts[] = array(
				'title'   => wp_strip_all_tags( $item->get_title() ),
				'url'     => esc_url_raw( strtok( $url, '?' ) ),
				'date'    => $item->get_date( 'j M Y' ),
				'summary' => $summary,
			);
		}
	}

	// Cache failures briefly so a Medium outage does not slow every page view.
	set_transient( $key, $posts, $posts ? 6 * HOUR_IN_SECONDS : 15 * MINUTE_IN_SECONDS );

	return array_slice( $posts, 0, $limit );
}
