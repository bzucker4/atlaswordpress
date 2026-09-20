<?php
/**
 * Conscious Mirror / Pattern Map fulfillment automation.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tracks the personalized-reading fulfillment lifecycle for products an
 * admin has flagged as "Conscious Mirror" or "Pattern Map" type:
 *
 *   order completed → fulfillment record created, customer emailed a
 *   personalized Tally link → customer submits → webhook matches it back
 *   to the record → admin is notified to prepare the reading → admin
 *   marks it delivered from Atlas Relics Ops.
 *
 * Records are stored as a private `ar_fulfillment` post per
 * order item, not a new custom table — this keeps the data queryable
 * with WP_Query/meta queries without a schema migration, which matters
 * more here than raw query performance at this project's scale.
 */
class Atlas_Relics_Core_Fulfillment {

	const POST_TYPE      = 'ar_fulfillment'; // Max 20 chars: WordPress rejects longer post type slugs.
	const META_PRODUCT_TYPE = '_atlas_relics_fulfillment_type';

	const STATUS_AWAITING  = 'awaiting_response';
	const STATUS_RECEIVED  = 'response_received';
	const STATUS_DELIVERED = 'delivered';

	const OPTION_UNMATCHED_LOG = 'atlas_relics_core_unmatched_tally_submissions';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );

		add_action( 'add_meta_boxes_product', array( $this, 'register_product_meta_box' ) );
		add_action( 'save_post_product', array( $this, 'save_product_meta_box' ) );

		add_action( 'woocommerce_order_status_completed', array( $this, 'create_fulfillment_records' ) );
		add_action( 'atlas_relics_core_tally_submission_received', array( $this, 'handle_tally_submission' ), 10, 4 );

		add_action( 'admin_post_atlas_relics_mark_delivered', array( $this, 'handle_mark_delivered' ) );

		add_action( 'atlas_relics_core_daily_check', array( $this, 'send_reminders' ) );
		if ( ! wp_next_scheduled( 'atlas_relics_core_daily_check' ) ) {
			wp_schedule_event( time(), 'daily', 'atlas_relics_core_daily_check' );
		}
	}

	/**
	 * Register the (admin-only, no public UI) fulfillment record post type.
	 */
	public function register_post_type() {
		register_post_type(
			self::POST_TYPE,
			array(
				'label'           => __( 'Atlas Relics Fulfillment', 'atlas-relics-core' ),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'show_in_rest'    => false,
				'capability_type' => 'page',
				'supports'        => array( 'title' ),
			)
		);
	}

	/**
	 * Add the product-level "which questionnaire does this need" field.
	 */
	public function register_product_meta_box() {
		add_meta_box(
			'atlas-relics-fulfillment',
			__( 'Atlas Relics Fulfillment', 'atlas-relics-core' ),
			array( $this, 'render_product_meta_box' ),
			'product',
			'side',
			'default'
		);
	}

	/**
	 * Render the product-level fulfillment type field.
	 *
	 * @param WP_Post $post Current product post.
	 */
	public function render_product_meta_box( $post ) {
		wp_nonce_field( 'atlas_relics_save_fulfillment_type', 'atlas_relics_fulfillment_nonce' );
		$current = get_post_meta( $post->ID, self::META_PRODUCT_TYPE, true );
		?>
		<p>
			<label for="atlas-relics-fulfillment-type"><?php echo esc_html__( 'Requires a personalized reading?', 'atlas-relics-core' ); ?></label>
			<select id="atlas-relics-fulfillment-type" name="atlas_relics_fulfillment_type" class="widefat">
				<option value=""><?php echo esc_html__( 'No', 'atlas-relics-core' ); ?></option>
				<option value="conscious-mirror" <?php selected( $current, 'conscious-mirror' ); ?>><?php echo esc_html__( 'Conscious Mirror', 'atlas-relics-core' ); ?></option>
				<option value="pattern-map" <?php selected( $current, 'pattern-map' ); ?>><?php echo esc_html__( 'Pattern Map', 'atlas-relics-core' ); ?></option>
			</select>
		</p>
		<p class="description"><?php echo esc_html__( 'When set, completing an order for this product emails the customer a personalized questionnaire link and opens a fulfillment record in Atlas Relics Ops.', 'atlas-relics-core' ); ?></p>
		<?php
	}

	/**
	 * Persist the product-level fulfillment type field.
	 *
	 * @param int $post_id Product ID being saved.
	 */
	public function save_product_meta_box( $post_id ) {
		if ( ! isset( $_POST['atlas_relics_fulfillment_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['atlas_relics_fulfillment_nonce'] ) ), 'atlas_relics_save_fulfillment_type' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_product', $post_id ) ) {
			return;
		}

		$type = isset( $_POST['atlas_relics_fulfillment_type'] ) ? sanitize_key( wp_unslash( $_POST['atlas_relics_fulfillment_type'] ) ) : '';

		if ( in_array( $type, array( 'conscious-mirror', 'pattern-map' ), true ) ) {
			update_post_meta( $post_id, self::META_PRODUCT_TYPE, $type );
		} else {
			delete_post_meta( $post_id, self::META_PRODUCT_TYPE );
		}
	}

	/**
	 * When an order completes, open a fulfillment record for each line
	 * item whose product needs a personalized reading, and email the
	 * customer their questionnaire link.
	 *
	 * @param int $order_id Completed order ID.
	 */
	public function create_fulfillment_records( $order_id ) {
		$order = wc_get_order( $order_id );

		if ( ! $order ) {
			return;
		}

		foreach ( $order->get_items() as $item_id => $item ) {
			$product = $item->get_product();

			if ( ! $product ) {
				continue;
			}

			$type = get_post_meta( $product->get_id(), self::META_PRODUCT_TYPE, true );

			if ( empty( $type ) || $this->get_existing_fulfillment( $order_id, $item_id ) ) {
				continue;
			}

			$fulfillment_id = wp_insert_post(
				array(
					'post_type'   => self::POST_TYPE,
					'post_status' => 'publish',
					'post_title'  => sprintf( 'Order #%1$d — %2$s', $order_id, $type ),
					'meta_input'  => array(
						'_order_id'        => $order_id,
						'_order_item_id'   => $item_id,
						'_product_id'      => $product->get_id(),
						'_customer_email'  => $order->get_billing_email(),
						'_type'            => $type,
						'_status'          => self::STATUS_AWAITING,
						'_reminder_sent_at' => '',
					),
				),
				true
			);

			if ( is_wp_error( $fulfillment_id ) ) {
				continue;
			}

			$this->email_customer_form_link( $fulfillment_id );
		}
	}

	/**
	 * Find an existing fulfillment record for an order line item, if any
	 * (guards against duplicate records if this hook fires more than once
	 * for the same order — e.g. a status change that re-triggers "completed").
	 *
	 * @param int $order_id Order ID.
	 * @param int $item_id  Order item ID.
	 * @return int Fulfillment post ID, or 0 if none exists.
	 */
	private function get_existing_fulfillment( $order_id, $item_id ) {
		$posts = get_posts(
			array(
				'post_type'   => self::POST_TYPE,
				'post_status' => 'publish',
				'numberposts' => 1,
				'fields'      => 'ids',
				'meta_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'   => '_order_id',
						'value' => $order_id,
					),
					array(
						'key'   => '_order_item_id',
						'value' => $item_id,
					),
				),
			)
		);

		return $posts ? (int) $posts[0] : 0;
	}

	/**
	 * Email the customer their personalized Tally link for a fulfillment
	 * record.
	 *
	 * @param int $fulfillment_id Fulfillment post ID.
	 */
	private function email_customer_form_link( $fulfillment_id ) {
		$type          = get_post_meta( $fulfillment_id, '_type', true );
		$email         = get_post_meta( $fulfillment_id, '_customer_email', true );
		$form_url      = Atlas_Relics_Core_Settings::get( 'tally_' . str_replace( '-', '_', $type ) . '_form_url' );
		$personal_link = Atlas_Relics_Core_Tally::build_form_link( $form_url, $fulfillment_id );

		if ( empty( $email ) || empty( $personal_link ) ) {
			return;
		}

		$label = 'pattern-map' === $type ? __( 'Pattern Map', 'atlas-relics-core' ) : __( 'Conscious Mirror', 'atlas-relics-core' );

		wp_mail(
			$email,
			sprintf(
				/* translators: %s: reading name (Conscious Mirror / Pattern Map) */
				__( 'A few questions for your %s', 'atlas-relics-core' ),
				$label
			),
			sprintf(
				/* translators: 1: reading name, 2: personalized form link */
				__( "Thank you for your order. Your %1\$s is built from your own answers, so we'd love to hear from you:\n\n%2\$s\n\nTake your time — there's no rush.", 'atlas-relics-core' ),
				$label,
				$personal_link
			)
		);
	}

	/**
	 * Match an incoming Tally submission to its fulfillment record.
	 *
	 * @param int    $fulfillment_id Fulfillment record ID from the form's hidden field.
	 * @param string $email          Respondent email from the submission.
	 * @param string $submission_id  Tally submission ID.
	 */
	public function handle_tally_submission( $fulfillment_id, $email, $submission_id ) {
		$post = $fulfillment_id ? get_post( $fulfillment_id ) : null;

		if ( ! $post || self::POST_TYPE !== $post->post_type ) {
			$this->log_unmatched_submission( $fulfillment_id, $email, $submission_id );
			return;
		}

		$expected_email = get_post_meta( $fulfillment_id, '_customer_email', true );

		if ( $email && $expected_email && ! hash_equals( strtolower( $expected_email ), strtolower( $email ) ) ) {
			// Record and email exist but don't match each other — flag for a human rather than guessing.
			$this->log_unmatched_submission( $fulfillment_id, $email, $submission_id, 'email_mismatch' );
		}

		update_post_meta( $fulfillment_id, '_status', self::STATUS_RECEIVED );
		update_post_meta( $fulfillment_id, '_tally_submission_id', $submission_id );

		$this->notify_admin(
			__( 'A questionnaire response is ready to fulfill', 'atlas-relics-core' ),
			sprintf(
				/* translators: 1: fulfillment title, 2: Tally submission ID */
				__( "%1\$s is ready for you to prepare. Tally submission ID: %2\$s\n\nMark it delivered from Atlas Relics Ops once it's sent.", 'atlas-relics-core' ),
				get_the_title( $fulfillment_id ),
				$submission_id ?: __( 'unknown', 'atlas-relics-core' )
			)
		);
	}

	/**
	 * Record a Tally submission that couldn't be matched to a fulfillment
	 * record, and tell the admin so it can be reconciled by hand.
	 *
	 * @param int    $fulfillment_id Attempted fulfillment ID (may be 0 or invalid).
	 * @param string $email          Respondent email, if found.
	 * @param string $submission_id  Tally submission ID.
	 * @param string $reason         Short machine-readable reason.
	 */
	private function log_unmatched_submission( $fulfillment_id, $email, $submission_id, $reason = 'not_found' ) {
		$log   = get_option( self::OPTION_UNMATCHED_LOG, array() );
		$log[] = array(
			'fulfillment_id' => $fulfillment_id,
			'email'          => $email,
			'submission_id'  => $submission_id,
			'reason'         => $reason,
			'time'           => current_time( 'mysql' ),
		);

		// Cap the log so a burst of bad requests can't grow this option unbounded.
		if ( count( $log ) > 200 ) {
			$log = array_slice( $log, -200 );
		}

		update_option( self::OPTION_UNMATCHED_LOG, $log );

		$this->notify_admin(
			__( 'A Tally submission could not be matched', 'atlas-relics-core' ),
			sprintf(
				/* translators: 1: reason code, 2: fulfillment ID attempted, 3: respondent email */
				__( "Reason: %1\$s\nFulfillment ID: %2\$d\nRespondent email: %3\$s\n\nCheck Atlas Relics Ops → Unmatched Submissions.", 'atlas-relics-core' ),
				$reason,
				$fulfillment_id,
				$email ?: __( '(none)', 'atlas-relics-core' )
			)
		);
	}

	/**
	 * Send the admin notification email used throughout this class.
	 *
	 * @param string $subject Email subject.
	 * @param string $message Email body.
	 */
	private function notify_admin( $subject, $message ) {
		$to = Atlas_Relics_Core_Settings::get( 'fulfillment_notify_email', get_option( 'admin_email' ) );
		wp_mail( $to, '[Atlas Relics] ' . $subject, $message );
	}

	/**
	 * Daily cron: remind customers who haven't responded yet.
	 */
	public function send_reminders() {
		$days = (int) Atlas_Relics_Core_Settings::get( 'fulfillment_reminder_days', '3' );
		$days = $days > 0 ? $days : 3;

		$stale = get_posts(
			array(
				'post_type'   => self::POST_TYPE,
				'post_status' => 'publish',
				'numberposts' => 50,
				'fields'      => 'ids',
				'date_query'  => array(
					array( 'before' => $days . ' days ago' ),
				),
				'meta_query'  => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					array(
						'key'   => '_status',
						'value' => self::STATUS_AWAITING,
					),
					array(
						'key'     => '_reminder_sent_at',
						'value'   => '',
						'compare' => '=',
					),
				),
			)
		);

		foreach ( $stale as $fulfillment_id ) {
			$this->email_customer_form_link( $fulfillment_id );
			update_post_meta( $fulfillment_id, '_reminder_sent_at', current_time( 'mysql' ) );
		}
	}

	/**
	 * Admin action: mark a fulfillment record delivered.
	 */
	public function handle_mark_delivered() {
		if ( ! current_user_can( 'manage_woocommerce' ) || ! check_admin_referer( 'atlas_relics_mark_delivered' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'atlas-relics-core' ) );
		}

		$fulfillment_id = isset( $_GET['fulfillment_id'] ) ? absint( $_GET['fulfillment_id'] ) : 0;
		$post           = get_post( $fulfillment_id );

		if ( $post && self::POST_TYPE === $post->post_type ) {
			update_post_meta( $fulfillment_id, '_status', self::STATUS_DELIVERED );
			update_post_meta( $fulfillment_id, '_delivered_at', current_time( 'mysql' ) );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=atlas-relics-ops' ) );
		exit;
	}
}
