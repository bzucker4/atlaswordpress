<?php
/**
 * Baseline security hardening.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Applies conservative, non-breaking security hardening that every phase of
 * the project relies on. Nothing here disables core functionality that
 * later phases (WooCommerce, REST-based integrations) will need — it only
 * removes information disclosure and unused legacy attack surface.
 */
class Atlas_Relics_Core_Security {

	/**
	 * Register hooks.
	 */
	public function __construct() {
		// Reduce version fingerprinting.
		add_filter( 'the_generator', '__return_empty_string' );
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'style_loader_src', array( $this, 'remove_version_query_arg' ), 9999 );
		add_filter( 'script_loader_src', array( $this, 'remove_version_query_arg' ), 9999 );

		// Remove the REST API "self" author/login enumeration exposed via ?author=N.
		add_filter( 'rest_endpoints', array( $this, 'restrict_user_rest_endpoint' ) );
		add_action( 'template_redirect', array( $this, 'block_author_enumeration' ) );

		// XML-RPC pingback hardening: keep XML-RPC available for legitimate use
		// (e.g. Jetpack, mobile apps) but remove the pingback attack surface.
		add_filter( 'xmlrpc_methods', array( $this, 'disable_pingback_methods' ) );
		add_filter( 'wp_headers', array( $this, 'remove_pingback_header' ) );

		// Generic login errors so failed attempts don't reveal which half
		// (username vs. password) was wrong, or whether an account exists.
		add_filter( 'login_errors', array( $this, 'generic_login_error' ) );

		// Baseline response headers.
		add_action( 'send_headers', array( $this, 'send_security_headers' ) );

		// Belt-and-suspenders file-edit lockdown even if wp-config.php is
		// ever deployed without DISALLOW_FILE_EDIT set.
		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', true );
		}
	}

	/**
	 * Strip the "?ver=" query string WordPress appends to asset URLs.
	 *
	 * @param string $src Asset URL.
	 * @return string
	 */
	public function remove_version_query_arg( $src ) {
		if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) !== false ) {
			$src = remove_query_arg( 'ver', $src );
		}
		return $src;
	}

	/**
	 * Remove the collection endpoint's ability to be filtered by arbitrary
	 * author IDs for unauthenticated requests, which is commonly used for
	 * username enumeration.
	 *
	 * @param array $endpoints Registered REST endpoints.
	 * @return array
	 */
	public function restrict_user_rest_endpoint( $endpoints ) {
		if ( ! is_user_logged_in() && isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( ! is_user_logged_in() && isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
		return $endpoints;
	}

	/**
	 * Block the classic `?author=N` enumeration vector by redirecting to
	 * the homepage instead of exposing the resolved username in the
	 * resulting author-archive redirect.
	 */
	public function block_author_enumeration() {
		if ( is_admin() || ! isset( $_GET['author'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}

		if ( is_numeric( wp_unslash( $_GET['author'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_safe_redirect( home_url( '/' ), 301 );
			exit;
		}
	}

	/**
	 * Remove the `pingback.ping` and `pingback.extensions.getPingbacks`
	 * XML-RPC methods, which are the primary DDoS/enumeration vector for
	 * sites that otherwise need XML-RPC left enabled.
	 *
	 * @param array $methods Registered XML-RPC methods.
	 * @return array
	 */
	public function disable_pingback_methods( $methods ) {
		unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
		return $methods;
	}

	/**
	 * Remove the `X-Pingback` response header.
	 *
	 * @param array $headers Response headers.
	 * @return array
	 */
	public function remove_pingback_header( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}

	/**
	 * Replace WordPress's specific "invalid username" / "incorrect
	 * password" login errors with a single generic message.
	 *
	 * @return string
	 */
	public function generic_login_error() {
		return __( 'Incorrect username or password.', 'atlas-relics-core' );
	}

	/**
	 * Send baseline hardening headers on the front end.
	 */
	public function send_security_headers() {
		if ( headers_sent() ) {
			return;
		}

		header( 'X-Content-Type-Options: nosniff' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
		header( 'X-Frame-Options: SAMEORIGIN' );
	}
}
