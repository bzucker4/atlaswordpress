<?php
/**
 * Baseline SEO output.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs meta description, canonical URL, and Open Graph/Twitter Card
 * tags without depending on a third-party SEO plugin. Phase 1 already
 * enabled `title-tag` support (theme) and WordPress core's built-in
 * `/wp-sitemap.xml`; this class fills the remaining gap for Phase 2's
 * customer-facing pages.
 *
 * This intentionally stays minimal — if the project later adopts Yoast or
 * RankMath, deactivate this class's output rather than running both.
 */
class Atlas_Relics_Core_SEO {

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'wp_head', array( $this, 'output_meta_tags' ), 1 );
	}

	/**
	 * Print meta description, canonical, and social tags for the current
	 * request.
	 */
	public function output_meta_tags() {
		if ( is_admin() ) {
			return;
		}

		$description = $this->get_description();
		$canonical   = $this->get_canonical_url();
		$title       = wp_get_document_title();
		$image       = $this->get_image_url();

		if ( $description ) {
			printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
		}

		if ( $canonical ) {
			printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $canonical ) );
		}

		printf( '<meta property="og:type" content="%s" />' . "\n", is_singular( 'product' ) ? 'product' : 'website' );
		printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
		printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );

		if ( $description ) {
			printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
		}

		if ( $canonical ) {
			printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $canonical ) );
		}

		if ( $image ) {
			printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
			echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		} else {
			echo '<meta name="twitter:card" content="summary" />' . "\n";
		}

		if ( is_search() || ( is_singular() && 'private' === get_post_status() ) ) {
			echo '<meta name="robots" content="noindex,follow" />' . "\n";
		}
	}

	/**
	 * Resolve a meta description for the current request.
	 *
	 * @return string
	 */
	private function get_description() {
		if ( is_singular() ) {
			$post = get_queried_object();

			if ( $post instanceof WP_Post ) {
				$excerpt = has_excerpt( $post ) ? $post->post_excerpt : $post->post_content;
				return wp_trim_words( wp_strip_all_tags( $excerpt ), 30 );
			}
		}

		if ( is_category() || is_tag() || is_tax() ) {
			return wp_strip_all_tags( term_description() );
		}

		return get_bloginfo( 'description' );
	}

	/**
	 * Resolve the canonical URL for the current request.
	 *
	 * @return string
	 */
	private function get_canonical_url() {
		if ( is_singular() ) {
			return get_permalink();
		}

		if ( is_home() || is_front_page() ) {
			return home_url( '/' );
		}

		global $wp;
		return home_url( add_query_arg( array(), $wp->request ) );
	}

	/**
	 * Resolve a representative image for the current request.
	 *
	 * @return string
	 */
	private function get_image_url() {
		if ( is_singular() && has_post_thumbnail() ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			return $image ? $image[0] : '';
		}

		return '';
	}
}
