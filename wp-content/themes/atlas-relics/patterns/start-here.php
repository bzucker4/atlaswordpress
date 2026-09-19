<?php
/**
 * Title: Start Here
 * Slug: atlas-relics/start-here
 * Categories: atlas-relics
 * Description: The Start Here journey page — orients a new visitor and points them to the Conscious Mirror and the newsletter.
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
	<p class="has-gold-600-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Start Here', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1} -->
	<h1 class="wp-block-heading"><?php echo esc_html__( 'Three ways to begin.', 'atlas-relics' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"medium"} -->
	<p class="has-medium-font-size"><?php echo esc_html__( 'There\'s no single right entry point — only the one that meets you where you are right now.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:separator {"backgroundColor":"gold-500"} -->
	<hr class="wp-block-separator has-text-color has-gold-500-color has-alpha-channel-opacity has-gold-500-background-color has-background"/>
	<!-- /wp:separator -->

	<!-- wp:heading {"level":2,"fontSize":"large"} -->
	<h2 class="wp-block-heading has-large-font-size"><?php echo esc_html__( '1. Take the Conscious Mirror', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'A free reflection that takes a few quiet minutes and meets you exactly where you are.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="/conscious-mirror/"><?php echo esc_html__( 'Try the Conscious Mirror', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:heading {"level":2,"fontSize":"large"} -->
	<h2 class="wp-block-heading has-large-font-size"><?php echo esc_html__( '2. Read the Journal', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'Shorter reflections, released as they\'re ready, on the ideas behind Atlas Relics.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/journal/"><?php echo esc_html__( 'Visit the Journal', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:heading {"level":2,"fontSize":"large"} -->
	<h2 class="wp-block-heading has-large-font-size"><?php echo esc_html__( '3. Explore the Caves', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'Guided material for whoever is ready to sit with something longer than a single reflection.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/caves/"><?php echo esc_html__( 'Explore the Caves', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:spacer {"height":"var:preset|spacing|60"} -->
	<div style="height:var(--wp--preset--spacing--60)" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->

	<!-- wp:pattern {"slug":"atlas-relics/newsletter-signup-start-here"} /-->
</div>
<!-- /wp:group -->
