<?php
/**
 * Title: Vedic Life Advisor
 * Slug: atlas-relics/vedic-life-advisor
 * Categories: atlas-relics
 * Description: Page that embeds the Vedic Life Advisor app with a new-tab fallback.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:group {"tagName":"section","className":"atlas-center atlas-subhero atlas-m-link","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group atlas-center has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background atlas-subhero atlas-m-link" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)">
<!-- wp:paragraph {"align":"center","fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-text-align-center has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Tool', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"textAlign":"center","level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-text-align-center has-ivory-50-color has-text-color"><?php echo esc_html__( 'Vedic Life Advisor', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-text-align-center has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Enter your birth details, see your chart, and ask one question. A short reflection comes back in plain language. For reflection and entertainment, not prediction or advice.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( 'https://vediclife.netlify.app/' ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Open in a new tab', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","className":"atlas-center","layout":{"type":"constrained","contentSize":"1000px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group atlas-center" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:html -->
<div class="atlas-embed"><iframe src="https://vediclife.netlify.app/" title="<?php echo esc_attr__( 'Vedic Life Advisor', 'atlas-relics' ); ?>" loading="lazy" allow="geolocation" referrerpolicy="strict-origin-when-cross-origin"></iframe></div>
<!-- /wp:html -->
<!-- wp:paragraph {"align":"center","fontSize":"small","textColor":"mist-400"} -->
<p class="has-text-align-center has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Easier on a phone or a small screen in its own tab.', 'atlas-relics' ); ?> <a href="<?php echo esc_url( 'https://vediclife.netlify.app/' ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Open it there', 'atlas-relics' ); ?></a></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
