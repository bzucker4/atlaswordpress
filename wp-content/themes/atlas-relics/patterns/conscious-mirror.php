<?php
/**
 * Title: Conscious Mirror
 * Slug: atlas-relics/conscious-mirror
 * Categories: atlas-relics
 * Description: The Conscious Mirror landing page. The interactive reflection itself is a Tally form wired up in Phase 3 — this page carries the copy and the newsletter fallback until then.
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
	<p class="has-gold-600-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Conscious Mirror', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading"><?php echo esc_html__( 'A few honest minutes with yourself.', 'atlas-relics' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"medium"} -->
	<p class="has-medium-font-size"><?php echo esc_html__( 'The Conscious Mirror is a short, free reflection — a handful of questions, answered honestly, that give you back a clearer read on where you actually are. No account, no cost, no catch.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"style":{"border":{"width":"1px","radius":"2px"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"borderColor":"gold-500","backgroundColor":"ivory-100"} -->
	<div class="wp-block-group has-border-color has-gold-500-border-color has-ivory-100-background-color has-background" style="border-width:1px;border-radius:2px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
		<!-- wp:paragraph -->
		<p><?php echo esc_html__( 'The interactive reflection is being prepared and will open here shortly. In the meantime, join The Weekly Mirror below and we\'ll let you know the moment it\'s ready.', 'atlas-relics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:spacer {"height":"var:preset|spacing|50"} -->
	<div style="height:var(--wp--preset--spacing--50)" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:pattern {"slug":"atlas-relics/newsletter-signup-conscious-mirror"} /-->
</div>
<!-- /wp:group -->
