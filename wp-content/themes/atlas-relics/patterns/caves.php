<?php
/**
 * Title: Caves
 * Slug: atlas-relics/caves
 * Categories: atlas-relics
 * Description: The four caves and the First Descent bundle, each with an anchor for deep links.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Checkout links for each cave. Fill these in with the real store links;
// a cave with an empty link shows its description without a buy button.
$atlas_cave_links = array(
	'control'  => 'https://atlas-relics.com/b/sUMGE?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
	'desire'   => 'https://atlas-relics.com/b/dMk6W?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
	'identity' => 'https://atlas-relics.com/b/OPpd2?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
	'silence'  => 'https://atlas-relics.com/b/Tqz97?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
);
$atlas_descent_link = 'https://atlas-relics.com/b/f3DGy?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves-descent';
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The store', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Four caves. One longer way in.', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Guided experiences for the questions that need more than a reflection. Choose one, or take the three together.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"control","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="control" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Control', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What if the need to control your life is quietly preventing you from experiencing it?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into the part of you that plans, manages, and braces. You will look at what the grip is protecting, and what it costs.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'control' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'control' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"desire","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section id="desire" class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Desire', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What if the thing you want is not actually what you are searching for?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into wanting. You will follow a desire down to the need underneath it and see whether the object ever could have answered it.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'desire' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'desire' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"identity","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="identity" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Identity', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'Who are you when you are no longer required to stay recognizable?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into the self you maintain for other people, and the one that remains when the maintenance stops.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'identity' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'identity' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"silence","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section id="silence" class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Silence', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What remains when the noise stops?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into quiet. Less a technique than an invitation to notice what the noise has been covering.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'silence' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'silence' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"descent","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="descent" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The longer way in', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The First Descent', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Control, Desire, and Identity together. Bought separately they come to $23.31. As the First Descent, they are $17.77.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Take them in order. Each cave leaves a question that the next one picks up.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_descent_link ); ?>"><?php echo esc_html__( 'Begin the descent', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"navy-900","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-navy-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"gold-500"} -->
<p class="has-gold-500-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Before you enter', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'How the caves work', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:details -->
<details class="wp-block-details"><summary><?php echo esc_html__( 'What is a cave?', 'atlas-relics' ); ?></summary>
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided audio-and-text experience of about 20 to 30 minutes. You read, listen, and answer a few questions for yourself. Nothing is graded and nothing is stored for you to keep up with.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary><?php echo esc_html__( 'Is there AI involved?', 'atlas-relics' ); ?></summary>
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'No. The caves are written, not generated. There are no streaks, no scores, and no chat.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
<!-- wp:details -->
<details class="wp-block-details"><summary><?php echo esc_html__( 'Which one should I start with?', 'atlas-relics' ); ?></summary>
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'If you are unsure, use the short guide on the Begin page. It maps a few honest sentences to the cave that fits.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</details>
<!-- /wp:details -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'Not sure where to begin?', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"gold-500","textColor":"navy-900"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-navy-900-color has-gold-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/begin/' ) ); ?>"><?php echo esc_html__( 'Choose where to begin', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
