<?php
/**
 * Product bundles and restrained upsell/related product display.
 *
 * @package Atlas_Relics_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A lightweight, dependency-free alternative to the paid "WooCommerce
 * Product Bundles" extension. A bundle is an ordinary simple WooCommerce
 * product (its own price — usually a bundle discount — its own listing,
 * its own "Add to cart") flagged as a bundle with a list of component
 * products. Adding it to the cart also adds each component at $0, so:
 *
 * - Component stock is still decremented correctly per order.
 * - Fulfillment/packing lists still show every physical/digital item.
 * - The customer is charged exactly the bundle product's price, once.
 *
 * Known limitation (documented rather than hidden): if a shopper uses the
 * cart's "undo" link after removing the bundle, only the bundle parent is
 * restored — the component rows are not automatically restored with it.
 * Acceptable for Phase 2's test-catalog scope; revisit if bundles become a
 * high-volume path in Phase 3.
 */
class Atlas_Relics_Core_Bundles {

	const META_IS_BUNDLE     = '_atlas_relics_is_bundle';
	const META_BUNDLE_ITEMS  = '_atlas_relics_bundle_items';
	const CART_ITEM_PARENT   = 'atlas_relics_bundle_parent_key';
	const CART_ITEM_IS_CHILD = 'atlas_relics_bundle_child';

	/**
	 * Register hooks.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes_product', array( $this, 'register_meta_box' ) );
		add_action( 'save_post_product', array( $this, 'save_meta_box' ) );

		add_action( 'woocommerce_single_product_summary', array( $this, 'display_bundle_contents' ), 25 );
		add_action( 'woocommerce_add_to_cart', array( $this, 'add_bundle_children_to_cart' ), 10, 6 );

		add_filter( 'woocommerce_before_calculate_totals', array( $this, 'zero_out_child_prices' ) );
		add_filter( 'woocommerce_cart_item_name', array( $this, 'label_bundle_child_name' ), 10, 2 );
		add_action( 'woocommerce_cart_item_removed', array( $this, 'remove_bundle_children' ), 10, 2 );

		add_filter( 'woocommerce_output_related_products_args', array( $this, 'restrain_related_products' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'restrain_upsells' ) );
	}

	/**
	 * Add the "Atlas Relics Bundle" meta box to the product editor.
	 */
	public function register_meta_box() {
		add_meta_box(
			'atlas-relics-bundle',
			__( 'Atlas Relics Bundle', 'atlas-relics-core' ),
			array( $this, 'render_meta_box' ),
			'product',
			'side',
			'default'
		);
	}

	/**
	 * Render the meta box fields.
	 *
	 * @param WP_Post $post Current product post.
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field( 'atlas_relics_save_bundle', 'atlas_relics_bundle_nonce' );

		$is_bundle = 'yes' === get_post_meta( $post->ID, self::META_IS_BUNDLE, true );
		$items     = get_post_meta( $post->ID, self::META_BUNDLE_ITEMS, true );
		$items     = is_array( $items ) ? $items : array();

		$lines = array();
		foreach ( $items as $product_id => $qty ) {
			$lines[] = $product_id . ':' . $qty;
		}
		?>
		<p>
			<label>
				<input type="checkbox" name="atlas_relics_is_bundle" value="yes" <?php checked( $is_bundle ); ?> />
				<?php echo esc_html__( 'This product is a bundle', 'atlas-relics-core' ); ?>
			</label>
		</p>
		<p>
			<label for="atlas-relics-bundle-items"><?php echo esc_html__( 'Included products (one per line, "product_id:quantity")', 'atlas-relics-core' ); ?></label>
			<textarea id="atlas-relics-bundle-items" name="atlas_relics_bundle_items" rows="5" class="widefat" placeholder="123:1&#10;456:2"><?php echo esc_textarea( implode( "\n", $lines ) ); ?></textarea>
		</p>
		<p class="description">
			<?php echo esc_html__( 'Set this product\'s regular price to the bundle price. Component products are added to the cart at $0 so stock and fulfillment still track each item.', 'atlas-relics-core' ); ?>
		</p>
		<?php
	}

	/**
	 * Persist the meta box fields.
	 *
	 * @param int $post_id Product ID being saved.
	 */
	public function save_meta_box( $post_id ) {
		if ( ! isset( $_POST['atlas_relics_bundle_nonce'] ) ||
			! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['atlas_relics_bundle_nonce'] ) ), 'atlas_relics_save_bundle' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_product', $post_id ) ) {
			return;
		}

		$is_bundle = isset( $_POST['atlas_relics_is_bundle'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, self::META_IS_BUNDLE, $is_bundle );

		$raw_lines = isset( $_POST['atlas_relics_bundle_items'] )
			? explode( "\n", sanitize_textarea_field( wp_unslash( $_POST['atlas_relics_bundle_items'] ) ) )
			: array();

		$items = array();
		foreach ( $raw_lines as $line ) {
			$line = trim( $line );
			if ( '' === $line || strpos( $line, ':' ) === false ) {
				continue;
			}

			list( $product_id, $qty ) = array_map( 'trim', explode( ':', $line, 2 ) );
			$product_id               = absint( $product_id );
			$qty                      = max( 1, absint( $qty ) );

			if ( $product_id > 0 && $product_id !== (int) $post_id && get_post_type( $product_id ) === 'product' ) {
				$items[ $product_id ] = $qty;
			}
		}

		update_post_meta( $post_id, self::META_BUNDLE_ITEMS, $items );
	}

	/**
	 * Get bundle component items for a product.
	 *
	 * @param int $product_id Product ID.
	 * @return array<int,int> product_id => quantity
	 */
	private function get_bundle_items( $product_id ) {
		if ( 'yes' !== get_post_meta( $product_id, self::META_IS_BUNDLE, true ) ) {
			return array();
		}

		$items = get_post_meta( $product_id, self::META_BUNDLE_ITEMS, true );
		return is_array( $items ) ? $items : array();
	}

	/**
	 * Show the list of what's included on a bundle's product page.
	 */
	public function display_bundle_contents() {
		global $product;

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$items = $this->get_bundle_items( $product->get_id() );

		if ( empty( $items ) ) {
			return;
		}

		echo '<div class="atlas-relics-bundle-contents"><h3>' . esc_html__( 'What\'s included', 'atlas-relics-core' ) . '</h3><ul>';

		foreach ( $items as $product_id => $qty ) {
			$child = wc_get_product( $product_id );

			if ( ! $child ) {
				continue;
			}

			printf(
				'<li>%1$s%2$s</li>',
				esc_html( $child->get_name() ),
				$qty > 1 ? ' × ' . esc_html( $qty ) : ''
			);
		}

		echo '</ul></div>';
	}

	/**
	 * When a bundle is added to the cart, silently add its components too.
	 *
	 * @param string $cart_item_key Cart item key of the item just added.
	 * @param int    $product_id    Product added.
	 * @param int    $quantity      Quantity added.
	 */
	public function add_bundle_children_to_cart( $cart_item_key, $product_id, $quantity ) {
		$items = $this->get_bundle_items( $product_id );

		if ( empty( $items ) ) {
			return;
		}

		foreach ( $items as $child_id => $child_qty ) {
			WC()->cart->add_to_cart(
				$child_id,
				$child_qty * $quantity,
				0,
				array(),
				array(
					self::CART_ITEM_IS_CHILD => true,
					self::CART_ITEM_PARENT   => $cart_item_key,
				)
			);
		}
	}

	/**
	 * Zero the price of bundle component cart items.
	 *
	 * @param WC_Cart $cart Current cart.
	 */
	public function zero_out_child_prices( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		foreach ( $cart->get_cart() as $cart_item ) {
			if ( ! empty( $cart_item[ self::CART_ITEM_IS_CHILD ] ) ) {
				$cart_item['data']->set_price( 0 );
			}
		}
	}

	/**
	 * Label bundle component rows in the cart/checkout item list.
	 *
	 * @param string $name      Rendered cart item name.
	 * @param array  $cart_item Cart item data.
	 * @return string
	 */
	public function label_bundle_child_name( $name, $cart_item ) {
		if ( ! empty( $cart_item[ self::CART_ITEM_IS_CHILD ] ) ) {
			$name .= ' <span class="atlas-relics-bundle-included-label">' . esc_html__( '(included in bundle)', 'atlas-relics-core' ) . '</span>';
		}

		return $name;
	}

	/**
	 * Remove a bundle's component items when its parent row is removed.
	 *
	 * @param string  $cart_item_key Removed cart item key.
	 * @param WC_Cart $cart          Current cart.
	 */
	public function remove_bundle_children( $cart_item_key, $cart ) {
		foreach ( $cart->get_cart() as $key => $cart_item ) {
			if ( ! empty( $cart_item[ self::CART_ITEM_PARENT ] ) && $cart_item[ self::CART_ITEM_PARENT ] === $cart_item_key ) {
				$cart->remove_cart_item( $key );
			}
		}
	}

	/**
	 * Cap related products at 3, in a single row.
	 *
	 * @param array $args Related products query args.
	 * @return array
	 */
	public function restrain_related_products( $args ) {
		$args['posts_per_page'] = 3;
		$args['columns']        = 3;
		return $args;
	}

	/**
	 * Cap upsells at 2 — a suggestion, not a wall of products.
	 *
	 * @param array $args Upsell display args.
	 * @return array
	 */
	public function restrain_upsells( $args ) {
		$args['posts_per_page'] = 2;
		$args['columns']        = 2;
		return $args;
	}
}
