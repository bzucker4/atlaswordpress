<?php
/**
 * Title: Pattern Map
 * Slug: atlas-relics/pattern-map
 * Categories: atlas-relics
 * Description: Pattern Map landing page. The personalized-reading fulfillment flow itself is built in Phase 3 (Tally questionnaire + automation); this page is the informational landing page for now.
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
	<p class="has-gold-600-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Pattern Map', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading"><?php echo esc_html__( 'A personal reading of where you\'ve been.', 'atlas-relics' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"medium"} -->
	<p class="has-medium-font-size"><?php echo esc_html__( 'The Pattern Map is a personalized reading, built from your own answers rather than a generic template. It\'s the furthest point on the journey — for whoever is ready for something made specifically for them.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"style":{"border":{"width":"1px","radius":"2px"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"borderColor":"gold-500","backgroundColor":"ivory-100"} -->
	<div class="wp-block-group has-border-color has-gold-500-border-color has-ivory-100-background-color has-background" style="border-width:1px;border-radius:2px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
		<!-- wp:paragraph -->
		<p><?php echo esc_html__( 'The Pattern Map questionnaire and delivery flow open in a later phase. Start with the Conscious Mirror or a Cave, and you\'ll be the first to know when it\'s ready.', 'atlas-relics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
