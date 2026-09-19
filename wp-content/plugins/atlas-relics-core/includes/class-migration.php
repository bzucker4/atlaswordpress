<?php
/**
 * Customer and historical order migration.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A deliberately two-step CSV importer for real customer and historical
 * order data: a **dry run** (always safe — parses and validates, writes
 * nothing) produces a reconciliation report and a token; only submitting
 * that exact token back, with an explicit confirmation checkbox, commits
 * anything to the database. There is no way to import in one step.
 *
 * This mirrors the project's own rule (docs/product.md): real data is
 * imported only after a successful dry run and explicit approval. Nothing
 * in this class runs automatically — every commit is a deliberate,
 * capability-checked, nonce-verified admin action.
 *
 * Known limitation, documented rather than hidden: one CSV row = one order
 * with at most one line item. Historical orders with multiple line items
 * aren't representable by this importer; split them across rows sharing
 * the same `external_order_id` if that's ever needed, or extend
 * `commit_order_row()` accordingly.
 */
class Atlas_Relics_Core_Migration {

	const CAPABILITY   = 'manage_woocommerce';
	const NONCE_ACTION = 'atlas_relics_migration';
	const OPTION_LAST_RUN = 'atlas_relics_core_migration_last_run';
	const CACHE_TTL_HOURS = 24;

	const CUSTOMER_COLUMNS = array( 'email', 'first_name', 'last_name', 'newsletter_consent', 'billing_address_1', 'billing_city', 'billing_state', 'billing_postcode', 'billing_country' );
	const ORDER_COLUMNS    = array( 'external_order_id', 'customer_email', 'order_date', 'status', 'total', 'currency', 'product_sku', 'product_name', 'quantity' );

	const ALLOWED_ORDER_STATUSES = array( 'completed', 'processing', 'on-hold', 'refunded', 'cancelled' );

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_post_atlas_relics_migration_dry_run', array( $this, 'handle_dry_run' ) );
		add_action( 'admin_post_atlas_relics_migration_commit', array( $this, 'handle_commit' ) );
		add_action( 'atlas_relics_core_daily_check', array( $this, 'cleanup_expired_cache_files' ) );
	}

	/**
	 * Where dry-run caches (containing real customer/order PII) live.
	 *
	 * @return string Absolute path, trailing slash included.
	 */
	private function cache_dir() {
		$dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'atlas-relics-migration/';

		if ( ! file_exists( $dir ) ) {
			wp_mkdir_p( $dir );
			// Defense in depth: the directory name isn't guessable-by-purpose,
			// but block direct access outright in case of a misconfigured
			// server. (Nginx needs an equivalent `location` block — see
			// docs/security.md.)
			file_put_contents( $dir . '.htaccess', "Deny from all\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
			file_put_contents( $dir . 'index.php', "<?php\n// Silence is golden.\n" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		}

		return $dir;
	}

	/**
	 * Add the "Atlas Relics Migration" tool under Tools.
	 */
	public function register_page() {
		add_management_page(
			__( 'Atlas Relics Migration', 'atlas-relics-core' ),
			__( 'Atlas Relics Migration', 'atlas-relics-core' ),
			self::CAPABILITY,
			'atlas-relics-migration',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Render the dry-run form, its results, and — only once a dry run has
	 * produced a live token — the commit form.
	 */
	public function render_page() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			return;
		}

		$result = get_transient( 'atlas_relics_migration_result_' . get_current_user_id() );
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Atlas Relics Migration', 'atlas-relics-core' ); ?></h1>
			<p><strong><?php echo esc_html__( 'Real customer and order data is only ever written after you review a dry run and explicitly confirm it below.', 'atlas-relics-core' ); ?></strong></p>

			<?php if ( $result ) : ?>
				<div class="notice <?php echo ! empty( $result['committed'] ) ? 'notice-success' : 'notice-info'; ?>">
					<p>
						<?php
						if ( ! empty( $result['committed'] ) ) {
							printf(
								/* translators: 1: created, 2: updated, 3: skipped */
								esc_html__( 'Import committed: %1$d created, %2$d updated, %3$d skipped.', 'atlas-relics-core' ),
								(int) $result['created'],
								(int) $result['updated'],
								(int) $result['skipped']
							);
						} else {
							printf(
								/* translators: 1: type, 2: valid rows, 3: invalid rows */
								esc_html__( 'Dry run complete for %1$s: %2$d valid row(s), %3$d invalid. Nothing has been written yet.', 'atlas-relics-core' ),
								esc_html( $result['type'] ),
								(int) $result['valid'],
								(int) $result['invalid']
							);
						}
						?>
					</p>
					<?php if ( ! empty( $result['errors'] ) ) : ?>
						<ul>
							<?php foreach ( array_slice( $result['errors'], 0, 25 ) as $error ) : ?>
								<li><?php echo esc_html( $error ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<?php if ( empty( $result['committed'] ) && ! empty( $result['token'] ) && $result['valid'] > 0 ) : ?>
					<h2><?php echo esc_html__( 'Step 2: commit this exact dry run', 'atlas-relics-core' ); ?></h2>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="atlas_relics_migration_commit" />
						<input type="hidden" name="token" value="<?php echo esc_attr( $result['token'] ); ?>" />
						<?php wp_nonce_field( self::NONCE_ACTION . '_commit_' . $result['token'] ); ?>
						<p>
							<label>
								<input type="checkbox" name="confirm" value="yes" required />
								<?php echo esc_html__( 'I have reviewed the dry run above and approve writing this data to the live site.', 'atlas-relics-core' ); ?>
							</label>
						</p>
						<?php submit_button( __( 'Commit import', 'atlas-relics-core' ), 'primary' ); ?>
					</form>
				<?php endif; ?>

				<?php delete_transient( 'atlas_relics_migration_result_' . get_current_user_id() ); ?>
			<?php endif; ?>

			<h2><?php echo esc_html__( 'Step 1: dry run', 'atlas-relics-core' ); ?></h2>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="atlas_relics_migration_dry_run" />
				<?php wp_nonce_field( self::NONCE_ACTION . '_dry_run' ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><?php echo esc_html__( 'Data type', 'atlas-relics-core' ); ?></th>
						<td>
							<label><input type="radio" name="type" value="customers" checked /> <?php echo esc_html__( 'Customers', 'atlas-relics-core' ); ?></label>
							&nbsp;&nbsp;
							<label><input type="radio" name="type" value="orders" /> <?php echo esc_html__( 'Historical orders', 'atlas-relics-core' ); ?></label>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="migration_csv"><?php echo esc_html__( 'CSV file', 'atlas-relics-core' ); ?></label></th>
						<td><input type="file" name="migration_csv" id="migration_csv" accept=".csv,text/csv" required /></td>
					</tr>
				</table>
				<?php submit_button( __( 'Run dry run', 'atlas-relics-core' ) ); ?>
			</form>

			<h2><?php echo esc_html__( 'Expected columns', 'atlas-relics-core' ); ?></h2>
			<p><strong><?php echo esc_html__( 'Customers:', 'atlas-relics-core' ); ?></strong> <code><?php echo esc_html( implode( ', ', self::CUSTOMER_COLUMNS ) ); ?></code></p>
			<p><strong><?php echo esc_html__( 'Orders (one line item per row):', 'atlas-relics-core' ); ?></strong> <code><?php echo esc_html( implode( ', ', self::ORDER_COLUMNS ) ); ?></code></p>
			<p class="description"><?php echo esc_html__( '"newsletter_consent" (yes/no) is stored as-is and never used to (re-)subscribe anyone automatically — see docs/security.md.', 'atlas-relics-core' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Step 1: parse and validate a CSV, writing nothing, and cache the
	 * validated rows under a random token for a possible commit.
	 */
	public function handle_dry_run() {
		if ( ! current_user_can( self::CAPABILITY ) || ! check_admin_referer( self::NONCE_ACTION . '_dry_run' ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'atlas-relics-core' ) );
		}

		$type     = isset( $_POST['type'] ) && 'orders' === $_POST['type'] ? 'orders' : 'customers';
		$redirect = admin_url( 'tools.php?page=atlas-relics-migration' );

		if ( empty( $_FILES['migration_csv']['tmp_name'] ) || ! is_uploaded_file( $_FILES['migration_csv']['tmp_name'] ) ) {
			wp_safe_redirect( $redirect );
			exit;
		}

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- server-generated temp path, not user input.
		$handle = fopen( $_FILES['migration_csv']['tmp_name'], 'r' );

		if ( ! $handle ) {
			wp_safe_redirect( $redirect );
			exit;
		}

		$header  = fgetcsv( $handle );
		$header  = is_array( $header ) ? array_map( 'strtolower', array_map( 'trim', $header ) ) : array();
		$valid   = array();
		$errors  = array();
		$row_num = 1;

		while ( ( $row = fgetcsv( $handle ) ) !== false ) {
			++$row_num;

			if ( count( $header ) !== count( $row ) ) {
				/* translators: %d: CSV row number */
				$errors[] = sprintf( __( 'Row %d: column count did not match the header.', 'atlas-relics-core' ), $row_num );
				continue;
			}

			$data       = array_combine( $header, $row );
			$validation = 'orders' === $type ? $this->validate_order_row( $data ) : $this->validate_customer_row( $data );

			if ( $validation['valid'] ) {
				$valid[] = $validation['normalized'];
			} else {
				/* translators: 1: CSV row number, 2: validation error */
				$errors[] = sprintf( __( 'Row %1$d: %2$s', 'atlas-relics-core' ), $row_num, $validation['error'] );
			}
		}

		fclose( $handle );

		$token = bin2hex( random_bytes( 16 ) );
		$cache = array(
			'type'  => $type,
			'rows'  => $valid,
			'user'  => get_current_user_id(),
			'time'  => time(),
		);

		file_put_contents( $this->cache_dir() . $token . '.json', wp_json_encode( $cache ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents

		$summary = array(
			'type'      => $type,
			'valid'     => count( $valid ),
			'invalid'   => count( $errors ),
			'errors'    => $errors,
			'token'     => $token,
			'committed' => false,
			'dry_run'   => true,
			'time'      => current_time( 'mysql' ),
		);

		set_transient( 'atlas_relics_migration_result_' . get_current_user_id(), $summary, HOUR_IN_SECONDS );
		update_option( self::OPTION_LAST_RUN, $summary );

		wp_safe_redirect( $redirect );
		exit;
	}

	/**
	 * Step 2: commit a previously-validated dry run.
	 */
	public function handle_commit() {
		$token = isset( $_POST['token'] ) ? sanitize_text_field( wp_unslash( $_POST['token'] ) ) : '';

		if ( ! current_user_can( self::CAPABILITY ) || ! check_admin_referer( self::NONCE_ACTION . '_commit_' . $token ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'atlas-relics-core' ) );
		}

		$redirect = admin_url( 'tools.php?page=atlas-relics-migration' );

		if ( empty( $_POST['confirm'] ) || ! preg_match( '/^[a-f0-9]{32}$/', $token ) ) {
			wp_safe_redirect( $redirect );
			exit;
		}

		$path = $this->cache_dir() . $token . '.json';

		if ( ! file_exists( $path ) ) {
			wp_safe_redirect( $redirect );
			exit;
		}

		$cache = json_decode( file_get_contents( $path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_get_contents

		// Consume the token immediately so the same dry run can never be
		// committed twice, whether by accident or by a replayed request.
		wp_delete_file( $path );

		if ( ! is_array( $cache ) || empty( $cache['rows'] ) ) {
			wp_safe_redirect( $redirect );
			exit;
		}

		$results = array(
			'created' => 0,
			'updated' => 0,
			'skipped' => 0,
			'errors'  => array(),
		);

		foreach ( $cache['rows'] as $row ) {
			if ( 'orders' === $cache['type'] ) {
				$this->commit_order_row( $row, $results );
			} else {
				$this->commit_customer_row( $row, $results );
			}
		}

		$summary = array(
			'type'      => $cache['type'],
			'valid'     => count( $cache['rows'] ),
			'invalid'   => 0,
			'created'   => $results['created'],
			'updated'   => $results['updated'],
			'skipped'   => $results['skipped'],
			'errors'    => $results['errors'],
			'committed' => true,
			'dry_run'   => false,
			'time'      => current_time( 'mysql' ),
		);

		set_transient( 'atlas_relics_migration_result_' . get_current_user_id(), $summary, HOUR_IN_SECONDS );
		update_option( self::OPTION_LAST_RUN, $summary );

		wp_safe_redirect( $redirect );
		exit;
	}

	/**
	 * Validate one customer CSV row.
	 *
	 * @param array $data Row keyed by header column.
	 * @return array{valid:bool,error?:string,normalized?:array}
	 */
	private function validate_customer_row( array $data ) {
		$email = isset( $data['email'] ) ? sanitize_email( trim( $data['email'] ) ) : '';

		if ( ! is_email( $email ) ) {
			return array(
				'valid' => false,
				'error' => __( 'missing or invalid email.', 'atlas-relics-core' ),
			);
		}

		return array(
			'valid'      => true,
			'normalized' => array(
				'email'              => $email,
				'first_name'         => sanitize_text_field( $data['first_name'] ?? '' ),
				'last_name'          => sanitize_text_field( $data['last_name'] ?? '' ),
				'newsletter_consent' => 'yes' === strtolower( trim( $data['newsletter_consent'] ?? '' ) ) ? 'yes' : 'no',
				'billing_address_1'  => sanitize_text_field( $data['billing_address_1'] ?? '' ),
				'billing_city'       => sanitize_text_field( $data['billing_city'] ?? '' ),
				'billing_state'      => sanitize_text_field( $data['billing_state'] ?? '' ),
				'billing_postcode'   => sanitize_text_field( $data['billing_postcode'] ?? '' ),
				'billing_country'    => sanitize_text_field( $data['billing_country'] ?? '' ),
				'exists'             => (bool) email_exists( $email ),
			),
		);
	}

	/**
	 * Validate one order CSV row.
	 *
	 * @param array $data Row keyed by header column.
	 * @return array{valid:bool,error?:string,normalized?:array}
	 */
	private function validate_order_row( array $data ) {
		$email = isset( $data['customer_email'] ) ? sanitize_email( trim( $data['customer_email'] ) ) : '';

		if ( ! is_email( $email ) ) {
			return array(
				'valid' => false,
				'error' => __( 'missing or invalid customer_email.', 'atlas-relics-core' ),
			);
		}

		$status = strtolower( trim( $data['status'] ?? '' ) );

		if ( ! in_array( $status, self::ALLOWED_ORDER_STATUSES, true ) ) {
			return array(
				'valid' => false,
				/* translators: %s: comma-separated list of allowed order statuses */
				'error' => sprintf( __( 'status must be one of: %s.', 'atlas-relics-core' ), implode( ', ', self::ALLOWED_ORDER_STATUSES ) ),
			);
		}

		$date = DateTime::createFromFormat( 'Y-m-d', trim( $data['order_date'] ?? '' ) );

		if ( ! $date ) {
			return array(
				'valid' => false,
				'error' => __( 'order_date must be in YYYY-MM-DD format.', 'atlas-relics-core' ),
			);
		}

		if ( ! isset( $data['total'] ) || ! is_numeric( trim( $data['total'] ) ) ) {
			return array(
				'valid' => false,
				'error' => __( 'total must be numeric.', 'atlas-relics-core' ),
			);
		}

		$external_id = sanitize_text_field( $data['external_order_id'] ?? '' );

		return array(
			'valid'      => true,
			'normalized' => array(
				'external_order_id' => $external_id,
				'customer_email'    => $email,
				'order_date'        => $date->format( 'Y-m-d H:i:s' ),
				'status'            => $status,
				'total'             => wc_format_decimal( trim( $data['total'] ) ),
				'currency'          => sanitize_text_field( $data['currency'] ?? '' ),
				'product_sku'       => sanitize_text_field( $data['product_sku'] ?? '' ),
				'product_name'      => sanitize_text_field( $data['product_name'] ?? '' ),
				'quantity'          => max( 1, absint( $data['quantity'] ?? 1 ) ),
				'already_imported'  => $external_id ? $this->order_exists_by_external_id( $external_id ) : false,
			),
		);
	}

	/**
	 * Check whether an order with the given external ID has already been
	 * imported, so re-running an import is safe.
	 *
	 * @param string $external_id Source system's order ID.
	 * @return bool
	 */
	private function order_exists_by_external_id( $external_id ) {
		$orders = wc_get_orders(
			array(
				'limit'      => 1,
				'return'     => 'ids',
				'meta_key'   => '_atlas_relics_external_order_id', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value' => $external_id, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			)
		);

		return ! empty( $orders );
	}

	/**
	 * Create or update a WP/WooCommerce customer from a validated row.
	 *
	 * @param array $row     Normalized customer row.
	 * @param array $results Results accumulator, by reference.
	 */
	private function commit_customer_row( array $row, array &$results ) {
		$user = get_user_by( 'email', $row['email'] );

		if ( ! $user ) {
			$user_id = wc_create_new_customer( $row['email'], '', wp_generate_password( 20 ) );

			if ( is_wp_error( $user_id ) ) {
				$results['skipped']++;
				$results['errors'][] = $row['email'] . ': ' . $user_id->get_error_message();
				return;
			}

			$results['created']++;
		} else {
			$user_id = $user->ID;
			$results['updated']++;
		}

		update_user_meta( $user_id, 'first_name', $row['first_name'] );
		update_user_meta( $user_id, 'last_name', $row['last_name'] );
		update_user_meta( $user_id, 'billing_first_name', $row['first_name'] );
		update_user_meta( $user_id, 'billing_last_name', $row['last_name'] );
		update_user_meta( $user_id, 'billing_address_1', $row['billing_address_1'] );
		update_user_meta( $user_id, 'billing_city', $row['billing_city'] );
		update_user_meta( $user_id, 'billing_state', $row['billing_state'] );
		update_user_meta( $user_id, 'billing_postcode', $row['billing_postcode'] );
		update_user_meta( $user_id, 'billing_country', $row['billing_country'] );

		// Preserve consent as data only — never call the MailerLite API
		// here. Re-subscribing someone based on a historical export would
		// override whatever they've actually chosen since.
		update_user_meta( $user_id, '_atlas_relics_newsletter_consent', $row['newsletter_consent'] );
		update_user_meta( $user_id, '_atlas_relics_migrated_customer', 'yes' );
	}

	/**
	 * Create a historical WooCommerce order from a validated row.
	 *
	 * @param array $row     Normalized order row.
	 * @param array $results Results accumulator, by reference.
	 */
	private function commit_order_row( array $row, array &$results ) {
		// Re-check at commit time rather than trusting the dry run's cached
		// flag — the cache can be up to CACHE_TTL_HOURS old, and another
		// import may have created this order in the meantime.
		if ( ! empty( $row['external_order_id'] ) && $this->order_exists_by_external_id( $row['external_order_id'] ) ) {
			$results['skipped']++;
			return;
		}

		$user  = get_user_by( 'email', $row['customer_email'] );
		$order = wc_create_order( array( 'customer_id' => $user ? $user->ID : 0 ) );

		if ( is_wp_error( $order ) ) {
			$results['skipped']++;
			$results['errors'][] = $row['customer_email'] . ': ' . $order->get_error_message();
			return;
		}

		$order->set_billing_email( $row['customer_email'] );
		$order->set_date_created( $row['order_date'] );

		if ( ! empty( $row['currency'] ) ) {
			$order->set_currency( $row['currency'] );
		}

		$product_id = ! empty( $row['product_sku'] ) ? wc_get_product_id_by_sku( $row['product_sku'] ) : 0;

		if ( $product_id ) {
			$order->add_product( wc_get_product( $product_id ), $row['quantity'] );
		} elseif ( ! empty( $row['product_name'] ) ) {
			$fee = new WC_Order_Item_Fee();
			$fee->set_name( $row['product_name'] );
			$fee->set_total( $row['total'] );
			$order->add_item( $fee );
		}

		$order->set_total( $row['total'] );
		$order->update_meta_data( '_atlas_relics_migrated_order', 'yes' );

		if ( ! empty( $row['external_order_id'] ) ) {
			$order->update_meta_data( '_atlas_relics_external_order_id', $row['external_order_id'] );
		}

		$order->set_status( $row['status'] );
		$order->save();

		$results['created']++;
	}

	/**
	 * Daily cleanup: remove dry-run cache files nobody committed within
	 * the TTL, so uploaded PII doesn't linger indefinitely.
	 */
	public function cleanup_expired_cache_files() {
		$dir = $this->cache_dir();

		foreach ( glob( $dir . '*.json' ) ?: array() as $file ) {
			if ( filemtime( $file ) < time() - ( self::CACHE_TTL_HOURS * HOUR_IN_SECONDS ) ) {
				wp_delete_file( $file );
			}
		}
	}
}
