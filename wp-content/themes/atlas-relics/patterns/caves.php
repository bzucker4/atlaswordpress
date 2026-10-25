<?php
/**
 * Title: Caves
 * Slug: atlas-relics/caves
 * Categories: atlas-relics
 * Description: The eight caves, the Complete Descent and First Descent bundles, and the companion pieces, each with an anchor for deep links.
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
	'fear'       => 'https://atlas-relics.com/b/o97q8?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
	'grief'      => 'https://atlas-relics.com/b/qRYtP?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
	'shame'      => 'https://atlas-relics.com/b/qsX76?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
	'attachment' => 'https://atlas-relics.com/b/E6FaA?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves',
);
$atlas_complete_link = 'https://atlas-relics.com/b/hyYON?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves-complete';
$atlas_ascent_link   = 'https://atlas-relics.com/b/0jsYS?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves-ascent';
$atlas_journal_link  = 'https://atlas-relics.com/b/JcYMK?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves-journal';
$atlas_quiz_link     = 'https://atlas-relics.com/b/ORl6W?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves-quiz';
$atlas_descent_link = 'https://atlas-relics.com/b/f3DGy?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=caves-descent';
?>
<!-- wp:group {"tagName":"section","className":"atlas-subhero atlas-m-fall","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background atlas-subhero atlas-m-fall" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The store', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Eight caves. Two longer ways in.', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Guided experiences for questions that need more than a reflection. Take one cave, or take them together.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"complete","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section id="complete" class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The whole descent', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Complete Descent', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'All eight caves, The Integration Journal and The Ascent in one purchase. Bought separately they come to $84.70. As the Complete Descent, $27.77.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Take the caves in any order. The first four look at how you move through the world: Control, Desire, Identity and Silence. The last four go deeper: Fear, Grief, Shame and Attachment. The Journal gives each one a place to land, and The Ascent brings it back into ordinary days.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_complete_link ); ?>"><?php echo esc_html__( 'Begin the complete descent', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"control","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="control" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
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
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'control' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"desire","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section id="desire" class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
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
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'desire' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"identity","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="identity" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
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
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'identity' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"silence","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section id="silence" class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Silence', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What remains when the noise stops?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into silence. You notice what the noise has been covering.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'silence' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'silence' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"fear","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="fear" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Fear', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What if your fear is not trying to stop you, but trying to show you what you love?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into what you are afraid of. You will rehearse the worst case on purpose and see what is left standing, and what the fear was guarding.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'fear' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'fear' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"grief","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section id="grief" class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Grief', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What if grief is not something to get over, but the shape your love takes when it outlives its object?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into loss. You will work with the old Mustard Seed story and let the grief be what it is, without trying to fix it.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'grief' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'grief' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"shame","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="shame" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Shame', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What if the part of you that you hide most carefully is holding something you need?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into the part you keep out of view. You will meet it directly, and ask what it has been carrying for you.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'shame' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'shame' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"attachment","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section id="attachment" class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( '$7.77 · about 20 to 30 minutes', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The Cave of Attachment', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium"} -->
<p class="has-medium-font-size"><?php echo esc_html__( 'What if the tighter you grip something, the less of it you are actually able to feel?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided descent into holding on. You will practice an open hand and notice what changes when you stop gripping.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<?php if ( ! empty( $atlas_cave_links[ 'attachment' ] ) ) : ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_cave_links[ 'attachment' ] ); ?>"><?php echo esc_html__( 'Enter this cave', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<?php endif; ?>
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"descent","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="descent" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The longer way in', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'The First Descent', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Control, Desire and Identity in one passage. Bought apart they come to $23.31. As the First Descent, $17.77.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Take them in order. Each cave leaves a question that the next one picks up.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_descent_link ); ?>"><?php echo esc_html__( 'Begin the descent', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","anchor":"ascent","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section id="ascent" class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'After the caves', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'What you do with what you found.', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'The Ascent is a seven day return, 15 to 20 minutes a day, with one short teaching, one practice and a few written questions each day. $12.77.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_ascent_link ); ?>"><?php echo esc_html__( 'Take The Ascent', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading" id="journal"><?php echo esc_html__( 'The Integration Journal', 'atlas-relics' ); ?></h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A 20-page printable companion with Before, After and Carry pages for each of the eight caves, four weekly pages and a single map of the whole journey. $9.77.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_journal_link ); ?>"><?php echo esc_html__( 'Get the journal', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Before you enter', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'How the caves work', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:details -->
<details class="wp-block-details"><summary><?php echo esc_html__( 'What is a cave?', 'atlas-relics' ); ?></summary>
<!-- wp:paragraph -->
<p><?php echo esc_html__( 'A guided experience of about 20 to 30 minutes, delivered as a PDF. You read, step away from the screen for a short practice, and answer a few questions for yourself. Nothing is graded and nothing is stored for you to keep up with.', 'atlas-relics' ); ?></p>
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
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/begin/' ) ); ?>"><?php echo esc_html__( 'Find your sentence', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( $atlas_quiz_link ); ?>"><?php echo esc_html__( 'Or get the free guide: Which Cave Are You In?', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
