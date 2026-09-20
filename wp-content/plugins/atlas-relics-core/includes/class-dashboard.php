<?php
/**
 * Atlas Relics Ops admin dashboard.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A single top-level admin page giving an admin the operational view
 * Phase 3 asked for: what fulfillment is waiting on a customer, what's
 * ready to prepare, what Tally submissions couldn't be matched
 * automatically, and the status of the last migration dry run/import —
 * without digging through Pages, Tools, and Settings separately.
 */
class Atlas_Relics_Core_Dashboard {

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
	}

	/**
	 * Add the "Atlas Relics Ops" top-level admin page.
	 */
	public function register_page() {
		add_menu_page(
			__( 'Atlas Relics Ops', 'atlas-relics-core' ),
			__( 'Atlas Relics Ops', 'atlas-relics-core' ),
			'manage_woocommerce',
			'atlas-relics-ops',
			array( $this, 'render_page' ),
			'dashicons-visibility',
			56
		);
	}

	/**
	 * Render the dashboard.
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Atlas Relics Ops', 'atlas-relics-core' ); ?></h1>

			<h2><?php echo esc_html__( 'Snapshot', 'atlas-relics-core' ); ?></h2>
			<?php Atlas_Relics_Core_Analytics::render_snapshot( Atlas_Relics_Core_Analytics::get_snapshot() ); ?>

			<h2><?php echo esc_html__( 'Fulfillment', 'atlas-relics-core' ); ?></h2>
			<?php $this->render_fulfillment_table(); ?>

			<h2><?php echo esc_html__( 'Unmatched Tally submissions', 'atlas-relics-core' ); ?></h2>
			<?php $this->render_unmatched_submissions(); ?>

			<h2><?php echo esc_html__( 'Migration', 'atlas-relics-core' ); ?></h2>
			<?php $this->render_migration_status(); ?>

			<h2><?php echo esc_html__( 'Quick links', 'atlas-relics-core' ); ?></h2>
			<ul>
				<li><a href="<?php echo esc_url( admin_url( 'tools.php?page=atlas-relics-beacons-import' ) ); ?>"><?php echo esc_html__( 'Beacons Import', 'atlas-relics-core' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url( 'tools.php?page=atlas-relics-migration' ) ); ?>"><?php echo esc_html__( 'Customer & Order Migration', 'atlas-relics-core' ); ?></a></li>
				<li><a href="<?php echo esc_url( admin_url( 'options-general.php?page=atlas-relics-core' ) ); ?>"><?php echo esc_html__( 'Settings', 'atlas-relics-core' ); ?></a></li>
			</ul>
		</div>
		<?php
	}

	/**
	 * List fulfillment records that are awaiting a response or ready to
	 * be prepared and delivered.
	 */
	private function render_fulfillment_table() {
		$records = get_posts(
			array(
				'post_type'   => Atlas_Relics_Core_Fulfillment::POST_TYPE,
				'post_status' => 'publish',
				'numberposts' => 50,
				'meta_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_status',
						'value'   => Atlas_Relics_Core_Fulfillment::STATUS_DELIVERED,
						'compare' => '!=',
					),
				),
			)
		);

		if ( empty( $records ) ) {
			echo '<p>' . esc_html__( 'Nothing waiting — every fulfillment is delivered.', 'atlas-relics-core' ) . '</p>';
			return;
		}
		?>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php echo esc_html__( 'Order', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Type', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Customer', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Status', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Opened', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Actions', 'atlas-relics-core' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ( $records as $record ) : ?>
				<?php
				$order_id = (int) get_post_meta( $record->ID, '_order_id', true );
				$status   = get_post_meta( $record->ID, '_status', true );
				// Orders are not posts under HPOS, so use the order's own edit URL.
				$order    = ( $order_id && function_exists( 'wc_get_order' ) ) ? wc_get_order( $order_id ) : false;
				?>
				<tr>
					<td>
						<?php if ( $order ) : ?>
							<a href="<?php echo esc_url( $order->get_edit_order_url() ); ?>">#<?php echo esc_html( $order_id ); ?></a>
						<?php else : ?>
							#<?php echo esc_html( $order_id ); ?>
						<?php endif; ?>
					</td>
					<td><?php echo esc_html( get_post_meta( $record->ID, '_type', true ) ); ?></td>
					<td><?php echo esc_html( get_post_meta( $record->ID, '_customer_email', true ) ); ?></td>
					<td><?php echo esc_html( $status ); ?></td>
					<td><?php echo esc_html( get_the_date( '', $record ) ); ?></td>
					<td>
						<?php if ( Atlas_Relics_Core_Fulfillment::STATUS_RECEIVED === $status ) : ?>
							<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=atlas_relics_mark_delivered&fulfillment_id=' . $record->ID ), 'atlas_relics_mark_delivered' ) ); ?>">
								<?php echo esc_html__( 'Mark delivered', 'atlas-relics-core' ); ?>
							</a>
						<?php else : ?>
							&mdash;
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	}

	/**
	 * List Tally submissions the webhook couldn't match to a fulfillment
	 * record.
	 */
	private function render_unmatched_submissions() {
		$log = get_option( Atlas_Relics_Core_Fulfillment::OPTION_UNMATCHED_LOG, array() );

		if ( empty( $log ) ) {
			echo '<p>' . esc_html__( 'None — every submission matched automatically.', 'atlas-relics-core' ) . '</p>';
			return;
		}

		$log = array_slice( array_reverse( $log ), 0, 20 );
		?>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php echo esc_html__( 'When', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Reason', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Fulfillment ID', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Email', 'atlas-relics-core' ); ?></th>
					<th><?php echo esc_html__( 'Submission ID', 'atlas-relics-core' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ( $log as $entry ) : ?>
				<tr>
					<td><?php echo esc_html( $entry['time'] ?? '' ); ?></td>
					<td><?php echo esc_html( $entry['reason'] ?? '' ); ?></td>
					<td><?php echo esc_html( $entry['fulfillment_id'] ?? '' ); ?></td>
					<td><?php echo esc_html( $entry['email'] ?? '' ); ?></td>
					<td><?php echo esc_html( $entry['submission_id'] ?? '' ); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<p class="description"><?php echo esc_html__( 'Cross-reference these manually against Tally and re-open the matching order if a response was lost.', 'atlas-relics-core' ); ?></p>
		<?php
	}

	/**
	 * Show a summary of the most recent migration dry run / import.
	 */
	private function render_migration_status() {
		$summary = get_option( Atlas_Relics_Core_Migration::OPTION_LAST_RUN, null );

		if ( ! $summary ) {
			echo '<p>' . esc_html__( 'No migration has been run yet.', 'atlas-relics-core' ) . '</p>';
			return;
		}

		printf(
			'<p>%s</p>',
			esc_html(
				sprintf(
					/* translators: 1: dry_run or import, 2: date, 3: valid rows, 4: invalid rows */
					__( 'Last run: %1$s on %2$s — %3$d valid rows, %4$d invalid.', 'atlas-relics-core' ),
					! empty( $summary['dry_run'] ) ? __( 'dry run', 'atlas-relics-core' ) : __( 'live import', 'atlas-relics-core' ),
					$summary['time'] ?? '',
					$summary['valid'] ?? 0,
					$summary['invalid'] ?? 0
				)
			)
		);
	}
}
