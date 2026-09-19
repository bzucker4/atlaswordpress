<?php
/**
 * Beacons product-inventory importer.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Imports a Beacons.ai product export (CSV) into WooCommerce products.
 *
 * Every imported product lands as a **draft** — this tool moves inventory
 * data into WooCommerce's shape, it does not decide what goes live.
 * Matches existing products by SKU so re-running an import updates rather
 * than duplicates.
 *
 * With "Transfer files to this site" checked, each `download_url` is
 * fetched once and moved into WooCommerce's own protected uploads
 * directory rather than left pointing at Beacons' hosting — see
 * `transfer_download_file()`. This matters for Phase 3's "secure download
 * files" goal: WooCommerce token-gates delivery either way, but a locally
 * stored file doesn't depend on Beacons' hosting staying up, and isn't
 * exposed as a bare external URL if the site's File Download Method is
 * ever switched to "Redirect only".
 */
class Atlas_Relics_Core_Beacons_Importer {

	const CAPABILITY = 'manage_woocommerce';
	const NONCE_ACTION = 'atlas_relics_beacons_import';

	/**
	 * Expected CSV header columns, in order.
	 *
	 * @var array
	 */
	private $expected_columns = array( 'title', 'description', 'price', 'sku', 'download_url', 'image_url' );

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_post_atlas_relics_beacons_import', array( $this, 'handle_import' ) );
		add_action( 'admin_post_atlas_relics_beacons_sample_csv', array( $this, 'handle_sample_csv_download' ) );
	}

	/**
	 * Add the "Beacons Import" tool under Tools.
	 */
	public function register_page() {
		add_management_page(
			__( 'Beacons Import', 'atlas-relics-core' ),
			__( 'Beacons Import', 'atlas-relics-core' ),
			self::CAPABILITY,
			'atlas-relics-beacons-import',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Render the upload form and any results from a prior run.
	 */
	public function render_page() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			return;
		}

		$results = get_transient( 'atlas_relics_beacons_import_results_' . get_current_user_id() );
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Beacons Import', 'atlas-relics-core' ); ?></h1>
			<p><?php echo esc_html__( 'Import a Beacons.ai product export (CSV) as draft WooCommerce products for review. Existing products are matched and updated by SKU.', 'atlas-relics-core' ); ?></p>

			<?php if ( $results ) : ?>
				<div class="notice notice-success">
					<p>
						<?php
						printf(
							/* translators: 1: created count, 2: updated count, 3: skipped count */
							esc_html__( 'Import complete: %1$d created, %2$d updated, %3$d skipped.', 'atlas-relics-core' ),
							(int) $results['created'],
							(int) $results['updated'],
							(int) $results['skipped']
						);
						?>
					</p>
					<?php if ( ! empty( $results['errors'] ) ) : ?>
						<ul>
							<?php foreach ( $results['errors'] as $error ) : ?>
								<li><?php echo esc_html( $error ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<?php delete_transient( 'atlas_relics_beacons_import_results_' . get_current_user_id() ); ?>
			<?php endif; ?>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="atlas_relics_beacons_import" />
				<?php wp_nonce_field( self::NONCE_ACTION ); ?>
				<table class="form-table">
					<tr>
						<th scope="row"><label for="beacons_csv"><?php echo esc_html__( 'CSV file', 'atlas-relics-core' ); ?></label></th>
						<td><input type="file" name="beacons_csv" id="beacons_csv" accept=".csv,text/csv" required /></td>
					</tr>
					<tr>
						<th scope="row"><?php echo esc_html__( 'Download files', 'atlas-relics-core' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="transfer_files" value="yes" checked />
								<?php echo esc_html__( 'Transfer files to this site instead of linking to download_url directly', 'atlas-relics-core' ); ?>
							</label>
						</td>
					</tr>
				</table>
				<?php submit_button( __( 'Import products', 'atlas-relics-core' ) ); ?>
			</form>

			<p>
				<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=atlas_relics_beacons_sample_csv' ), self::NONCE_ACTION ) ); ?>">
					<?php echo esc_html__( 'Download a sample CSV template', 'atlas-relics-core' ); ?>
				</a>
			</p>

			<h2><?php echo esc_html__( 'Expected columns', 'atlas-relics-core' ); ?></h2>
			<p><code><?php echo esc_html( implode( ', ', $this->expected_columns ) ); ?></code></p>
		</div>
		<?php
	}

	/**
	 * Stream a sample CSV template for download.
	 */
	public function handle_sample_csv_download() {
		if ( ! current_user_can( self::CAPABILITY ) || ! check_admin_referer( self::NONCE_ACTION ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'atlas-relics-core' ) );
		}

		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="beacons-import-sample.csv"' );

		$handle = fopen( 'php://output', 'w' );
		fputcsv( $handle, $this->expected_columns );
		fputcsv(
			$handle,
			array(
				'The Wayfinder Guide',
				'A short reflection guide for the first steps of the journey.',
				'24.00',
				'wayfinder-guide',
				'https://example.com/downloads/wayfinder-guide.pdf',
				'https://example.com/images/wayfinder-guide.jpg',
			)
		);
		fclose( $handle );
		exit;
	}

	/**
	 * Handle the CSV upload and import.
	 */
	public function handle_import() {
		if ( ! current_user_can( self::CAPABILITY ) || ! check_admin_referer( self::NONCE_ACTION ) ) {
			wp_die( esc_html__( 'You are not allowed to do that.', 'atlas-relics-core' ) );
		}

		$redirect = admin_url( 'tools.php?page=atlas-relics-beacons-import' );

		if ( empty( $_FILES['beacons_csv']['tmp_name'] ) || ! is_uploaded_file( $_FILES['beacons_csv']['tmp_name'] ) ) {
			wp_safe_redirect( $redirect );
			exit;
		}

		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash -- tmp_name is a server-generated path, not user input.
		$tmp_path      = $_FILES['beacons_csv']['tmp_name'];
		$transfer_files = ! empty( $_POST['transfer_files'] );
		$results       = array(
			'created' => 0,
			'updated' => 0,
			'skipped' => 0,
			'errors'  => array(),
		);

		$handle = fopen( $tmp_path, 'r' );

		if ( ! $handle ) {
			$results['errors'][] = __( 'Could not read the uploaded file.', 'atlas-relics-core' );
			$this->store_results( $results, $redirect );
			return;
		}

		$header = fgetcsv( $handle );
		$header = is_array( $header ) ? array_map( 'strtolower', array_map( 'trim', $header ) ) : array();
		$row_number = 1;

		while ( ( $row = fgetcsv( $handle ) ) !== false ) {
			++$row_number;

			if ( count( $header ) !== count( $row ) ) {
				$results['skipped']++;
				/* translators: %d: CSV row number */
				$results['errors'][] = sprintf( __( 'Row %d: column count did not match the header.', 'atlas-relics-core' ), $row_number );
				continue;
			}

			$data = array_combine( $header, $row );
			$this->import_row( $data, $row_number, $results, $transfer_files );
		}

		fclose( $handle );

		$this->store_results( $results, $redirect );
	}

	/**
	 * Import (create or update) a single CSV row.
	 *
	 * @param array $data           Row keyed by header column.
	 * @param int   $row_number     CSV row number, for error messages.
	 * @param array $results        Results accumulator, passed by reference.
	 * @param bool  $transfer_files Whether to sideload download_url into local storage.
	 */
	private function import_row( $data, $row_number, array &$results, $transfer_files = false ) {
		$title = isset( $data['title'] ) ? sanitize_text_field( $data['title'] ) : '';
		$sku   = isset( $data['sku'] ) ? sanitize_text_field( $data['sku'] ) : '';

		if ( '' === $title ) {
			$results['skipped']++;
			/* translators: %d: CSV row number */
			$results['errors'][] = sprintf( __( 'Row %d: missing title, skipped.', 'atlas-relics-core' ), $row_number );
			return;
		}

		$existing_id = '' !== $sku ? wc_get_product_id_by_sku( $sku ) : 0;
		$product     = $existing_id ? wc_get_product( $existing_id ) : new WC_Product_Simple();
		$is_update   = (bool) $existing_id;

		$product->set_name( $title );
		$product->set_status( 'draft' );

		if ( isset( $data['description'] ) ) {
			$product->set_description( sanitize_textarea_field( $data['description'] ) );
		}

		if ( isset( $data['price'] ) && is_numeric( $data['price'] ) ) {
			$product->set_regular_price( wc_format_decimal( $data['price'] ) );
		}

		if ( '' !== $sku ) {
			$product->set_sku( $sku );
		}

		$download_url = isset( $data['download_url'] ) ? esc_url_raw( trim( $data['download_url'] ) ) : '';

		if ( '' !== $download_url ) {
			if ( $transfer_files ) {
				$download_url = $this->transfer_download_file( $download_url, $title, $row_number, $results );
			}

			$product->set_virtual( true );
			$product->set_downloadable( true );
			$product->set_downloads(
				array(
					wp_generate_uuid4() => array(
						'name' => $title,
						'file' => $download_url,
					),
				)
			);
		}

		$product_id = $product->save();

		if ( ! $product_id ) {
			$results['skipped']++;
			/* translators: 1: CSV row number, 2: product title */
			$results['errors'][] = sprintf( __( 'Row %1$d: could not save "%2$s".', 'atlas-relics-core' ), $row_number, $title );
			return;
		}

		$image_url = isset( $data['image_url'] ) ? esc_url_raw( trim( $data['image_url'] ) ) : '';

		if ( '' !== $image_url && ! has_post_thumbnail( $product_id ) ) {
			$this->attach_image( $product_id, $image_url );
		}

		if ( $is_update ) {
			$results['updated']++;
		} else {
			$results['created']++;
		}
	}

	/**
	 * Sideload a remote image and set it as the product's featured image.
	 *
	 * @param int    $product_id Product ID.
	 * @param string $image_url  Remote image URL.
	 */
	private function attach_image( $product_id, $image_url ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$attachment_id = media_sideload_image( $image_url, $product_id, null, 'id' );

		if ( ! is_wp_error( $attachment_id ) ) {
			set_post_thumbnail( $product_id, $attachment_id );
		}
	}

	/**
	 * Fetch a remote download file once and move it into WooCommerce's own
	 * protected uploads directory, returning the local URL to use instead.
	 * Falls back to the original remote URL (rather than failing the whole
	 * row) if the fetch or move doesn't succeed.
	 *
	 * @param string $download_url Remote file URL.
	 * @param string $title        Product title, used as a filename fallback.
	 * @param int    $row_number   CSV row number, for error messages.
	 * @param array  $results      Results accumulator, passed by reference.
	 * @return string
	 */
	private function transfer_download_file( $download_url, $title, $row_number, array &$results ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';

		$tmp_file = download_url( $download_url );

		if ( is_wp_error( $tmp_file ) ) {
			/* translators: 1: CSV row number, 2: error message */
			$results['errors'][] = sprintf( __( 'Row %1$d: could not fetch download_url, kept the original link (%2$s).', 'atlas-relics-core' ), $row_number, $tmp_file->get_error_message() );
			return $download_url;
		}

		$dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'woocommerce_uploads/';

		if ( ! file_exists( $dir ) ) {
			wp_mkdir_p( $dir );
		}

		$source_name = wp_basename( (string) wp_parse_url( $download_url, PHP_URL_PATH ) );
		$filename    = wp_unique_filename( $dir, sanitize_file_name( $source_name ?: $title ) );
		$destination = $dir . $filename;

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rename
		$moved = rename( $tmp_file, $destination );

		if ( ! $moved ) {
			wp_delete_file( $tmp_file );
			/* translators: %d: CSV row number */
			$results['errors'][] = sprintf( __( 'Row %d: could not move the downloaded file, kept the original link.', 'atlas-relics-core' ), $row_number );
			return $download_url;
		}

		return trailingslashit( wp_upload_dir()['baseurl'] ) . 'woocommerce_uploads/' . $filename;
	}

	/**
	 * Store results in a short-lived transient and redirect back to the
	 * import screen (POST/redirect/GET, so a page refresh can't re-submit
	 * the import).
	 *
	 * @param array  $results  Import results.
	 * @param string $redirect Redirect URL.
	 */
	private function store_results( array $results, $redirect ) {
		set_transient( 'atlas_relics_beacons_import_results_' . get_current_user_id(), $results, MINUTE_IN_SECONDS * 5 );
		wp_safe_redirect( $redirect );
		exit;
	}
}
