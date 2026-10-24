<?php
/**
 * Title: Relics
 * Slug: atlas-relics/relics
 * Categories: atlas-relics
 * Description: Relics landing page, the physical/collectible object collection. Points to the "relics" product category once it exists in the catalog.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"layout":{"type":"constrained","contentSize":"720px"}} -->
<div class="wp-block-group">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Relics', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading"><?php echo esc_html__( 'Objects worth keeping.', 'atlas-relics' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"medium"} -->
	<p class="has-medium-font-size"><?php echo esc_html__( 'Relics are the physical counterpart to the reflection, things made to be held, kept on a shelf or a desk, and returned to.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="/shop/?product_cat=relics"><?php echo esc_html__( 'Browse the Relics', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
	<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'This page links to the "relics" product category, create it and tag matching products once the catalog is populated.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
