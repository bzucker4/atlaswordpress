<?php
/**
 * Title: Shop
 * Slug: atlas-relics/shop
 * Categories: atlas-relics
 * Description: Every Atlas Relics product on one page, grouped by type, highest value first.
 *
 * @package Atlas_Relics
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// One list for the whole shop. Add a product by adding a line to its group.
// Fields: type, name, price, body, url, button label, internal (true for pages on this site).
$atlas_shop = array(
	array(
		'id'    => 'courses',
		'label' => 'Courses and the full set',
		'sub'   => 'Start with the biggest value.',
		'alt'   => false,
		'items' => array(
			array( 'Course set', 'The Complete Descent', '$27.77', 'All eight caves, the Integration Journal and The Ascent. $84.70 bought apart.', 'https://atlas-relics.com/b/hyYON?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Course', 'The Four Stages of Consciousness', '', 'Six modules across four stages: To Me, By Me, Through Me, As Me.', '/four-stages/', 'See the course', true ),
			array( 'Course', 'The Conscious Mirror', '', 'A self-paced course for noticing how you think, react and choose. Nothing is graded.', '/conscious-mirror-course/', 'See the course', true ),
		),
	),
	array(
		'id'    => 'tools',
		'label' => 'Tools and workbooks',
		'sub'   => 'For your own practice, or for the people you work with.',
		'alt'   => true,
		'items' => array(
			array( 'Audio', 'Shadow Work Audio for Practitioners', '$55', 'A 14-minute sub bass soundscape with a script, licensed for use with your clients.', 'https://www.etsy.com/listing/4570440370', 'Get it on Etsy', false ),
			array( 'Google Sheets', 'Human Design Planner', '$33', 'A decision tracker built around your type, strategy and authority.', 'https://www.etsy.com/listing/4570231442', 'Get it on Etsy', false ),
			array( 'Google Sheets', 'Lunar Cycle Consciousness Tracker', '$33', 'A shadow work dashboard that follows the lunar cycle.', 'https://www.etsy.com/listing/4569892185', 'Get it on Etsy', false ),
			array( 'Workbook and audio', 'The Nocturne Mirror', '$24', 'A Jungian dream analysis workbook, a fillable dream journal and a guided audio.', 'https://www.etsy.com/listing/4592667471', 'Get it on Etsy', false ),
			array( 'Notion system', 'The Shadow Ledger', '', 'A Jungian shadow work system for Notion.', 'https://shop.beacons.ai/atlasrelics/db21710c-65a4-4be9-a745-8bf19b342fd0', 'Get the system', false ),
			array( 'Tool', 'Vedic Life Advisor', '', 'Enter your birth details, see your chart and ask one question.', '/vedic-life-advisor/', 'See the tool', true ),
		),
	),
	array(
		'id'    => 'decks',
		'label' => 'Printed decks',
		'sub'   => 'Designed by Atlas Reed and printed by Make Playing Cards.',
		'alt'   => false,
		'items' => array(
			array( '78 cards', 'Dark Horror Tarot', '', 'A gothic 78-card tarot with a dark, haunted edge.', 'https://www.makeplayingcards.com/sell/marketplace/dark-horror-tarot.html', 'View the deck', false ),
			array( '78 cards', 'Beginner Tarot With Keywords', '', 'Keywords for zodiac, numerology and the elements on every card.', 'https://www.makeplayingcards.com/sell/marketplace/beginner-tarot-with-keywords.html', 'View the deck', false ),
			array( 'Oracle deck', 'Japanese Zen Oracle', '', 'An oracle deck of ink, blossom and stillness.', 'https://www.makeplayingcards.com/sell/marketplace/japanese-zen-oracle.html', 'View the deck', false ),
			array( 'Oracle deck', 'ShroomOracle Cards', '', 'An oracle deck drawn from the forest floor.', 'https://www.makeplayingcards.com/sell/marketplace/shroomoracle-cards.html', 'View the deck', false ),
		),
	),
	array(
		'id'    => 'books',
		'label' => 'Books by Atlas Reed',
		'sub'   => 'Slower reading.',
		'alt'   => true,
		'items' => array(
			array( 'Bundle', 'The Universal Laws Bundle', '$29.99', 'The Great Shift, Laws of the Universe and The Ageless Truths together. $46.09 apart.', 'https://atlas-relics.com/b/RlcwC?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Book', 'The Great Shift', '$19.99', 'A personal, forceful book on hidden structures and the awakening. Read it as one seer\'s map.', 'https://atlas-relics.com/b/gt6pG?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Book', 'Laws of the Universe', '$14.99', 'The Twelve Universal Laws in plain language, checked against what psychology supports. It says where the evidence stops.', 'https://atlas-relics.com/b/Glyzs?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Book', 'The Ageless Truths', '$11.11', 'A practical companion to slowing down: letting go, stillness, presence and change.', 'https://atlas-relics.com/b/fH5cW?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
		),
	),
	array(
		'id'    => 'caves',
		'label' => 'The caves',
		'sub'   => 'Guided experiences of 20 to 30 minutes each. Take one, or take them together.',
		'alt'   => false,
		'items' => array(
			array( 'Bundle', 'The First Descent', '$17.77', 'Control, Desire and Identity in one passage. Cheaper than buying them apart.', 'https://atlas-relics.com/b/f3DGy?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Seven days', 'The Ascent', '$12.77', 'A seven day return: one short teaching, one practice and a few written questions each day.', 'https://atlas-relics.com/b/0jsYS?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Printable', 'The Integration Journal', '$9.77', 'A 20-page companion with Before, After and Carry pages for each cave.', 'https://atlas-relics.com/b/JcYMK?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Control', '$7.77', 'A guided descent into the part of you that plans, manages and braces.', 'https://atlas-relics.com/b/sUMGE?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Desire', '$7.77', 'What if the thing you want is not actually what you are searching for?', 'https://atlas-relics.com/b/dMk6W?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Identity', '$7.77', 'Who are you when you are no longer required to stay recognizable?', 'https://atlas-relics.com/b/OPpd2?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Silence', '$7.77', 'What remains when the noise stops?', 'https://atlas-relics.com/b/Tqz97?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Fear', '$7.77', 'What if your fear is not trying to stop you, but trying to show you what you love?', 'https://atlas-relics.com/b/o97q8?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Grief', '$7.77', 'What if grief is not something to get over, but the shape your love takes when it outlives its object?', 'https://atlas-relics.com/b/qRYtP?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Shame', '$7.77', 'What if the part of you that you hide most carefully is holding something you need?', 'https://atlas-relics.com/b/qsX76?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Cave', 'The Cave of Attachment', '$7.77', 'What if the tighter you grip something, the less of it you are actually able to feel?', 'https://atlas-relics.com/b/E6FaA?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Buy now', false ),
			array( 'Free guide', 'Which Cave Are You In?', 'Free', 'Twelve short questions that point you to the cave you may be drawn to now.', 'https://atlas-relics.com/b/ORl6W?utm_source=atlasrelics-site&utm_medium=referral&utm_campaign=shop', 'Get the free guide', false ),
		),
	),
);
?>
<!-- wp:group {"tagName":"section","className":"atlas-subhero atlas-m-rise","layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"gradient":"plum-glow","textColor":"ivory-50"} -->
<section class="wp-block-group has-ivory-50-color has-text-color has-background has-plum-glow-gradient-background atlas-subhero atlas-m-rise" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"fontSize":"small","style":{"typography":{"letterSpacing":"0.15em","textTransform":"uppercase"}},"textColor":"lilac-300"} -->
<p class="has-lilac-300-color has-text-color has-small-font-size" style="letter-spacing:0.15em;text-transform:uppercase"><?php echo esc_html__( 'The shop', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"textColor":"ivory-50"} -->
<h1 class="wp-block-heading has-ivory-50-color has-text-color"><?php echo esc_html__( 'Everything Atlas Relics makes.', 'atlas-relics' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"medium","textColor":"ivory-50"} -->
<p class="has-ivory-50-color has-text-color has-medium-font-size"><?php echo esc_html__( 'Courses, caves, books, decks and tools in one place. Each one opens on the page where it is sold.', 'atlas-relics' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<nav class="atlas-chips" aria-label="<?php echo esc_attr__( 'Shop sections', 'atlas-relics' ); ?>">
	<?php foreach ( $atlas_shop as $atlas_group ) : ?>
	<a href="#<?php echo esc_attr( $atlas_group['id'] ); ?>"><?php echo esc_html( $atlas_group['label'] ); ?></a>
	<?php endforeach; ?>
</nav>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<?php foreach ( $atlas_shop as $atlas_group ) : ?>
<!-- wp:group {"tagName":"section","anchor":"<?php echo esc_attr( $atlas_group['id'] ); ?>","className":"atlas-shop-section","layout":{"type":"constrained","contentSize":"1200px"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}}<?php echo $atlas_group['alt'] ? ',"backgroundColor":"plum-800","textColor":"ivory-50"' : ''; ?>} -->
<section id="<?php echo esc_attr( $atlas_group['id'] ); ?>" class="wp-block-group atlas-shop-section<?php echo $atlas_group['alt'] ? ' has-ivory-50-color has-plum-800-background-color has-text-color has-background' : ''; ?>" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
<!-- wp:heading {"level":2} -->
<h2 class="wp-block-heading"><?php echo esc_html( $atlas_group['label'] ); ?></h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"mist-400"} -->
<p class="has-mist-400-color has-text-color"><?php echo esc_html( $atlas_group['sub'] ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<div class="atlas-tool-grid">
	<?php foreach ( $atlas_group['items'] as $atlas_item ) : ?>
	<?php
	$atlas_href = $atlas_item[6] ? home_url( $atlas_item[4] ) : $atlas_item[4];
	$atlas_ext  = $atlas_item[6] ? '' : ' target="_blank" rel="noopener"';
	?>
	<a class="atlas-tool" href="<?php echo esc_url( $atlas_href ); ?>"<?php echo $atlas_ext; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
		<span class="atlas-tool-type"><?php echo esc_html( $atlas_item[0] ); ?></span>
		<h3><?php echo esc_html( $atlas_item[1] ); ?></h3>
		<span class="atlas-tool-body"><?php echo esc_html( $atlas_item[3] ); ?></span>
		<span class="atlas-tool-foot"><span class="atlas-tool-price"><?php echo esc_html( $atlas_item[2] ); ?></span><span class="atlas-tool-go"><?php echo esc_html( $atlas_item[5] ); ?></span></span>
	</a>
	<?php endforeach; ?>
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<?php endforeach; ?>
