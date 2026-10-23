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
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Tool', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Vedic Life Advisor', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'A chart and a short reflection, in plain language.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'Enter your birth details, see your chart, ask one question, and read a short reflection in plain language. For reflection and entertainment, not a prediction or advice.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<iframe src="https://vediclife.netlify.app/" title="<?php echo esc_attr__( 'Vedic Life Advisor', 'atlas-relics' ); ?>" style="width:100%;height:85vh;min-height:640px;border:1px solid #c6a15c;border-radius:2px;background:#110812" loading="lazy" allow="geolocation" referrerpolicy="strict-origin-when-cross-origin"></iframe>
<!-- /wp:html -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'If the tool does not load here, open it in its own tab.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( 'https://vediclife.netlify.app/' ); ?>"><?php echo esc_html__( 'Open Vedic Life Advisor in a new tab', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
