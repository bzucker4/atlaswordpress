<?php
/**
 * Atlas Relics theme setup.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ATLAS_RELICS_VERSION', '0.1.0' );

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
}
add_action( 'wp_enqueue_scripts', 'atlas_relics_enqueue_assets' );
