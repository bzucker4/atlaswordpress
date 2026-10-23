<?php
/**
 * Title: Essays
 * Slug: atlas-relics/essays
 * Categories: atlas-relics
 * Description: Essays index with a bridge from each essay to the cave that continues its question.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Reflection', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Follow what stirs within.', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Essays now and then. Each one ends by pointing to where the question goes next.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'Recent essays', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Essays on the questions beneath everyday life. The Conscious Path is the main place to start.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Essay links below will point to the individual posts once they are imported. Until then, each one connects to the cave that continues its question.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:list {"style":{"spacing":{"padding":{"left":"0"}}}} -->
<ul class="wp-block-list" style="padding-left:0;list-style:none">
<!-- wp:list-item -->
<li>1 Oct 2026 · <?php echo esc_html__( 'Your Body Is a Rhythm', 'atlas-relics' ); ?> (<a href="<?php echo esc_url( home_url( '/caves/#silence' ) ); ?>"><?php echo esc_html__( 'Continue this question', 'atlas-relics' ); ?></a>)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>26 Sep 2026 · <?php echo esc_html__( 'Have you ever felt it?', 'atlas-relics' ); ?> (<a href="<?php echo esc_url( home_url( '/caves/#identity' ) ); ?>"><?php echo esc_html__( 'Continue this question', 'atlas-relics' ); ?></a>)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>22 Sep 2026 · <?php echo esc_html__( 'Most of What Holds Us Together Is Invisible', 'atlas-relics' ); ?> (<a href="<?php echo esc_url( home_url( '/caves/#descent' ) ); ?>"><?php echo esc_html__( 'Continue this question', 'atlas-relics' ); ?></a>)</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>15 Sep 2026 · <?php echo esc_html__( 'It Takes Me a While to Get Home', 'atlas-relics' ); ?> (<a href="<?php echo esc_url( home_url( '/caves/#identity' ) ); ?>"><?php echo esc_html__( 'Continue this question', 'atlas-relics' ); ?></a>)</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Want the next one by email?', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( 'https://atlasrelics.kit.com/a33dbc0a01' ); ?>"><?php echo esc_html__( 'Subscribe to the newsletter', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
