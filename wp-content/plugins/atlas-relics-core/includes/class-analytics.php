<?php
/**
 * Lightweight internal analytics.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A small operational snapshot built entirely from data this site already
 * has (WooCommerce orders, fulfillment records, migrated customer meta) —
 * deliberately not a wrapper around Google Analytics or another external
 * service, since that needs a real tracking ID/credential this codebase
 * doesn't have. Wiring an external analytics *script* is a front-end
 * concern for whoever sets up the live site (see docs/launch.md), not
 * something this class should hard-code a placeholder ID for.
 *
 * Shown both as a wp-admin dashboard widget and inline on the Atlas
 * Relics Ops page, from the same `get_snapshot()` data so the two never
 * disagree.
 */
class Atlas_Relics_Core_Analytics {

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'register_dashboard_widget' ) );
	}

	/**
	 * Register the "Atlas Relics Snapshot" widget on the main wp-admin
	 * dashboard.
	 */
	public function register_dashboard_widget() {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		wp_add_dashboard_widget(
			'atlas_relics_core_snapshot',
			__( 'Atlas Relics Snapshot', 'atlas-relics-core' ),
			array( $this, 'render_widget' )
		);
	}

	/**
	 * Render the dashboard widget.
	 */
	public function render_widget() {
		self::render_snapshot( self::get_snapshot() );
	}

	/**
	 * Render a snapshot array as a definition list. Shared by the wp-admin
	 * widget and the Ops page so the markup only exists once.
	 *
	 * @param array $stats Snapshot from get_snapshot().
	 */
	public static function render_snapshot( array $stats ) {
		?>
		<ul class="atlas-relics-snapshot">
			<li><?php printf( esc_html__( 'Orders (last 30 days): %s', 'atlas-relics-core' ), '<strong>' . esc_html( $stats['orders_30d'] ) . '</strong>' ); ?></li>
			<li><?php printf( esc_html__( 'Revenue (last 30 days): %s', 'atlas-relics-core' ), '<strong>' . wp_kses_post( wc_price( $stats['revenue_30d'] ) ) . '</strong>' ); ?></li>
			<li><?php printf( esc_html__( 'Fulfillment awaiting a response: %s', 'atlas-relics-core' ), '<strong>' . esc_html( $stats['fulfillment_awaiting'] ) . '</strong>' ); ?></li>
			<li><?php printf( esc_html__( 'Fulfillment ready to prepare: %s', 'atlas-relics-core' ), '<strong>' . esc_html( $stats['fulfillment_received'] ) . '</strong>' ); ?></li>
			<li><?php printf( esc_html__( 'Delivered (last 30 days): %s', 'atlas-relics-core' ), '<strong>' . esc_html( $stats['fulfillment_delivered_30d'] ) . '</strong>' ); ?></li>
			<li><?php printf( esc_html__( 'Migrated customers: %s', 'atlas-relics-core' ), '<strong>' . esc_html( $stats['migrated_customers'] ) . '</strong>' ); ?></li>
			<li><?php printf( esc_html__( 'Migrated customers opted into newsletter: %s', 'atlas-relics-core' ), '<strong>' . esc_html( $stats['newsletter_consent_yes'] ) . '</strong>' ); ?></li>
		</ul>
		<?php
	}

	/**
	 * Compute the snapshot. All counts are cheap at this project's scale
	 * (a niche storefront, not a high-volume marketplace) — if that stops
	 * being true, replace the WC_Order_Query sum with a direct
	 * `wc_get_order_stats` / HPOS analytics query instead of optimizing
	 * this further pre-emptively.
	 *
	 * @return array
	 */
	public static function get_snapshot() {
		$thirty_days_ago = gmdate( 'Y-m-d', strtotime( '-30 days' ) );

		$orders = wc_get_orders(
			array(
				'status'       => array( 'completed', 'processing' ),
				'date_created' => '>=' . $thirty_days_ago,
				'limit'        => -1,
				'return'       => 'objects',
			)
		);

		$revenue = array_sum( array_map( fn( $order ) => (float) $order->get_total(), $orders ) );

		return array(
			'orders_30d'                 => count( $orders ),
			'revenue_30d'                => $revenue,
			'fulfillment_awaiting'       => self::count_fulfillment_by_status( Atlas_Relics_Core_Fulfillment::STATUS_AWAITING ),
			'fulfillment_received'       => self::count_fulfillment_by_status( Atlas_Relics_Core_Fulfillment::STATUS_RECEIVED ),
			'fulfillment_delivered_30d'  => self::count_delivered_since( $thirty_days_ago ),
			'migrated_customers'         => self::count_users_by_meta( '_atlas_relics_migrated_customer', 'yes' ),
			'newsletter_consent_yes'     => self::count_users_by_meta( '_atlas_relics_newsletter_consent', 'yes' ),
		);
	}

	/**
	 * Count fulfillment records in a given status.
	 *
	 * @param string $status One of the Atlas_Relics_Core_Fulfillment::STATUS_* constants.
	 * @return int
	 */
	private static function count_fulfillment_by_status( $status ) {
		$query = new WP_Query(
			array(
				'post_type'      => Atlas_Relics_Core_Fulfillment::POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'   => '_status',
						'value' => $status,
					),
				),
			)
		);

		return (int) $query->found_posts;
	}

	/**
	 * Count fulfillment records delivered on or after a given date.
	 *
	 * @param string $since Y-m-d date.
	 * @return int
	 */
	private static function count_delivered_since( $since ) {
		$query = new WP_Query(
			array(
				'post_type'      => Atlas_Relics_Core_Fulfillment::POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'     => '_delivered_at',
						'value'   => $since,
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
			)
		);

		return (int) $query->found_posts;
	}

	/**
	 * Count users with a given meta key/value.
	 *
	 * @param string $key   Meta key.
	 * @param string $value Meta value.
	 * @return int
	 */
	private static function count_users_by_meta( $key, $value ) {
		$query = new WP_User_Query(
			array(
				'meta_key'    => $key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => $value, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'fields'      => 'ID',
				'number'      => 1,
				'count_total' => true,
			)
		);

		return (int) $query->get_total();
	}
}
