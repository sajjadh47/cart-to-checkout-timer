<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package              Ctoct_Cart_To_Checkout_Timer
 * @version              1.0.0
 *
 * Plugin Name:          Cart To Checkout Timer
 * Plugin URI:           https://wordpress.org/plugins/cart-to-checkout-timer/
 * Description:          Cart To Checkout Timer measures the exact duration from when a customer adds a product to their cart to when they complete their purchase.
 * Version:              1.0.1
 * Requires at least:    6.1
 * Requires PHP:         7.4
 * Author:               Sajjad Hossain Sagor
 * Author URI:           https://sajjadhsagor.com/
 * License:              GPL-2.0+
 * License URI:          https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:          cart-to-checkout-timer
 * Domain Path:          /languages
 * Requires Plugins:     woocommerce
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Plugin Version
 *
 * Defines the current version of the plugin.
 *
 * @since    1.0.0
 */
define( 'CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_VERSION', '1.0.1' );

/**
 * The absolute path to the main plugin file.
 *
 * Defines the full path to the main plugin file.
 * This constant stores the absolute filesystem path to the plugin's primary file.
 *
 * @since    1.0.0
 */
define( 'CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_FULLPATH', __FILE__ );

/**
 * Plugin Path
 *
 * Defines the absolute server path to the plugin's main directory.  This is
 * determined using the WordPress `plugin_dir_path()` function.
 *
 * @since    1.0.0
 */
define( 'CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin URL
 *
 * Defines the URL to the plugin's main directory. This is determined using
 * the WordPress `plugin_dir_url()` function.
 *
 * @since    1.0.0
 */
define( 'CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin Base Name
 *
 * Defines the base name of the plugin's main file (e.g., `my-plugin/my-plugin.php`).
 * This is determined using the WordPress `plugin_basename()` function.
 *
 * @since    1.0.0
 */
define( 'CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-unified-inventory-manager-activator.php
 *
 * @since    1.0.0
 */
function ctoct_on_activate_cart_to_checkout_timer() {
	require_once CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH . 'includes/class-ctoct-cart-to-checkout-timer-activator.php';

	Ctoct_Cart_To_Checkout_Timer_Activator::on_activate();
}

register_activation_hook( __FILE__, 'ctoct_on_activate_cart_to_checkout_timer' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-unified-inventory-manager-deactivator.php
 *
 * @since    1.0.0
 */
function ctoct_on_deactivate_cart_to_checkout_timer() {
	require_once CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH . 'includes/class-ctoct-cart-to-checkout-timer-deactivator.php';

	Ctoct_Cart_To_Checkout_Timer_Deactivator::on_deactivate();
}

register_deactivation_hook( __FILE__, 'ctoct_on_deactivate_cart_to_checkout_timer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 *
 * @since    1.0.0
 */
require CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH . 'includes/class-ctoct-cart-to-checkout-timer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ctoct_run_cart_to_checkout_timer() {
	// Instantiate the plugin main class.
	$plugin = new Ctoct_Cart_To_Checkout_Timer();

	$plugin->run();
}

ctoct_run_cart_to_checkout_timer();
