<?php
/**
 * This file contains the definition of the Ctoct_Cart_To_Checkout_Timer class, which
 * is used to begin the plugin's functionality.
 *
 * @package       Ctoct_Cart_To_Checkout_Timer
 * @subpackage    Ctoct_Cart_To_Checkout_Timer/includes
 * @version       1.0.0
 */

/**
 * The core plugin class.
 *
 * This is used to define admin-specific hooks and public-facing hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since    1.0.0
 */
class Ctoct_Cart_To_Checkout_Timer {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       Ctoct_Cart_To_Checkout_Timer_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    void
	 */
	public function __construct() {
		$this->version     = defined( 'CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_VERSION' ) ? CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_VERSION : '1.0.0';
		$this->plugin_name = 'cart-to-checkout-timer';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ctoct_Cart_To_Checkout_Timer_Loader. Orchestrates the hooks of the plugin.
	 * - Ctoct_Cart_To_Checkout_Timer_Admin.  Defines all hooks for the admin area.
	 * - Ctoct_Cart_To_Checkout_Timer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @return    void
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH . 'includes/class-ctoct-cart-to-checkout-timer-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH . 'admin/class-ctoct-cart-to-checkout-timer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_PATH . 'public/class-ctoct-cart-to-checkout-timer-public.php';

		$this->loader = new Ctoct_Cart_To_Checkout_Timer_Loader();
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @return    void
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Ctoct_Cart_To_Checkout_Timer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugin_action_links_' . CTOCT_CART_TO_CHECKOUT_TIMER_PLUGIN_BASENAME, $plugin_admin, 'plugin_action_links' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'admin_notices' );

		$this->loader->add_action( 'before_woocommerce_init', $plugin_admin, 'declare_compatibility_with_wc_custom_order_tables' );

		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_admin, 'capture_added_to_cart_time', 10, 2 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_admin, 'add_added_time_to_order', 10, 4 );
		$this->loader->add_filter( 'woocommerce_get_item_data', $plugin_admin, 'show_added_time', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @return    void
	 */
	private function define_public_hooks() {
		$plugin_public = new Ctoct_Cart_To_Checkout_Timer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    void
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of WordPress.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    Ctoct_Cart_To_Checkout_Timer_Loader Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @return    string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
