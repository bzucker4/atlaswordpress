<?php
/**
 * Title: Caves
 * Slug: atlas-relics/caves
 * Categories: atlas-relics
 * Description: Caves landing page — the guided-material collection. Points to the "caves" product category once it exists in the catalog.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-600"} -->
	<p class="has-gold-600-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Caves', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading"><?php echo esc_html__( 'For the parts of the journey that ask for more.', 'atlas-relics' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"medium"} -->
	<p class="has-medium-font-size"><?php echo esc_html__( 'Caves are guided material — longer than a reflection, shorter than a course. Each one is built to be sat with, not rushed through.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="/shop/?product_cat=caves"><?php echo esc_html__( 'Browse the Caves', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:paragraph {"fontSize":"small","textColor":"navy-700"} -->
	<p class="has-navy-700-color has-text-color has-small-font-size"><?php echo esc_html__( 'This page links to the "caves" product category — create it and tag matching products once the catalog is populated.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
