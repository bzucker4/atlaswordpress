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

$atlas_books = array(
	array(
		'key'   => 'a',
		'name'  => __( 'The Ageless Truths', 'atlas-relics' ),
		'price' => '$11.11',
		'code'  => 'fH5cW',
		'body'  => __( 'A practical companion to slowing down. Seven chapters on letting go, stillness, presence and change, drawing on Stoic, Taoist, Sufi, Vedic and Greek teachings. Each chapter ends with daily practices you can keep.', 'atlas-relics' ),
	),
	array(
		'key'   => 'b',
		'name'  => __( 'Laws of the Universe', 'atlas-relics' ),
		'price' => '$14.99',
		'code'  => 'Glyzs',
		'body'  => __( 'The Twelve Universal Laws in plain language, traced back to the Kybalion and checked against what psychology supports. It says where the evidence stops.', 'atlas-relics' ),
	),
	array(
		'key'   => 'c',
		'name'  => __( 'The Great Shift', 'atlas-relics' ),
		'price' => '$19.99',
		'code'  => 'gt6pG',
		'body'  => __( 'Hidden truths about the matrix: false thrones, the Trinity of Theft, Override Codes and why the awakening is already moving. Read it as one seer\'s map, not settled fact.', 'atlas-relics' ),
	),
);

$atlas_tools = array(
	array(
		'type' => __( 'Course', 'atlas-relics' ),
		'name' => __( 'The Four Stages of Consciousness', 'atlas-relics' ),
		'body' => __( 'Six modules across four stages: To Me, By Me, Through Me, As Me. You can return to any of them.', 'atlas-relics' ),
		'url'  => home_url( '/four-stages/' ),
	),
	array(
		'type' => __( 'Course', 'atlas-relics' ),
		'name' => __( 'The Conscious Mirror', 'atlas-relics' ),
		'body' => __( 'A self-paced course for noticing how you think, react and choose. Nothing is graded.', 'atlas-relics' ),
		'url'  => home_url( '/conscious-mirror-course/' ),
	),
	array(
		'type' => __( 'Tool', 'atlas-relics' ),
		'name' => __( 'Vedic Life Advisor', 'atlas-relics' ),
		'body' => __( 'Enter your birth details, see your chart, ask one question. A short reflection in plain language.', 'atlas-relics' ),
		'url'  => home_url( '/vedic-life-advisor/' ),
	),
);

$atlas_decks = array(
	array( 'key' => 'horror', 'name' => 'Dark Horror Tarot', 'type' => '78 cards', 'body' => 'A gothic 78-card tarot with a dark, haunted edge.', 'url' => 'https://www.makeplayingcards.com/sell/marketplace/dark-horror-tarot.html' ),
	array( 'key' => 'keywords', 'name' => 'Beginner Tarot With Keywords', 'type' => '78 cards', 'body' => 'Keywords for zodiac, numerology and the elements on every card.', 'url' => 'https://www.makeplayingcards.com/sell/marketplace/beginner-tarot-with-keywords.html' ),
	array( 'key' => 'zen', 'name' => 'Japanese Zen Oracle', 'type' => 'Oracle deck', 'body' => 'An oracle deck of ink, blossom and stillness.', 'url' => 'https://www.makeplayingcards.com/sell/marketplace/japanese-zen-oracle.html' ),
	array( 'key' => 'shroom', 'name' => 'ShroomOracle Cards', 'type' => 'Oracle deck', 'body' => 'An oracle deck drawn from the forest floor.', 'url' => 'https://www.makeplayingcards.com/sell/marketplace/shroomoracle-cards.html' ),
);

$atlas_etsy_tools = array(
	array( 'key' => 'audio', 'type' => 'Audio', 'name' => 'Shadow Work Audio for Practitioners', 'price' => '$55', 'body' => 'A 14-minute sub bass soundscape with a script, licensed for use with your clients.', 'url' => 'https://www.etsy.com/listing/4570440370' ),
	array( 'key' => 'sheet', 'type' => 'Google Sheets', 'name' => 'Human Design Planner', 'price' => '$33', 'body' => 'A decision tracker built around your type, strategy and authority.', 'url' => 'https://www.etsy.com/listing/4570231442' ),
	array( 'key' => 'sheet', 'type' => 'Google Sheets', 'name' => 'Lunar Cycle Consciousness Tracker', 'price' => '$33', 'body' => 'A shadow work dashboard that follows the lunar cycle.', 'url' => 'https://www.etsy.com/listing/4569892185' ),
	array( 'key' => 'kit', 'type' => 'Workbook and audio', 'name' => 'The Nocturne Mirror', 'price' => '$24', 'body' => 'A Jungian dream analysis workbook, a fillable dream journal and a guided audio.', 'url' => 'https://www.etsy.com/listing/4592667471' ),
);
?>
<!-- wp:group {"tagName":"section","className":"atlas-hero atlas-hero--v2","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"textColor":"ivory-50"} -->
<section class="wp-block-group atlas-hero atlas-hero--v2 has-ivory-50-color has-text-color" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--50)">
<!-- wp:html -->
<div class="atlas-sky" aria-hidden="true"><canvas class="stars"></canvas><canvas class="flow"></canvas><div class="atlas-haze"></div><div class="atlas-cursor"></div><div class="atlas-portal"><i></i><i></i><i></i><i></i><i></i><i></i><span class="disc"></span><span class="core"></span></div><span class="atlas-descent"></span></div>
<!-- /wp:html -->

<!-- wp:group {"className":"atlas-hero-body","layout":{"type":"default"}} -->
<div class="wp-block-group atlas-hero-body">
<!-- wp:group {"className":"atlas-hero-text","layout":{"type":"default"}} -->
<div class="wp-block-group atlas-hero-text">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.2em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.2em;text-transform:uppercase"><?php echo esc_html__( 'Atlas Relics', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Some questions need reflection. Others need a', 'atlas-relics' ); ?> <span class="atlas-shimmer"><?php echo esc_html__( 'descent.', 'atlas-relics' ); ?></span></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Guided caves, courses and essays for examining the inner world. Find the sentence that snags and start there.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/begin/' ) ); ?>"><?php echo esc_html__( 'Find your sentence', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"atlas-btn-text","textColor":"ivory-50"} -->
<div class="wp-block-button atlas-btn-text"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/courses/' ) ); ?>"><?php echo esc_html__( 'Courses', 'atlas-relics' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
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

	<!-- wp:group {"className":"atlas-card atlas-strip","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group atlas-card atlas-strip">
		<!-- wp:group {"layout":{"type":"default"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
			<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Tool', 'atlas-relics' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"fontSize":"medium"} -->
			<p class="has-medium-font-size"><strong><?php echo esc_html__( 'The Shadow Ledger', 'atlas-relics' ); ?></strong> <span class="atlas-muted"><?php echo esc_html__( 'A Jungian shadow work system for Notion.', 'atlas-relics' ); ?></span></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
			<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( 'https://shop.beacons.ai/atlasrelics/db21710c-65a4-4be9-a745-8bf19b342fd0' ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html__( 'Get the system', 'atlas-relics' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

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
			<p class="has-mist-400-color has-text-color"><?php echo esc_html__( 'Enter your birth details, see your chart, and ask one question. You get a short reflection back in plain language. This is for reflection and entertainment, not prediction or advice.', 'atlas-relics' ); ?></p>
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

<!-- wp:group {"tagName":"section","className":"atlas-tools","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group atlas-tools" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Tools and workbooks', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading"><?php echo esc_html__( 'Work with the material yourself.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"mist-400"} -->
	<p class="has-mist-400-color has-text-color"><?php echo esc_html__( 'Sheets, audio and workbooks for your own practice, or for the people you work with. They are sold on Etsy.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div class="atlas-tool-grid">
		<?php foreach ( $atlas_etsy_tools as $atlas_tool ) : ?>
		<a class="atlas-tool atlas-tool--<?php echo esc_attr( $atlas_tool['key'] ); ?>" href="<?php echo esc_url( $atlas_tool['url'] ); ?>" target="_blank" rel="noopener">
			<span class="atlas-tool-type"><?php echo esc_html( $atlas_tool['type'] ); ?></span>
			<h3><?php echo esc_html( $atlas_tool['name'] ); ?></h3>
			<span class="atlas-tool-body"><?php echo esc_html( $atlas_tool['body'] ); ?></span>
			<span class="atlas-tool-foot"><span class="atlas-tool-price"><?php echo esc_html( $atlas_tool['price'] ); ?></span><span class="atlas-tool-go"><?php echo esc_html__( 'Get it on Etsy', 'atlas-relics' ); ?></span></span>
		</a>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->

	<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
	<p class="has-mist-400-color has-text-color has-small-font-size"><a href="https://www.etsy.com/shop/AtlasRelicsShop" target="_blank" rel="noopener"><?php echo esc_html__( 'Browse the full Etsy shop', 'atlas-relics' ); ?></a></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"atlas-books","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-800","textColor":"ivory-50"} -->
<section class="wp-block-group atlas-books has-ivory-50-color has-plum-800-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Books by Atlas Reed', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Books for slower reading.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<a class="atlas-bundle" href="<?php echo esc_url( $atlas_buy . 'RlcwC' . $atlas_utm . '-bundle' ); ?>">
		<span class="atlas-bundle-stack" aria-hidden="true"><i></i><i></i><i></i></span>
		<span class="atlas-bundle-copy">
			<span class="atlas-bundle-eyebrow"><?php echo esc_html__( 'The bundle', 'atlas-relics' ); ?></span>
			<h3><?php echo esc_html__( 'The Universal Laws Bundle', 'atlas-relics' ); ?></h3>
			<span class="atlas-bundle-body"><?php echo esc_html__( 'The Great Shift, Laws of the Universe and The Ageless Truths together. $29.99 instead of $46.09, a saving of $16.10.', 'atlas-relics' ); ?></span>
		</span>
		<span class="atlas-bundle-buy"><span class="atlas-bundle-price">$29.99</span><span class="atlas-bundle-go"><?php echo esc_html__( 'Get the bundle', 'atlas-relics' ); ?></span></span>
	</a>
	<!-- /wp:html -->

	<!-- wp:group {"className":"atlas-book-grid","layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"15rem"}} -->
	<div class="wp-block-group atlas-book-grid">
		<?php foreach ( $atlas_books as $atlas_book ) : ?>
		<?php $atlas_book_url = $atlas_buy . $atlas_book['code'] . $atlas_utm . '-books'; ?>
		<!-- wp:group {"className":"atlas-book","layout":{"type":"default"}} -->
		<div class="wp-block-group atlas-book">
			<!-- wp:html -->
			<a class="atlas-cover atlas-cover--<?php echo esc_attr( $atlas_book['key'] ); ?>" href="<?php echo esc_url( $atlas_book_url ); ?>"><span class="atlas-cover-mark" aria-hidden="true"></span><h3><?php echo esc_html( $atlas_book['name'] ); ?></h3><span class="atlas-cover-author"><?php echo esc_html__( 'Atlas Reed', 'atlas-relics' ); ?></span></a>
			<!-- /wp:html -->

			<!-- wp:paragraph {"className":"atlas-book-price","textColor":"lilac-300"} -->
			<p class="atlas-book-price has-lilac-300-color has-text-color"><?php echo esc_html( $atlas_book['price'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
			<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html( $atlas_book['body'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( $atlas_book_url ); ?>"><?php echo esc_html__( 'Get the book', 'atlas-relics' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"atlas-decks","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"plum-900","textColor":"ivory-50"} -->
<section class="wp-block-group atlas-decks has-ivory-50-color has-plum-900-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
	<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'Printed decks', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":2,"textColor":"ivory-50"} -->
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Decks for readings and rituals.', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"textColor":"mist-400"} -->
	<p class="has-mist-400-color has-text-color"><?php echo esc_html__( 'Designed by Atlas Reed and printed by Make Playing Cards.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div class="atlas-deck-grid">
		<?php foreach ( $atlas_decks as $atlas_deck ) : ?>
		<a class="atlas-deck atlas-deck--<?php echo esc_attr( $atlas_deck['key'] ); ?>" href="<?php echo esc_url( $atlas_deck['url'] ); ?>" target="_blank" rel="noopener">
			<span class="atlas-deck-card" aria-hidden="true"><span class="atlas-deck-sigil"></span></span>
			<span class="atlas-deck-type"><?php echo esc_html( $atlas_deck['type'] ); ?></span>
			<h3><?php echo esc_html( $atlas_deck['name'] ); ?></h3>
			<span class="atlas-deck-body"><?php echo esc_html( $atlas_deck['body'] ); ?></span>
			<span class="atlas-deck-go"><?php echo esc_html__( 'View the deck', 'atlas-relics' ); ?></span>
		</a>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->

	<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
	<p class="has-mist-400-color has-text-color has-small-font-size"><a href="https://www.makeplayingcards.com/sell/atlas-relics-shop" target="_blank" rel="noopener"><?php echo esc_html__( 'See every deck in the full shop', 'atlas-relics' ); ?></a></p>
	<!-- /wp:paragraph -->
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
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( home_url( '/caves/' ) ); ?>"><?php echo esc_html__( 'See all eight caves', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"atlas-doors","layout":{"type":"constrained","contentSize":"860px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}} -->
<section class="wp-block-group atlas-doors" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The store', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html__( 'Ten doors. Take the one that snags.', 'atlas-relics' ); ?></h2>
<!-- /wp:heading -->
<!-- wp:group {"className":"atlas-list","layout":{"type":"default"}} -->
<div class="wp-block-group atlas-list">
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">01</span> <a href="<?php echo esc_url( home_url( '/caves/#complete' ) ); ?>"><?php echo esc_html__( 'The Complete Descent', 'atlas-relics' ); ?></a> <span class="atlas-price">$27.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'All eight caves, the Integration Journal and The Ascent. $84.70 bought apart.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">02</span> <a href="<?php echo esc_url( home_url( '/caves/#descent' ) ); ?>"><?php echo esc_html__( 'The First Descent', 'atlas-relics' ); ?></a> <span class="atlas-price">$17.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Control, Desire and Identity in one passage. Cheaper than buying them apart.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">03</span> <a href="<?php echo esc_url( home_url( '/caves/#control' ) ); ?>"><?php echo esc_html__( 'Control', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if the need to control your life is quietly preventing you from experiencing it?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">04</span> <a href="<?php echo esc_url( home_url( '/caves/#desire' ) ); ?>"><?php echo esc_html__( 'Desire', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if the thing you want is not actually what you are searching for?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">05</span> <a href="<?php echo esc_url( home_url( '/caves/#identity' ) ); ?>"><?php echo esc_html__( 'Identity', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Who are you when you are no longer required to stay recognizable?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">06</span> <a href="<?php echo esc_url( home_url( '/caves/#silence' ) ); ?>"><?php echo esc_html__( 'Silence', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What remains when the noise stops?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">07</span> <a href="<?php echo esc_url( home_url( '/caves/#fear' ) ); ?>"><?php echo esc_html__( 'Fear', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if your fear is not trying to stop you, but trying to show you what you love?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">08</span> <a href="<?php echo esc_url( home_url( '/caves/#grief' ) ); ?>"><?php echo esc_html__( 'Grief', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if grief is not something to get over, but the shape your love takes when it outlives its object?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">09</span> <a href="<?php echo esc_url( home_url( '/caves/#shame' ) ); ?>"><?php echo esc_html__( 'Shame', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if the part of you that you hide most carefully is holding something you need?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"atlas-row"} -->
<div class="wp-block-group atlas-row">
<!-- wp:paragraph {"className":"atlas-row-head"} -->
<p class="atlas-row-head"><span class="atlas-num">10</span> <a href="<?php echo esc_url( home_url( '/caves/#attachment' ) ); ?>"><?php echo esc_html__( 'Attachment', 'atlas-relics' ); ?></a> <span class="atlas-price">$7.77</span></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'What if the tighter you grip something, the less of it you are actually able to feel?', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph {"fontSize":"small","textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color has-small-font-size"><?php echo esc_html__( 'Not sure where to start?', 'atlas-relics' ); ?> <a href="https://atlas-relics.com/b/ORl6W?utm_source=atlasrelics-site&amp;utm_medium=referral&amp;utm_campaign=home-quiz"><?php echo esc_html__( 'Get the free guide, Which Cave Are You In?', 'atlas-relics' ); ?></a></p>
<!-- /wp:paragraph -->
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
	<h2 class="wp-block-heading"><?php echo esc_html__( 'The Complete Descent', 'atlas-relics' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p><?php echo esc_html__( 'All eight caves, the Integration Journal and The Ascent in one purchase. $27.77, instead of $84.70 separately. Prefer a smaller start? The First Descent covers Control, Desire and Identity for $17.77.', 'atlas-relics' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"violet-500","textColor":"ivory-50"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ivory-50-color has-violet-500-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $atlas_buy . 'hyYON' . $atlas_utm . '-complete' ); ?>"><?php echo esc_html__( 'Begin the descent', 'atlas-relics' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline","textColor":"ivory-50"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-ivory-50-color has-text-color wp-element-button" href="<?php echo esc_url( home_url( '/caves/#complete' ) ); ?>"><?php echo esc_html__( 'See what is inside', 'atlas-relics' ); ?></a></div>
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
	<h2 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'A short note when there is something worth sharing.', 'atlas-relics' ); ?></h2>
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
