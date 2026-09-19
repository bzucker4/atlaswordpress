<?php
/**
 * Title: Newsletter Signup (Start Here)
 * Slug: atlas-relics/newsletter-signup-start-here
 * Categories: atlas-relics
 * Description: Newsletter signup variant segmented to the "Start Here Group ID" configured in Settings → Atlas Relics.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3,"fontSize":"medium"} -->
	<h3 class="wp-block-heading has-medium-font-size"><?php echo esc_html__( 'Keep the reflection going', 'atlas-relics' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><?php echo esc_html__( 'Join The Weekly Mirror — one reflection a week, nothing else.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<form class="atlas-relics-newsletter-form" data-segment="start-here">
		<label class="screen-reader-text" for="atlas-relics-newsletter-email-start-here"><?php echo esc_html__( 'Email address', 'atlas-relics' ); ?></label>
		<input type="email" id="atlas-relics-newsletter-email-start-here" name="email" required placeholder="<?php echo esc_attr__( 'you@example.com', 'atlas-relics' ); ?>" />
		<button type="submit" class="wp-element-button"><?php echo esc_html__( 'Subscribe', 'atlas-relics' ); ?></button>
		<p class="atlas-relics-newsletter-message" role="status" aria-live="polite"></p>
	</form>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
