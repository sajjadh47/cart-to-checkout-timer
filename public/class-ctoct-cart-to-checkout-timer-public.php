<?php
/**
 * This file contains the definition of the Ctoct_Cart_To_Checkout_Timer_Public class, which
 * is used to load the plugin's public-facing functionality.
 *
 * @package       Ctoct_Cart_To_Checkout_Timer
 * @subpackage    Ctoct_Cart_To_Checkout_Timer/public
 * @version       1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    1.0.0
 */
class Ctoct_Cart_To_Checkout_Timer_Public {
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
	 * @param     string $plugin_name The name of the plugin.
	 * @param     string $version     The version of this plugin.
	 * @return    void
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_URL . 'public/js/public.js', array( 'jquery' ), $this->version, true );
	}
}
