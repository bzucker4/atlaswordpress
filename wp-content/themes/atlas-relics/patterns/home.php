<?php
/**
 * Title: Home
 * Slug: atlas-relics/home
 * Categories: atlas-relics
 * Description: The Atlas Relics home page: hero, the caves on the store, essays, the First Descent, courses and tools, and the newsletter.
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
		'body' => __( 'Six modules across four stages: To Me, By Me, Through Me, As Me. A workbook you return to, not a ladder you climb.', 'atlas-relics' ),
		'url'  => home_url( '/four-stages/' ),
	),
	array(
		'type' => __( 'Course', 'atlas-relics' ),
		'name' => __( 'The Conscious Mirror', 'atlas-relics' ),
		'body' => __( 'A self-paced practice for noticing how you think, react and choose, without grading any of it.', 'atlas-relics' ),
		'url'  => home_url( '/conscious-mirror-course/' ),
	),
	array(
		'type' => __( 'Tool', 'atlas-relics' ),
		'name' => __( 'Vedic Life Advisor', 'atlas-relics' ),
		'body' => __( 'Enter your birth details, see your chart, ask one question. A short reflection in plain language.', 'atlas-relics' ),
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
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Some questions need reflection. Others need a descent.', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Guided caves, courses and essays for examining the inner world. Find the sentence that snags and start there.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/begin/' ) ); ?>"><?php echo esc_html__( 'Find your sentence', 'atlas-relics' ); ?></a></div>
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
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The store', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Five doors. Take the one that snags.', 'atlas-relics' ); ?></p>
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
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Control, Desire and Identity in one passage. Less than they cost apart.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Courses', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Stay with it longer.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"className":"atlas-course-cols"} -->
	<div class="wp-block-columns atlas-course-cols">
		<?php foreach ( array( $atlas_tools[0], $atlas_tools[1] ) as $atlas_tool ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"atlas-card atlas-card-course","layout":{"type":"default"}} -->
			<div class="wp-block-group atlas-card atlas-card-course">
				<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
				<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html( $atlas_tool['type'] ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:heading {"level":3,"fontSize":"large"} -->
				<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $atlas_tool['name'] ); ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"textColor":"mist-400"} -->
				<p class="has-mist-400-color has-text-color"><?php echo esc_html( $atlas_tool['body'] ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
					<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_tool['url'] ); ?>"><?php echo esc_html__( 'See the course', 'atlas-relics' ); ?></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->

	<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
	<p class="has-mist-400-color has-text-color has-small-font-size"><a href="<?php echo esc_url( home_url( '/courses/' ) ); ?>"><?php echo esc_html__( 'All courses and tools', 'atlas-relics' ); ?></a></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"atlas-promo","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group atlas-promo has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:columns {"verticalAlignment":"center","className":"atlas-promo-cols"} -->
	<div class="wp-block-columns are-vertically-aligned-center atlas-promo-cols">
		<!-- wp:column {"verticalAlignment":"center","width":"55%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%">
			<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
			<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Vedic Life Advisor', 'atlas-relics' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":2,"className":"atlas-display-left"} -->
			<h2 class="wp-block-heading atlas-display-left"><?php echo esc_html__( 'Your birth chart, in plain language.', 'atlas-relics' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"mist-400"} -->
			<p class="has-mist-400-color has-text-color"><?php echo esc_html__( 'Enter your birth details, see your chart, and ask one question. You get a short reflection back, with no jargon to decode. For reflection and entertainment, not prediction or advice.', 'atlas-relics' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( 'https://vediclife.netlify.app/' ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Get your chart', 'atlas-relics' ); ?></a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/vedic-life-advisor/' ) ); ?>"><?php echo esc_html__( 'How it works', 'atlas-relics' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%">
			<!-- wp:html -->
			<a class="atlas-wheel-link" href="<?php echo esc_url( 'https://vediclife.netlify.app/' ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'Open the Vedic Life Advisor in a new tab', 'atlas-relics' ); ?>"><div class="atlas-wheel" aria-hidden="true"></div></a>
			<!-- /wp:html -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"atlas-interlude","layout":{"type":"constrained","contentSize":"980px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}}} -->
<section class="wp-block-group atlas-interlude" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">
	<!-- wp:paragraph {"align":"center","fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-text-align-center has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The caves', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"textAlign":"center","level":2,"className":"atlas-display"} -->
	<h2 class="wp-block-heading has-text-align-center atlas-display"><?php echo esc_html__( 'Some answers only come from going deeper.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"atlas-facts","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
	<div class="wp-block-group atlas-facts">
		<!-- wp:paragraph -->
		<p><?php echo esc_html__( '20 to 30 minutes each', 'atlas-relics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph -->
		<p><?php echo esc_html__( 'No streaks, no scores', 'atlas-relics' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:paragraph -->
		<p><?php echo esc_html__( 'Written, not generated', 'atlas-relics' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/caves/' ) ); ?>"><?php echo esc_html__( 'See the four caves', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'From the essays', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Read one already? Pick up where it left you.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"atlas-essay-grid","layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"18rem"}} -->
	<div class="wp-block-group atlas-essay-grid">
		<?php foreach ( $atlas_essays as $atlas_essay ) : ?>
		<?php
		$atlas_dest = 'descent' === $atlas_essay['cave'] ? __( 'The First Descent', 'atlas-relics' ) : sprintf( /* translators: %s: cave name */ __( 'the Cave of %s', 'atlas-relics' ), ucfirst( $atlas_essay['cave'] ) );
		?>
		<!-- wp:group {"className":"atlas-card atlas-card-link","layout":{"type":"default"}} -->
		<div class="wp-block-group atlas-card atlas-card-link">
			<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
			<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html( $atlas_essay['date'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"fontSize":"medium"} -->
			<h3 class="wp-block-heading has-medium-font-size"><?php echo esc_html( $atlas_essay['title'] ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"fontSize":"small","textColor":"lilac-300"} -->
			<p class="has-lilac-300-color has-text-color has-small-font-size"><a href="<?php echo esc_url( home_url( '/caves/#' . $atlas_essay['cave'] ) ); ?>"><?php echo esc_html( sprintf( /* translators: %s: destination */ __( 'Take it into %s', 'atlas-relics' ), $atlas_dest ) ); ?> &rarr;</a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( 'https://medium.com/the-conscious-path' ); ?>"><?php echo esc_html__( 'More essays on Medium', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
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
	<p><?php echo esc_html__( 'Control, Desire and Identity in one passage. $17.77 instead of $23.31 bought apart.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_buy . 'f3DGy' . $atlas_utm . '-descent' ); ?>"><?php echo esc_html__( 'Begin the descent', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/caves/#descent' ) ); ?>"><?php echo esc_html__( 'See what is inside', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The Conscious Path', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Essays on the questions under everyday life.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"ivory-50"} -->
	<p class="has-ivory-50-color has-text-color"><?php echo esc_html__( 'New pieces now and then, written on Medium. Start with the most recent.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( 'https://medium.com/the-conscious-path' ); ?>"><?php echo esc_html__( 'Read The Conscious Path', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The letter', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'A note when there is something worth sitting with.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"ivory-50"} -->
	<p class="has-ivory-50-color has-text-color"><?php echo esc_html__( 'Free, occasional, and separate from the essays.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="https://atlasrelics.kit.com/a33dbc0a01"><?php echo esc_html__( 'Join the letter', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->
