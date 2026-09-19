<?php
/**
 * Title: About
 * Slug: atlas-relics/about
 * Categories: atlas-relics
 * Description: The About page — who Atlas Relics is for and why it exists.
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
	<p class="has-gold-600-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'About', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading"><?php echo esc_html__( 'A considered path, not a funnel.', 'atlas-relics' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"medium"} -->
	<p class="has-medium-font-size"><?php echo esc_html__( 'Atlas Relics exists for people who want to slow down for a moment before deciding what\'s next — a free reflection first, then a newsletter, then a guide or a relic, only if and when it\'s genuinely useful.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'Nothing here is designed to rush you. There\'s no countdown timer, no "only 3 left" banner, no exit-intent popup. If something is right for you, it will still be right for you tomorrow.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'If you\'re not sure where to begin, Start Here walks through the three ways in.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="/start-here/"><?php echo esc_html__( 'Start Here', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
