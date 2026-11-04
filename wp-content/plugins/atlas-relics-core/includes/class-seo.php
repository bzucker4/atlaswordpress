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
 * This intentionally stays minimal, if the project later adopts Yoast or
 * RankMath, deactivate this class's output rather than running both.
 */
class Atlas_Relics_Core_SEO {

	/**
	 * Hand written meta descriptions. Pages are built from patterns, so their
	 * stored content is only a pattern reference and cannot be summarised.
	 *
	 * @var array
	 */
	private static $descriptions = array(
		'home'                   => 'Guided caves, courses, books and tools for examining the inner world, by Atlas Reed. Find the sentence that snags and start there.',
		'begin'                  => 'Not sure where to start? Write a few honest sentences and find the Atlas Relics cave, course or tool that fits what you are carrying.',
		'caves'                  => 'Eight guided caves of 20 to 30 minutes each: control, desire, identity, silence, fear, grief, shame and attachment. Take one, or take them together.',
		'courses'                => 'Two self-paced courses from Atlas Relics: The Four Stages of Consciousness and The Conscious Mirror. Learn to notice how you think, react and choose.',
		'four-stages'            => 'The Four Stages of Consciousness is a six module course on moving from To Me to By Me, Through Me and As Me.',
		'conscious-mirror-course' => 'The Conscious Mirror is a self-paced course for seeing your own patterns. Nothing is graded and nothing is diagnosed.',
		'vedic-life-advisor'     => 'Enter your birth details, see your Vedic chart and ask one question. A tool from Atlas Relics.',
		'about'                  => 'Atlas Relics is the work of Atlas Reed: guided caves, books, decks and courses for people who like to look under the surface.',
		'products'               => 'Every Atlas Relics product in one place: courses, caves, books, printed decks and tools, with the best value first.',
	);

	/**
	 * Register hooks.
	 */
	public function __construct() {
		// This class prints its own canonical; drop core's so singular pages don't get two.
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'wp_head', array( $this, 'output_meta_tags' ), 1 );
		add_action( 'wp_head', array( $this, 'output_schema' ), 3 );
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
			printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) );
			echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		} else {
			echo '<meta name="twitter:card" content="summary" />' . "\n";
		}

		if ( is_search() || ( is_singular() && 'private' === get_post_status() ) ) {
			echo '<meta name="robots" content="noindex,follow" />' . "\n";
		}
	}

	/**
	 * Print Organization and WebSite structured data on the front page.
	 */
	public function output_schema() {
		if ( is_admin() || ! is_front_page() ) {
			return;
		}

		$data = array(
			'@context' => 'https://schema.org',
			'@graph'   => array(
				array(
					'@type'  => 'Organization',
					'@id'    => home_url( '/#organization' ),
					'name'   => 'Atlas Relics',
					'url'    => home_url( '/' ),
					'logo'   => function_exists( 'get_theme_file_uri' ) ? get_theme_file_uri( 'assets/img/icon-512.png' ) : '',
					'sameAs' => array(
						'https://www.instagram.com/atlasrelics',
						'https://www.threads.net/@atlasrelics',
						'https://www.tiktok.com/@atlasrelics444',
						'https://www.etsy.com/shop/AtlasRelicsShop',
						'https://medium.com/the-conscious-path',
					),
				),
				array(
					'@type'     => 'WebSite',
					'@id'       => home_url( '/#website' ),
					'url'       => home_url( '/' ),
					'name'      => 'Atlas Relics',
					'publisher' => array( '@id' => home_url( '/#organization' ) ),
				),
			),
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}

	/**
	 * Resolve a meta description for the current request.
	 *
	 * @return string
	 */
	private function get_description() {
		if ( is_front_page() ) {
			return self::$descriptions['home'];
		}

		if ( is_page() ) {
			$slug = get_post_field( 'post_name', get_queried_object_id() );
			if ( isset( self::$descriptions[ $slug ] ) ) {
				return self::$descriptions[ $slug ];
			}
		}

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

		// Fallback share image supplied by the theme.
		$path = get_theme_file_path( 'assets/img/share.png' );
		if ( file_exists( $path ) ) {
			return get_theme_file_uri( 'assets/img/share.png' );
		}

		return '';
	}
}
