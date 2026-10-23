<?php
/**
 * Title: Home
 * Slug: atlas-relics/home
 * Categories: atlas-relics
 * Description: The Atlas Relics home page: hero, the caves on the store, essays, the First Descent, the Pattern Map, courses and tools, and the newsletter.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$atlas_buy = 'https://atlas-relics.com/b/';
$atlas_utm = '?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=home';

$atlas_caves = array(
	array(
		'id'       => 'control',
		'name'     => __( 'The Cave of Control', 'atlas-relics' ),
		'question' => __( 'What if the need to control your life is quietly preventing you from experiencing it?', 'atlas-relics' ),
	),
	array(
		'id'       => 'desire',
		'name'     => __( 'The Cave of Desire', 'atlas-relics' ),
		'question' => __( 'What if the thing you want is not actually what you are searching for?', 'atlas-relics' ),
	),
	array(
		'id'       => 'identity',
		'name'     => __( 'The Cave of Identity', 'atlas-relics' ),
		'question' => __( 'Who are you when you are no longer required to stay recognizable?', 'atlas-relics' ),
	),
	array(
		'id'       => 'silence',
		'name'     => __( 'The Cave of Silence', 'atlas-relics' ),
		'question' => __( 'What remains when the noise stops?', 'atlas-relics' ),
	),
);

$atlas_essays = array(
	array(
		'date'  => __( '1 Oct 2026', 'atlas-relics' ),
		'title' => __( 'Your Body Is a Rhythm', 'atlas-relics' ),
		'cave'  => 'silence',
	),
	array(
		'date'  => __( '26 Sep 2026', 'atlas-relics' ),
		'title' => __( 'Have you ever felt it?', 'atlas-relics' ),
		'cave'  => 'identity',
	),
	array(
		'date'  => __( '22 Sep 2026', 'atlas-relics' ),
		'title' => __( 'Most of What Holds Us Together Is Invisible', 'atlas-relics' ),
		'cave'  => 'descent',
	),
	array(
		'date'  => __( '15 Sep 2026', 'atlas-relics' ),
		'title' => __( 'It Takes Me a While to Get Home', 'atlas-relics' ),
		'cave'  => 'identity',
	),
);

$atlas_tools = array(
	array(
		'type' => __( 'Course', 'atlas-relics' ),
		'name' => __( 'The Four Stages of Consciousness', 'atlas-relics' ),
		'body' => __( 'A self-paced workbook in six modules, moving through four stages: To Me, By Me, Through Me, As Me. A workbook, not a ladder.', 'atlas-relics' ),
		'url'  => home_url( '/four-stages/' ),
	),
	array(
		'type' => __( 'Course', 'atlas-relics' ),
		'name' => __( 'The Conscious Mirror', 'atlas-relics' ),
		'body' => __( 'A self-paced course for noticing the patterns in how you think, react, choose, and live.', 'atlas-relics' ),
		'url'  => home_url( '/conscious-mirror-course/' ),
	),
	array(
		'type' => __( 'Tool', 'atlas-relics' ),
		'name' => __( 'Vedic Life Advisor', 'atlas-relics' ),
		'body' => __( 'Enter your birth details, see your chart, ask one question, and read a short reflection in plain language.', 'atlas-relics' ),
		'url'  => home_url( '/vedic-life-advisor/' ),
	),
);
?>
<!-- wp:group {"tagName":"section","className":"atlas-hero","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group atlas-hero has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--50)">
<!-- wp:columns {"verticalAlignment":"center"} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Atlas Relics', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Experiences for examining the inner world.', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Some questions need reflection. Others require descent. Choose where you want to begin.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/begin/' ) ); ?>"><?php echo esc_html__( 'Choose where to begin', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/caves/' ) ); ?>"><?php echo esc_html__( 'Enter the caves', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"45%","className":"atlas-list"} -->
<div class="wp-block-column is-vertically-aligned-center atlas-list" style="flex-basis:45%">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'On the store', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Five doors. Open the sentence that snags.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">01</span> <a href="<?php echo esc_url( home_url( '/caves/#control' ) ); ?>"><?php echo esc_html__( 'Control', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if the need to control your life is quietly preventing you from experiencing it?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">02</span> <a href="<?php echo esc_url( home_url( '/caves/#desire' ) ); ?>"><?php echo esc_html__( 'Desire', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if the thing you want is not actually what you are searching for?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">03</span> <a href="<?php echo esc_url( home_url( '/caves/#identity' ) ); ?>"><?php echo esc_html__( 'Identity', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Who are you when you are no longer required to stay recognizable?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">04</span> <a href="<?php echo esc_url( home_url( '/caves/#silence' ) ); ?>"><?php echo esc_html__( 'Silence', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What remains when the noise stops?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">05</span> <a href="<?php echo esc_url( home_url( '/caves/#descent' ) ); ?>"><?php echo esc_html__( 'The First Descent', 'atlas-relics' ); ?></a> <span class="atlas-price">$17.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Control, Desire, and Identity together, for less than they cost apart.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Reflection', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Follow what stirs within.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"ivory-50"} -->
	<p class="has-ivory-50-color has-text-color"><?php echo esc_html__( 'Essays now and then on the questions beneath everyday life. The Conscious Path is the main place to start.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( 'https://medium.com/the-conscious-path' ); ?>"><?php echo esc_html__( 'Read from the essays', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Descent', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading"><?php echo esc_html__( 'Some answers are only found by going deeper.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'The caves are guided experiences of about 20 to 30 minutes. No streaks, no scores, no AI.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/caves/' ) ); ?>"><?php echo esc_html__( 'See the caves', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'If an essay sent you', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Continue the question you already opened.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:list {"style":{"spacing":{"padding":{"left":"0"}}}} -->
	<ul class="wp-block-list" style="padding-left:0;list-style:none">
		<?php foreach ( $atlas_essays as $atlas_essay ) : ?>
		<!-- wp:list-item -->
		<li><?php echo esc_html( $atlas_essay['date'] ); ?> &middot; <?php echo esc_html( $atlas_essay['title'] ); ?> (<a href="<?php echo esc_url( home_url( '/caves/#' . $atlas_essay['cave'] ) ); ?>"><?php echo esc_html__( 'Continue this question', 'atlas-relics' ); ?></a>)</li>
		<!-- /wp:list-item -->
		<?php endforeach; ?>
	</ul>
	<!-- /wp:list -->

	<!-- wp:paragraph -->
	<p><a href="<?php echo esc_url( 'https://medium.com/the-conscious-path' ); ?>"><?php echo esc_html__( 'All recent essays', 'atlas-relics' ); ?></a></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The longer way in', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading"><?php echo esc_html__( 'The First Descent', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'Control, Desire, and Identity together. $23.31 bought separately, $17.77 as the First Descent.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_buy . 'f3DGy' . $atlas_utm . '-descent' ); ?>"><?php echo esc_html__( 'Begin the descent', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/caves/#descent' ) ); ?>"><?php echo esc_html__( 'Read what it holds', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Also on the store', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'The Personal Pattern Map', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"ivory-50"} -->
	<p class="has-ivory-50-color has-text-color"><?php echo esc_html__( 'A private written reflection, $19. About 15 to 20 minutes to begin. The written map is returned by email within 48 hours.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_buy . 'UYo5J' . $atlas_utm . '-map' ); ?>"><?php echo esc_html__( 'Begin the map ($19)', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/caves/' ) ); ?>"><?php echo esc_html__( 'See the full store', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Courses and tools', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading"><?php echo esc_html__( 'For a longer stay.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:group {"align":"wide","layout":{"type":"grid","minimumColumnWidth":"16rem"}} -->
	<div class="wp-block-group alignwide">
		<?php foreach ( $atlas_tools as $atlas_tool ) : ?>
		<!-- wp:group {"style":{"border":{"width":"1px","radius":"2px"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"borderColor":"violet-500","backgroundColor":"plum-700"} -->
		<div class="wp-block-group has-border-color has-violet-500-border-color has-plum-700-background-color has-background" style="border-width:1px;border-radius:2px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
			<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html( $atlas_tool['type'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"fontSize":"medium"} -->
			<h3 class="wp-block-heading has-medium-font-size"><a href="<?php echo esc_url( $atlas_tool['url'] ); ?>"><?php echo esc_html( $atlas_tool['name'] ); ?></a></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
			<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html( $atlas_tool['body'] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The letter', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'When there is something worth sitting with.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"ivory-50"} -->
	<p class="has-ivory-50-color has-text-color"><?php echo esc_html__( 'A free newsletter, sent separately from the essays. Subscribers confirm by email.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="https://atlasrelics.kit.com/a33dbc0a01"><?php echo esc_html__( 'Subscribe to newsletter', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
