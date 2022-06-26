<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wcc_Cashback_Coupon
 * @subpackage Wcc_Cashback_Coupon/includes
 * @author     WPCodelibrary <wpcodelibrary@gmail.com>
 */
class Wcc_Cashback_Coupon {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wcc_Cashback_Coupon_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WCC_CASHBACK_COUPON_VERSION' ) ) {
			$this->version = WCC_CASHBACK_COUPON_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woo-cashback-coupon';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wcc_Cashback_Coupon_Loader. Orchestrates the hooks of the plugin.
	 * - Wcc_Cashback_Coupon_i18n. Defines internationalization functionality.
	 * - Wcc_Cashback_Coupon_Admin. Defines all hooks for the admin area.
	 * - Wcc_Cashback_Coupon_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-cashback-coupon-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-cashback-coupon-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-cashback-coupon-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-cashback-coupon-public.php';

		$this->loader = new Wcc_Cashback_Coupon_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wcc_Cashback_Coupon_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wcc_Cashback_Coupon_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wcc_Cashback_Coupon_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		
		$get_wcc_enable = get_option( 'wcc_enable' );
		if ( isset( $get_wcc_enable ) && ! empty( $get_wcc_enable ) && $get_wcc_enable === 'yes' ) {
			$this->loader->add_action( 'woocommerce_order_status_completed', $plugin_admin, 'wcc_wpc_payment_complete', 10,1 );
			$this->loader->add_filter( 'woocommerce_coupon_discount_types', $plugin_admin, 'wcc_add_discount_type', 10,1 );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		
		$plugin_public = new Wcc_Cashback_Coupon_Public( $this->get_plugin_name(), $this->get_version() );
		
		
		$get_wcc_enable = get_option( 'wcc_enable' );
		if ( isset( $get_wcc_enable ) && ! empty( $get_wcc_enable ) && $get_wcc_enable === 'yes' ) {
			$this->loader->add_action( 'woocommerce_new_order', $plugin_public, 'delete_coupon_after_use', 9 );
			$this->loader->add_filter( 'woocommerce_coupon_get_discount_amount', $plugin_public, 'wcc_coupon_get_discount_amount', 10, 5 );
			$this->loader->add_filter( 'woocommerce_coupon_is_valid_for_cart', $plugin_public, 'wcc_coupon_is_valid', 10, 2 );
		}
	}
	

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wcc_Cashback_Coupon_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
