<?php
/**
 * Plugin Name: Mipro Core
 * Plugin URI: http://themeforest.net/user/alurastudio
 * Description: Add shortcodes and custom post types for Mipro theme
 * Version: 1.4.0
 * Author: the AluraStudio team
 * Text Domain: mipro-core
 * Author URI: http://themeforest.net/user/alurastudio
 */
class MiproCore {

	public function __construct() {

		$this->include_files();
		add_action( 'widgets_init', array( $this, 'regit_widget' ) );
	}

	public function include_files() {
        $include = plugin_dir_path( __FILE__ ) . '/includes/third-party/redux-framework/ReduxCore/framework.php';
        
		if ( ! class_exists( 'ReduxFramework' ) && file_exists( $include ) ) {
			require_once $include;
		}

		require_once 'functions.php';

		// Includes files
		$include_files = array( 'post-type', 'shortcodes' );
		foreach ( $include_files as $include_file ) {
			$include = plugin_dir_path( __FILE__ ) . '/includes/' . $include_file . '.php';
			if ( file_exists( $include ) ) {
				require_once $include;
			}
		}

		// Widget files
		$widget_files = array( 'instagram', 'brands_slider', 'footer' );
		foreach ( $widget_files as $widget_file ) {
			$widget = plugin_dir_path( __FILE__ ) . '/widgets/' . $widget_file . '.php';
			if ( file_exists( $widget ) ) {
				require_once $widget;
			}
		}

		// Third-party files
		$third_party_files = array( 'loader', 'cmb2-tabs/cmb2-tabs' );
		foreach ( $third_party_files as $third_party_file ) {
			$third_party = plugin_dir_path( __FILE__ ) . '/includes/third-party/' . $third_party_file . '.php';
			if ( file_exists( $third_party ) ) {
				require_once $third_party;
			}
		}
	}

	function regit_widget() {
		$array_widget = array(
			'Mipro_About_Me_Widget',
			'Mipro_Blogs_Widget',
			'Mipro_Mailchimp_Subscription_Widget',
			'Mipro_WP_Nav_Menu_Widget',
			'Mipro_Product_Categories_Widget',
			'Mipro_Products_Widget',
			'Mipro_Recent_Comments_Widget',
			'Mipro_Product_Filter_By_Color_Widget',
		);
		foreach ( $array_widget as $value ) {
			if ( class_exists( $value ) ) {
				register_widget( $value );
			}
		}

	}

}
new MiproCore();
