<?php
/**
 * Atlas Relics theme setup.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ATLAS_RELICS_VERSION', '0.2.0' );

/**
 * Register theme support and navigation menus.
 */
function atlas_relics_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'atlas-relics' ),
			'footer'  => __( 'Footer Navigation', 'atlas-relics' ),
		)
	);

	add_image_size( 'atlas-relics-card', 640, 480, true );
	add_image_size( 'atlas-relics-hero', 1600, 900, true );

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'atlas_relics_setup' );

/**
 * Register the block pattern category used by theme-provided patterns.
 */
function atlas_relics_register_pattern_categories() {
	register_block_pattern_category(
		'atlas-relics',
		array( 'label' => __( 'Atlas Relics', 'atlas-relics' ) )
	);
}
add_action( 'init', 'atlas_relics_register_pattern_categories' );

/**
 * Enqueue front-end assets.
 */
function atlas_relics_enqueue_assets() {
	wp_enqueue_style(
		'atlas-relics-style',
		get_stylesheet_uri(),
		array(),
		ATLAS_RELICS_VERSION
	);

	wp_enqueue_style(
		'atlas-relics-accessibility',
		get_theme_file_uri( 'assets/css/accessibility.css' ),
		array( 'atlas-relics-style' ),
		ATLAS_RELICS_VERSION
	);

	wp_enqueue_style(
		'atlas-relics-forms',
		get_theme_file_uri( 'assets/css/forms.css' ),
		array( 'atlas-relics-style' ),
		ATLAS_RELICS_VERSION
	);

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style(
			'atlas-relics-woocommerce',
			get_theme_file_uri( 'assets/css/woocommerce.css' ),
			array( 'atlas-relics-style' ),
			ATLAS_RELICS_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'atlas_relics_enqueue_assets' );

/**
 * Drop the emoji-detection script/style and its DNS prefetch. Nobody on
 * this site is typing emoji into content that needs the fallback-image
 * polyfill, so this is a small, safe request-count reduction on every
 * page load.
 */
function atlas_relics_disable_emoji_scripts() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_resource_hints', 'wp_emoji_resource_hints' );
}
add_action( 'init', 'atlas_relics_disable_emoji_scripts' );
