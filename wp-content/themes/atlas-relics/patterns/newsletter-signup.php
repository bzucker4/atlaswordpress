<?php
/**
 * Title: Newsletter Signup
 * Slug: atlas-relics/newsletter-signup
 * Categories: atlas-relics
 * Description: The Weekly Mirror signup form. Set the "data-segment" attribute (footer, start-here, conscious-mirror) to match the MailerLite group configured in Settings → Atlas Relics.
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
	<h3 class="wp-block-heading has-medium-font-size"><?php echo esc_html__( 'The Weekly Mirror', 'atlas-relics' ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"small"} -->
	<p class="has-small-font-size"><?php echo esc_html__( 'A short reflection in your inbox, once a week.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<form class="atlas-relics-newsletter-form" data-segment="footer">
		<label class="screen-reader-text" for="atlas-relics-newsletter-email"><?php echo esc_html__( 'Email address', 'atlas-relics' ); ?></label>
		<input type="email" id="atlas-relics-newsletter-email" name="email" required placeholder="<?php echo esc_attr__( 'you@example.com', 'atlas-relics' ); ?>" />
		<button type="submit" class="wp-element-button"><?php echo esc_html__( 'Subscribe', 'atlas-relics' ); ?></button>
		<p class="atlas-relics-newsletter-message" role="status" aria-live="polite"></p>
	</form>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
