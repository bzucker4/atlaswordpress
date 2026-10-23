<?php
/**
 * Legacy URL redirects.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sends URLs from the previous Atlas Relics site, and from earlier phases of
 * this one, to their new homes with a permanent redirect. Paths are matched
 * exactly (after trimming slashes) and only on the front end.
 */
class Atlas_Relics_Core_Redirects {

	/**
	 * Old path => new path (may include a #fragment) or a full URL.
	 *
	 * @var array
	 */
	private static $map = array(
		'store'            => '/caves/',
		'begin-here'       => '/begin/',
		'start-here'       => '/begin/',
		'conscious-mirror' => '/conscious-mirror-course/',
		'pattern-map'      => '/caves/',
		'relics'           => '/caves/',
		'journal'          => 'https://medium.com/the-conscious-path',
		'essays'           => 'https://medium.com/the-conscious-path',
		'caves/control'    => '/caves/#control',
		'caves/desire'     => '/caves/#desire',
		'caves/identity'   => '/caves/#identity',
		'caves/silence'    => '/caves/#silence',
		'caves/descent'    => '/caves/#descent',
		'go/rhythm'        => '/caves/#silence',
		'go/dejavu'        => '/caves/#identity',
		'go/invisible'     => '/caves/#descent',
		'go/home'          => '/caves/#identity',
	);

	/**
	 * Hook into the front-end request.
	 */
	public function __construct() {
		add_action( 'template_redirect', array( $this, 'maybe_redirect' ), 1 );
	}

	/**
	 * Redirect when the request path is a known legacy path.
	 */
	public function maybe_redirect() {
		if ( is_admin() ) {
			return;
		}

		$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$path    = trim( (string) $request, '/' );

		// Respect subdirectory installs.
		$base = trim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		if ( '' !== $base && 0 === strpos( $path, $base . '/' ) ) {
			$path = substr( $path, strlen( $base ) + 1 );
		}

		/**
		 * Filters the legacy redirect map.
		 *
		 * @param array $map Old path => new path.
		 */
		$map = apply_filters( 'atlas_relics_redirects', self::$map );

		if ( ! isset( $map[ $path ] ) ) {
			return;
		}

		$target = 0 === strpos( $map[ $path ], 'http' ) ? $map[ $path ] : home_url( $map[ $path ] );

		// Targets come from the map above (or a site-owner filter), never from the request.
		wp_redirect( $target, 301 ); // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		exit;
	}
}
