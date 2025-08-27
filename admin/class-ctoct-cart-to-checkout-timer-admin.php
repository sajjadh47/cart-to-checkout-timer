<?php
/**
 * This file contains the definition of the Ctoct_Cart_To_Checkout_Timer_Admin class, which
 * is used to load the plugin's admin-specific functionality.
 *
 * @package       Ctoct_Cart_To_Checkout_Timer
 * @subpackage    Ctoct_Cart_To_Checkout_Timer/admin
 * @version       1.0.0
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    1.0.0
 */
class Ctoct_Cart_To_Checkout_Timer_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @var       string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @var       string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     string $plugin_name The name of this plugin.
	 * @param     string $version     The version of this plugin.
	 * @return    void
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Adds a settings link to the plugin's action links on the plugin list table.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     array $links The existing array of plugin action links.
	 * @return    array $links The updated array of plugin action links, including the settings link.
	 */
	public function plugin_action_links( $links ) {
		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'admin.php?page=wc-orders' ) ), __( 'Orders', 'cart-to-checkout-timer' ) );

		return $links;
	}

	/**
	 * Displays admin notices in the admin area.
	 *
	 * This function checks if the required plugin is active.
	 * If not, it displays a warning notice and deactivates the current plugin.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    void
	 */
	public function admin_notices() {
		// Check if required plugin is active.
		if ( ! class_exists( 'WooCommerce', false ) ) {
			sprintf(
				'<div class="notice notice-warning is-dismissible"><p>%s <a href="%s">%s</a> %s</p></div>',
				__( 'Cart To Checkout Timer requires', 'cart-to-checkout-timer' ),
				esc_url( 'https://wordpress.org/plugins/woocommerce/' ),
				__( 'WooCommerce', 'cart-to-checkout-timer' ),
				__( 'plugin to be active!', 'cart-to-checkout-timer' ),
			);

			// Deactivate the plugin.
			deactivate_plugins( CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_BASENAME );
		}
	}

	/**
	 * Declares compatibility with WooCommerce's custom order tables feature.
	 *
	 * This function is hooked into the `before_woocommerce_init` action and checks
	 * if the `FeaturesUtil` class exists in the `Automattic\WooCommerce\Utilities`
	 * namespace. If it does, it declares compatibility with the 'custom_order_tables'
	 * feature. This is important for ensuring the plugin works correctly with
	 * WooCommerce versions that support this feature.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    void
	 */
	public function declare_compatibility_with_wc_custom_order_tables() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
				'custom_order_tables',
				CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_FULLPATH,
				true // true (compatible, default) or false (not compatible).
			);
		}
	}

	/**
	 * Function to add added time to the order.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     array $cart_item_data Cart item data.
	 * @param     int   $product_id     Cart product id.
	 * @return    array
	 */
	public function capture_added_to_cart_time( $cart_item_data, $product_id ) {
		if ( $product_id ) {
			$local_time   = current_datetime();
			$current_time = $local_time->getTimestamp() + $local_time->getOffset();

			$cart_item_data['added_time'] = $current_time;
		}

		return $cart_item_data;
	}

	/**
	 * Function to add added time to the order.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     object $item          Cart item data.
	 * @param     string $cart_item_key Cart item key.
	 * @param     array  $values        Cart values.
	 * @param     object $order         WC_Order object.
	 * @return    void
	 */
	public function add_added_time_to_order( $item, $cart_item_key, $values, $order ) {
		if ( ! empty( $values['added_time'] ) && $order ) {
			$local_time   = current_datetime();
			$current_time = $local_time->getTimestamp() + $local_time->getOffset();
			$duration     = $current_time - $values['added_time'];

			$item->add_meta_data( 'Added To Cart Time', gmdate( 'F j, Y g:i:s A', $values['added_time'] ) );
			$item->add_meta_data( 'Checkout Time', gmdate( 'F j, Y g:i:s A', $current_time ) );
			$item->add_meta_data( 'Checkout Duration', self::format_duration( $duration ) );
		}
	}

	/**
	 * Function to show added time beside cart item.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     array $item_data Cart data.
	 * @param     array $cart_item Cart item.
	 * @return    array
	 */
	public function show_added_time( $item_data, $cart_item ) {
		if ( ! empty( $cart_item['added_time'] ) ) {
			$local_time   = current_datetime();
			$current_time = $local_time->getTimestamp() + $local_time->getOffset();

			$item_data[] = array(
				'key'   => __( 'Added To Cart', 'cart-to-checkout-timer' ),
				'value' => sprintf( '%s %s', self::format_duration( $current_time - $cart_item['added_time'] ), __( 'ago', 'cart-to-checkout-timer' ) ),
			);
		}

		return $item_data;
	}

	/**
	 * Function to format seconds in readable format.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @param     int $seconds Total seconds.
	 * @return    string
	 */
	public static function format_duration( $seconds ) {
		$days              = floor( $seconds / 86400 );
		$remaining_seconds = $seconds % 86400;
		$hours             = floor( $remaining_seconds / 3600 );
		$remaining_seconds = $remaining_seconds % 3600;
		$minutes           = floor( $remaining_seconds / 60 );
		$remaining_seconds = $remaining_seconds % 60;
		$parts             = array();

		if ( $days > 0 ) {
			$parts[] = $days . ' day' . ( $days > 1 ? 's' : '' );
		}

		if ( $hours > 0 ) {
			$parts[] = $hours . ' hour' . ( $hours > 1 ? 's' : '' );
		}

		if ( $minutes > 0 ) {
			$parts[] = $minutes . ' minute' . ( $minutes > 1 ? 's' : '' );
		}

		if ( $remaining_seconds > 0 || empty( $parts ) ) {
			$parts[] = $remaining_seconds . ' second' . ( $remaining_seconds > 1 ? 's' : '' );
		}

		return implode( ' ', $parts );
	}
}
