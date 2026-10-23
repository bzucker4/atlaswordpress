<?php
/**
 * Title: The Four Stages of Consciousness
 * Slug: atlas-relics/four-stages
 * Categories: atlas-relics
 * Description: Course landing page with a buy button to the existing checkout.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Checkout link. Set the real Stripe link here; with no link the buy button is hidden.
$atlas_checkout = 'https://buy.stripe.com/5kQ8wQ5Qo2Nu3LHgpqak000';
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Course', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'The Four Stages of Consciousness', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'A self-paced workbook in six modules. A workbook, not a ladder.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'What you will do', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li><?php echo esc_html__( 'Work through four stages: To Me, By Me, Through Me, As Me', 'atlas-relics' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><?php echo esc_html__( 'Answer written prompts at your own pace', 'atlas-relics' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><?php echo esc_html__( 'Return to any module when you need it', 'atlas-relics' ); ?></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'Who it is for', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Anyone who wants a structured, private way to look at how they relate to their own life.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Start the course', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Checkout is handled securely by Stripe. Lessons open on the course site after purchase.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_checkout ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_checkout ); ?>"><?php echo esc_html__( 'Buy the course', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
