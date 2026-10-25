<?php
/**
 * Title: The Conscious Mirror
 * Slug: atlas-relics/conscious-mirror-course
 * Categories: atlas-relics
 * Description: Course landing page with a buy button to the existing checkout.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Checkout link. Set the real Gumroad link here; with no link the buy button is hidden.
$atlas_checkout = 'https://atlasrelics4.gumroad.com/l/consciousmirror';
?>
<!-- wp:group {"tagName":"section","className":"atlas-subhero atlas-m-rise","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background atlas-subhero atlas-m-rise" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Course', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'The Conscious Mirror', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'A self-paced course for noticing the patterns in how you think, react, choose, and live.', 'atlas-relics' ); ?></p>
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
<li><?php echo esc_html__( 'Learn to notice patterns without judging them', 'atlas-relics' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><?php echo esc_html__( 'Practice short mirror exercises', 'atlas-relics' ); ?></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><?php echo esc_html__( 'Keep a simple record of what you see', 'atlas-relics' ); ?></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'Who it is for', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Anyone curious about their own patterns who prefers practice to theory.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Start the course', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Checkout is handled by Gumroad. Lessons open on the course site after purchase.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_checkout ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_checkout ); ?>"><?php echo esc_html__( 'Get the course', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
<!-- wp:paragraph {"textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color"><?php echo esc_html__( 'Already bought it? Unlock the lessons with your license key.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="https://course.consciousness-mirror.com/unlock"><?php echo esc_html__( 'Unlock with license key', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
