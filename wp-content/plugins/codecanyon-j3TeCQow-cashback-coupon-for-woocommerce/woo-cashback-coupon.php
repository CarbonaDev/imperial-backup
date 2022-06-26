<?php

/**

 * Plugin Name:       Cashback Coupon For WooCommerce
 * Plugin URI:        https://wpcodelibrary.com/
 * Description:       Create cashback coupons for customers after order placed.
 * Version:           1.1.0
 * Author:            WPCodelibrary
 * Author URI:        https://wpcodelibrary.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-cashback-coupon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!defined('WCC_PLUGIN_URL')) {
	define('WCC_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if (!defined('WCC_PLUGIN_DIR')) {
	define('WCC_PLUGIN_DIR', dirname(__FILE__));
}
if (!defined('WCC_PLUGIN_DIR_PATH')) {
	define('WCC_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('WCC_SLUG')) {
	define('WCC_SLUG', 'woo-cashback-coupon');
}
if (!defined('WCC_VERSION')) {
	define('WCC_VERSION', '1.0.0');
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WCC_CASHBACK_COUPON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-cashback-coupon-activator.php
 */
function wcc_activate_cashback_coupon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-cashback-coupon-activator.php';
	Wcc_Cashback_Coupon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-cashback-coupon-deactivator.php
 */
function wcc_deactivate_cashback_coupon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-cashback-coupon-deactivator.php';
	Wcc_Cashback_Coupon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'wcc_activate_cashback_coupon' );
register_deactivation_hook( __FILE__, 'wcc_deactivate_cashback_coupon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-cashback-coupon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wcc_run_cashback_coupon() {

	$plugin = new Wcc_Cashback_Coupon();
	$plugin->run();

}
wcc_run_cashback_coupon();
