<?php
/**
 * Title: Hero (Navy)
 * Slug: atlas-relics/hero
 * Categories: atlas-relics, banner
 * Description: Full-width navy hero with a gold eyebrow, heading, and call-to-action buttons.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:group {"layout":{"type":"constrained","contentSize":"720px"}} -->
	<div class="wp-block-group">
		<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
		<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Atlas Relics', 'atlas-relics' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
		<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Begin with reflection.', 'atlas-relics' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
			<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button"><?php echo esc_html__( 'Start Here', 'atlas-relics' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
