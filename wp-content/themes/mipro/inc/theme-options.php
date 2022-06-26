<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 **/

if ( ! class_exists( 'Mipro_Redux_Framework_Option' ) ) {
	class Mipro_Redux_Framework_Option {

		public $args     = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		function __construct() {

			if ( ! class_exists( 'ReduxFramework' ) ) {
				return;
			}

			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings();
			} else {
				add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
			}
		}

		function initSettings() {

			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( ! isset( $this->args['opt_name'] ) ) {
				// No errors please
				return;
			}

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		function compiler_action( $options, $css, $changed_values ) {

		}

		function dynamic_section( $sections ) {

			return $sections;
		}

		function change_arguments( $args ) {

			return $args;
		}

		function change_defaults( $defaults ) {

			return $defaults;
		}

		function remove_demo() {

		}

		function setSections() {

			$kft_layouts = array(
				'full-width'         => ReduxFramework::$_url . 'assets/img/1col.png',
				'right-sidebar'      => ReduxFramework::$_url . 'assets/img/2cr.png',
				'left-sidebar'       => ReduxFramework::$_url . 'assets/img/2cl.png',
				'left-right-sidebar' => ReduxFramework::$_url . 'assets/img/3cm.png',
			);

			/* * *   General Options   * **/
			$this->sections[] = array(
				'icon'   => 'el el-home',
				'title'  => esc_html__( 'General', 'mipro' ),
				'fields' => array(
					array(
						'id'      => 'kft_layout',
						'type'    => 'button_set',
						'title'   => esc_html__( 'Layout', 'mipro' ),
						'default' => 'full-width',
						'options' => array(
							'full-width' => esc_html__( 'Full width', 'mipro' ),
							'boxed'      => esc_html__( 'Boxed', 'mipro' ),
							'wide'       => esc_html__( 'Wide (1600 px)', 'mipro' ),
						),
					),
					array(
						'id'      => 'kft_back_to_top_button',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Back To Top Button', 'mipro' ),
						'default' => false,
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
					),
					array(
						'id'      => 'kft_back_to_top_button_on_mobile',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Back To Top Button On Mobile', 'mipro' ),
						'default' => false,
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
					),
					array(
						'id'    => 'kft_gmap_api_key',
						'type'  => 'text',
						'title' => esc_html__( 'Google API key', 'mipro' ),
						'desc'  => wp_kses(
							__( 'Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map shortcode.', 'mipro' ),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
								),
							)
						),
					),
					array(
						'id'      => 'kft_status_opengraph',
						'type'    => 'switch',
						'title'   => esc_html__( 'Open Graph Meta Tags', 'mipro' ),
						'default' => false,
						'desc'    => esc_html__( 'Turn on to enable open graph meta tags which is mainly used when sharing pages on social networking sites like Facebook.', 'mipro' ),
					),
				),
			);

			/** Logo - Favicon */
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Logo - Favicon', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_logo',
						'type'    => 'media',
						'title'   => esc_html__( 'Logo Image', 'mipro' ),
						'desc'    => esc_html__( 'Select an image file for the main logo', 'mipro' ),
						'default' => array(
							'url' => get_parent_theme_file_uri( '/assets/images/logo.svg' ),
						),
					),
					array(
						'id'    => 'kft_logo_sticky',
						'type'  => 'media',
						'title' => esc_html__( 'Logo Image for sticky header', 'mipro' ),
						'desc'  => '',
					),
					array(
						'id'      => 'kft_logo_img_width',
						'type'    => 'slider',
						'title'   => esc_html__( 'Logo Image max width(px)', 'mipro' ),
						'desc'    => esc_html__( 'Enter max-width for logo images', 'mipro' ),
						'default' => 250,
						'min'     => 50,
						'step'    => 1,
						'max'     => 600,
					),
					array(
						'id'    => 'kft_favicon',
						'type'  => 'media',
						'title' => esc_html__( 'Favicon Image', 'mipro' ),
						'desc'  => esc_html__( 'Upload ICO, PNG files', 'mipro' ),
					),
					array(
						'id'    => 'kft_favicon_retina',
						'type'  => 'media',
						'title' => esc_html__( 'Favicon retina image', 'mipro' ),
						'desc'  => esc_html__( 'Upload ICO, PNG files', 'mipro' ),
					),
				),
			);

			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Breadcrumb', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_page_title',
						'type'    => 'switch',
						'title'   => esc_html__( 'Show page title', 'mipro' ),
						'default' => true,
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
					),
					array(
						'id'      => 'kft_page_title_fontsize',
						'type'    => 'text',
						'title'   => esc_html__( 'Page Title Font Size', 'mipro' ),
						'default' => '30px',
					),
					array(
						'id'      => 'kft_breadcrumbs',
						'type'    => 'switch',
						'title'   => esc_html__( 'Show breadcrumbs', 'mipro' ),
						'default' => true,
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
					),
					array(
						'id'      => 'kft_breadcrumb_layout',
						'type'    => 'select',
						'title'   => esc_html__( 'Breadcrumb Layout', 'mipro' ),
						'default' => 'layout1',
						'options' => array(
							'layout1' => esc_html__( 'Layout 1', 'mipro' ),
							'layout2' => esc_html__( 'Layout 2', 'mipro' ),
						),
					),
					array(
						'id'      => 'kft_breadcrumbs_height',
						'type'    => 'text',
						'title'   => esc_html__( 'Breadcrumbs Height', 'mipro' ),
						'default' => '100px',
					),
					array(
						'id'      => 'kft_breadcrumbs_mobile_height',
						'type'    => 'text',
						'title'   => esc_html__( 'Breadcrumbs Mobile Height', 'mipro' ),
						'default' => '80px',
					),
					array(
						'id'     => 'kft_bg_breadcrumbs',
						'type'   => 'background',
						'title'  => esc_html__( 'Breadcrumbs Background Image', 'mipro' ),
						'output' => array( '.kft-breadcrumb' ),
						'desc'   => esc_html__( 'Select a background image for Breadcrumb', 'mipro' ),
						'tags'   => 'breadcrumb color background breadcrumb color background bgbreadcrumb',
					),
				),
			);

			/** Popup Options */
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Popup', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_enable_popup',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Popup', 'mipro' ),
						'default' => 0,
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
					),
					array(
						'id'      => 'kft_popup_editor',
						'type'    => 'editor',
						'title'   => esc_html__( 'Popup Text', 'mipro' ),
						'default' => '',
					),
					array(
						'id'      => 'kft_popup_event',
						'type'    => 'select',
						'title'   => esc_html__( 'Popup Event', 'mipro' ),
						'default' => 'time',
						'options' => array(
							'time'   => esc_html__( 'Time', 'mipro' ),
							'scroll' => esc_html__( 'Scroll', 'mipro' ),
						),
					),
					array(
						'id'       => 'kft_popup_timeout',
						'type'     => 'text',
						'title'    => esc_html__( 'Popup Delay', 'mipro' ),
						'default'  => '1000',
						'required' => array(
							array( 'kft_popup_event', 'equals', 'time' ),
						),
					),
					array(
						'id'            => 'kft_popup_scroll',
						'type'          => 'slider',
						'title'         => esc_html__( 'Show after user scroll down the page', 'mipro' ),
						'subtitle'      => esc_html__( 'Set the number of pixels users have to scroll down before popup opens', 'mipro' ),
						'default'       => 1000,
						'min'           => 100,
						'step'          => 50,
						'max'           => 5000,
						'display_value' => 'label',
						'required'      => array(
							array( 'kft_popup_event', 'equals', 'scroll' ),
						),
					),
					array(
						'id'       => 'kft_popup-background',
						'type'     => 'background',
						'title'    => esc_html__( 'Popup background', 'mipro' ),
						'subtitle' => esc_html__( 'Set background image or color for promo popup', 'mipro' ),
						'output'   => array( '.kft-popup' ),
						'default'  => array(
							'background-color'    => '#111111',
							'background-repeat'   => 'no-repeat',
							'background-size'     => 'contain',
							'background-position' => 'left center',
						),
					),
					array(
						'id'      => 'kft_popup_hide_mobile',
						'type'    => 'switch',
						'title'   => esc_html__( 'Hide for mobile devices', 'mipro' ),
						'default' => 1,
					),
				),
			);

			/** Custom 404 Page */
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Custom 404 Page', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_enable_custom_404_page',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Custom 404 Page', 'mipro' ),
						'default' => 0,
					),
					array(
						'id'       => 'kft_custom_404_page',
						'type'     => 'select',
						'title'    => esc_html__( 'Custom 404 Page', 'mipro' ),
						'data'     => 'pages',
						'required' => array(
							array( 'kft_enable_custom_404_page', 'equals', 1 ),
						),
					),
				),
			);

			/** Header Options */
			$this->sections[] = array(
				'icon'   => 'el el-arrow-up',
				'title'  => esc_html__( 'Header', 'mipro' ),
				'fields' => array(
					array(
						'id'         => 'kft_header_layout',
						'type'       => 'image_select',
						'full_width' => true,
						'title'      => esc_html__( 'Header Layout', 'mipro' ),
						'subtitle'   => esc_html__( 'This header style will be showed only in inner pages, please go to Pages > Homepage to change header for front page.', 'mipro' ),
						'options'    => array(
							'layout1'  => array(
								'title' => 'Layout 1',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout4.png' ),
							),
							'layout2'  => array(
								'title' => 'Layout 2',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout4.png' ),
							),
							'layout3'  => array(
								'title' => 'Layout 3',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout2.png' ),
							),
							'layout5'  => array(
								'title' => 'Layout 4',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout3.png' ),
							),
							'layout4'  => array(
								'title' => 'Layout 5',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout1.png' ),
							),
							'layout6'  => array(
								'title' => 'Layout 6',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout1.png' ),
							),
							'layout7'  => array(
								'title' => 'Layout 7',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout7.png' ),
							),
							'layout8'  => array(
								'title' => 'Layout 8',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout8.png' ),
							),
							'layout9'  => array(
								'title' => 'Layout 9',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout9.png' ),
							),
							'layout10' => array(
								'title' => 'Layout 10',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/layout10.png' ),
							),
						),
						'default'    => 'layout1',
					),
					array(
						'id'       => 'kft_header_mobile_layout',
						'type'     => 'image_select',
						'title'    => esc_html__( 'Header on mobile devices', 'mipro' ),
						'subtitle' => esc_html__( 'Set your header design for mobile devices', 'mipro' ),
						'options'  => array(
							'center' => array(
								'title' => 'Logo center',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/header-mobile-center.png' ),
							),
							'left'   => array(
								'title' => 'Mobile menu left',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/header-mobile-left.png' ),
							),
							'right'  => array(
								'title' => 'Mobile menu right',
								'img'   => get_parent_theme_file_uri( '/assets/images/header/header-mobile-right.png' ),
							),
						),
						'default'  => 'center',
						'tags'     => 'mobile header',
					),
					array(
						'id'      => 'kft_enable_sticky_header',
						'type'    => 'switch',
						'title'   => esc_html__( 'Sticky header', 'mipro' ),
						'default' => 1,
					),
					array(
						'id'      => 'kft_enable_search_sticky',
						'type'    => 'switch',
						'title'   => esc_html__( 'Search on sticky header', 'mipro' ),
						'default' => 0,
					),
					array(
						'id'      => 'kft_header_top_bar',
						'type'    => 'switch',
						'title'   => esc_html__( 'Show Top bar', 'mipro' ),
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
						'default' => 0,
					),
					array(
						'id'          => 'kft-top-bar-color',
						'type'        => 'color',
						'title'       => esc_html__( 'Top bar Text Color', 'mipro' ),
						'default'     => '#999999',
						'transparent' => false,
						'required'    => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'          => 'kft-top-bar-bg',
						'type'        => 'color_rgba',
						'title'       => esc_html__( 'Top bar Background', 'mipro' ),
						'default'     => array(
							'rgba' => 'rgb(255, 255, 255)',
						),
						'transparent' => false,
						'required'    => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'       => 'kft_header_contact_information',
						'type'     => 'editor',
						'title'    => esc_html__( 'Top bar left', 'mipro' ),
						'required' => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'    => 'kft_middle_header_content',
						'type'  => 'editor',
						'title' => esc_html__( 'Header Content - Information', 'mipro' ),
					),
					array(
						'id'    => 'kft_slogan_header_content',
						'type'  => 'editor',
						'title' => esc_html__( 'Header Slogan Content', 'mipro' ),
					),
					array(
						'id'       => 'kft_header_currency',
						'type'     => 'switch',
						'title'    => esc_html__( 'Header Currency', 'mipro' ),
						'default'  => 0,
						'on'       => esc_html__( 'Enable', 'mipro' ),
						'off'      => esc_html__( 'Disable', 'mipro' ),
						'required' => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'       => 'kft_header_language',
						'type'     => 'switch',
						'title'    => esc_html__( 'Header Language', 'mipro' ),
						'desc'     => esc_html__( "If you don't install WPML plugin, it will display demo html", 'mipro' ),
						'on'       => esc_html__( 'Yes', 'mipro' ),
						'off'      => esc_html__( 'No', 'mipro' ),
						'default'  => 0,
						'required' => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'       => 'kft_enable_tiny_account',
						'type'     => 'switch',
						'title'    => esc_html__( 'My Account', 'mipro' ),
						'on'       => esc_html__( 'Yes', 'mipro' ),
						'off'      => esc_html__( 'No', 'mipro' ),
						'default'  => 1,
						'required' => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'       => 'kft_login_style',
						'type'     => 'select',
						'title'    => esc_html__( 'My Account Type', 'mipro' ),
						'default'  => 'dropdown',
						'options'  => array(
							'dropdown' => esc_html__( 'Dropdown', 'mipro' ),
							'canvas'   => esc_html__( 'Off-Canvas', 'mipro' ),
						),
						'required' => array(
							array( 'kft_enable_tiny_account', 'equals', true ),
						),
					),
					array(
						'id'       => 'kft_enable_tiny_wishlist',
						'type'     => 'switch',
						'title'    => esc_html__( 'Wishlist', 'mipro' ),
						'on'       => esc_html__( 'Yes', 'mipro' ),
						'off'      => esc_html__( 'No', 'mipro' ),
						'default'  => 1,
						'required' => array(
							array( 'kft_header_top_bar', 'equals', true ),
						),
					),
					array(
						'id'      => 'kft_enable_tiny_shopping_cart',
						'type'    => 'switch',
						'title'   => esc_html__( 'Shopping Cart', 'mipro' ),
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
						'default' => 1,
					),
					array(
						'id'       => 'kft_tiny_cart_style',
						'type'     => 'select',
						'title'    => esc_html__( 'Shopping Cart Type', 'mipro' ),
						'default'  => 'dropdown',
						'options'  => array(
							'dropdown' => esc_html__( 'Dropdown', 'mipro' ),
							'canvas'   => esc_html__( 'Off-Canvas', 'mipro' ),
						),
						'required' => array(
							array( 'kft_enable_tiny_shopping_cart', 'equals', true ),
						),
					),
					array(
						'id'      => 'kft_enable_search',
						'type'    => 'switch',
						'title'   => esc_html__( 'Search Bar', 'mipro' ),
						'on'      => esc_html__( 'Yes', 'mipro' ),
						'off'     => esc_html__( 'No', 'mipro' ),
						'default' => 1,
					),
					array(
						'title'    => esc_html__( 'Enable Ajax Search', 'mipro' ),
						'desc'     => '',
						'id'       => 'kft_ajax_search',
						'default'  => '1',
						'type'     => 'switch',
						'required' => array(
							array( 'kft_enable_search', 'equals', true ),
						),
					),
					array(
						'title'    => esc_html__( 'Number Of Results', 'mipro' ),
						'desc'     => esc_html__( 'Input -1 to show all results', 'mipro' ),
						'id'       => 'kft_ajax_search_number_result',
						'default'  => 3,
						'type'     => 'text',
						'required' => array(
							array( 'kft_enable_search', 'equals', true ),
						),
					),
				),
			);

			/** Color Scheme Options  * */
			$this->sections[] = array(
				'icon'       => 'el el-brush',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Color Scheme', 'mipro' ),
				'fields'     => array(
					array(
						'id'          => 'kft_primary_color',
						'type'        => 'color',
						'title'       => esc_html__( 'Primary Color', 'mipro' ),
						'subtitle'    => esc_html__( 'Select a main color for your site.', 'mipro' ),
						'default'     => '#ed9c3d',
						'transparent' => false,
					),
					array(
						'id'          => 'kft_secondary_color',
						'type'        => 'color',
						'title'       => esc_html__( 'Secondary Color', 'mipro' ),
						'default'     => '#444444',
						'transparent' => false,
					),
					array(
						'id'          => 'kft_body_background_color',
						'type'        => 'color',
						'title'       => esc_html__( 'Body Background Color', 'mipro' ),
						'default'     => '#ffffff',
						'transparent' => false,
					),
				),
			);

			/** Typography Config    */
			$this->sections[] = array(
				'icon'       => 'el el-fontsize',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Typography', 'mipro' ),
				'fields'     => array(
					array(
						'id'          => 'kft_title_font',
						'type'        => 'typography',
						'title'       => esc_html__( 'Title Font', 'mipro' ),
						'google'      => true,
						'font-backup' => true,
						'subsets'     => false,
						'font-style'  => false,
						'font-size'   => false,
						'font-weight' => false,
						'line-height' => false,
						'text-align'  => false,
						'color'       => false,
						'default'     => array(
							'color'       => '#000000',
							'google'      => true,
							'font-family' => 'Poppins',
						),
						'preview'     => array(
							'text' => esc_html__( 'This is my font preview!', 'mipro' ),
							'size' => '30px',
						),
					),
					array(
						'id'      => 'kft_title_font_weight',
						'type'    => 'select',
						'title'   => esc_html__( 'Title Font Weight', 'mipro' ),
						'desc'    => esc_html__( 'Choose Font Weight', 'mipro' ),
						'default' => '600',
						'options' => array(
							'100' => '100',
							'200' => '200',
							'300' => '300',
							'400' => '400',
							'500' => '500',
							'600' => '600',
							'700' => '700',
							'800' => '800',
							'900' => '900',
						),
					),
					array(
						'id'          => 'kft_body_font',
						'type'        => 'typography',
						'title'       => esc_html__( 'Body Font', 'mipro' ),
						'google'      => true,
						'font-backup' => true,
						'subsets'     => false,
						'font-style'  => false,
						'font-size'   => false,
						'line-height' => false,
						'font-weight' => false,
						'text-align'  => false,
						'color'       => false,
						'default'     => array(
							'color'       => '#000000',
							'google'      => true,
							'font-family' => 'Lato',
						),
						'preview'     => array(
							'text' => esc_html__( 'This is my font preview!', 'mipro' ),
							'size' => '30px',
						),
					),
					array(
						'id'      => 'kft_font_size_body',
						'type'    => 'slider',
						'title'   => esc_html__( 'Body Font Size', 'mipro' ),
						'desc'    => esc_html__( 'In pixels. Default is 14px', 'mipro' ),
						'min'     => '10',
						'step'    => '1',
						'max'     => '50',
						'default' => '14',
					),
					array(
						'id'      => 'kft_line_height_body',
						'type'    => 'slider',
						'title'   => esc_html__( 'Body Font Line Height', 'mipro' ),
						'desc'    => esc_html__( 'In pixels. Default is 24px', 'mipro' ),
						'min'     => '10',
						'step'    => '1',
						'max'     => '50',
						'default' => '24',
					),
				),
			);
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Typekit Fonts', 'mipro' ),
				'fields'     => array(
					array(
						'title' => 'Typekit Kit ID',
						'id'    => 'typekit_id',
						'type'  => 'text',
						'desc'  => esc_html__( 'Enter your ', 'mipro' ) . '<a target="_blank" href="https://typekit.com/account/kits">Typekit Kit ID</a>.',
					),
					array(
						'title' => 'Typekit Font Face',
						'id'    => 'typekit_fonts',
						'type'  => 'text',
						'desc'  => esc_html__( 'Example: futura-pt', 'mipro' ),
					),
				),
			);
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Custom Fonts', 'mipro' ),
				'fields'     => array(
					array(
						'id'           => 'custom_fonts',
						'type'         => 'repeater',
						'title'        => esc_html__( 'Custom Fonts', 'mipro' ),
						'subtitle'     => esc_html__( 'Upload a custom font to use throughout the site. All files are not necessary but are recommended for full browser support. You can upload as many custom fonts as you need. Click the "Add" button for additional upload boxes.', 'mipro' ),
						'default'      => array(),
						'bind_title'   => 'name',
						'group_values' => true,
						'limit'        => 50,
						'fields'       => array(
							array(
								'title'   => esc_html__( 'Font Name (this will be used in the font-family dropdown)', 'mipro' ),
								'desc'    => '',
								'id'      => 'name',
								'default' => '',
								'type'    => 'text',
								'class'   => 'custom-font-name',
							),
							array(
								'title'   => esc_html__( 'Font Weight', 'mipro' ),
								'desc'    => esc_html__( 'Enter font-weight. Ex: 400', 'mipro' ),
								'id'      => 'font_weight',
								'default' => '',
								'type'    => 'text',
								'class'   => 'custom-font-name',
							),
							array(
								'title'   => 'WOFF',
								'desc'    => esc_html__( 'Upload the .woff font file.', 'mipro' ),
								'id'      => 'woff',
								'default' => '',
								'url'     => true,
								'preview' => false,
								'type'    => 'media',
								'mode'    => false,
							),
							array(
								'title'   => 'WOFF2',
								'desc'    => esc_html__( 'Upload the .woff2 font file.', 'mipro' ),
								'id'      => 'woff2',
								'default' => '',
								'url'     => true,
								'preview' => false,
								'type'    => 'media',
								'mode'    => false,
							),
							array(
								'title'   => 'TTF',
								'desc'    => esc_html__( 'Upload the .ttf font file.', 'mipro' ),
								'id'      => 'ttf',
								'default' => '',
								'url'     => true,
								'preview' => false,
								'type'    => 'media',
								'mode'    => false,
							),
							array(
								'title'   => 'SVG',
								'desc'    => esc_html__( 'Upload the .svg font file.', 'mipro' ),
								'id'      => 'svg',
								'default' => '',
								'url'     => true,
								'preview' => false,
								'type'    => 'media',
								'mode'    => false,
							),
							array(
								'title'   => 'EOT',
								'desc'    => esc_html__( 'Upload the .eot font file.', 'mipro' ),
								'id'      => 'eot',
								'default' => '',
								'url'     => true,
								'preview' => false,
								'type'    => 'media',
								'mode'    => false,
							),
						),
					),
				),
			);

			/*** WooCommerce Config     ** */
			if ( class_exists( 'WooCommerce' ) ) {
				$this->sections[] = array(
					'icon'   => 'el el-shopping-cart',
					'title'  => esc_html__( 'WooCommerce', 'mipro' ),
					'fields' => array(
						array(
							'title'   => esc_html__( 'Enable Back Image', 'mipro' ),
							'desc'    => esc_html__( 'Show back on hover. It will show an image from Product Gallery', 'mipro' ),
							'id'      => 'kft_effect_product',
							'default' => '1',
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Hover Back Image Style', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_effect_hover_product_img',
							'default' => 'zoom-long',
							'type'    => 'select',
							'options' => array(
								'zoom-long' => esc_html__( 'Zoom Long', 'mipro' ),
								'zoom-fade' => esc_html__( 'Zoom Fade', 'mipro' ),
								'fade-in'   => esc_html__( 'Fade In', 'mipro' ),
								'fade-out'  => esc_html__( 'Fade Out', 'mipro' ),
							),
						),
						array(
							'title'   => esc_html__( 'Number Of Gallery Product Image', 'mipro' ),
							'id'      => 'kft_product_gallery_number',
							'default' => 3,
							'type'    => 'text',
						),
						array(
							'title' => esc_html__( 'Quickshop', 'mipro' ),
							'desc'  => '',
							'id'    => 'quickshop_options',
							'icon'  => true,
							'type'  => 'info',
						),
						array(
							'title'   => esc_html__( 'Activate Quickshop', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_enable_quickshop',
							'default' => '1',
							'type'    => 'switch',
						),
						array(
							'title' => esc_html__( 'Lazy Loading', 'mipro' ),
							'desc'  => '',
							'id'    => 'kft_lazy_loading',
							'icon'  => true,
							'type'  => 'info',
						),
						array(
							'title'   => esc_html__( 'Enable Lazy Loading', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_enable_lazyload_product',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title' => esc_html__( 'Catalog Mode', 'mipro' ),
							'desc'  => '',
							'id'    => 'introduction_catalog_mode',
							'icon'  => true,
							'type'  => 'info',
						),
						array(
							'title'   => esc_html__( 'Enable Catalog Mode', 'mipro' ),
							'desc'    => esc_html__( 'Hide all Add To Cart buttons on your site. You can also hide Shopping cart by going to Header tab > turn Shopping Cart option off', 'mipro' ),
							'id'      => 'kft_enable_catalog_mode',
							'default' => '0',
							'type'    => 'switch',
						),
						array(
							'title' => esc_html__( 'Product Label', 'mipro' ),
							'id'    => 'product_label',
							'type'  => 'info',
						),
						array(
							'title'   => esc_html__( 'Product Sale in Percentage', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_sale_percentage',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Feature Label', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_feature_label',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Out Of Stock Label', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_out_of_stock_label',
							'default' => 1,
							'type'    => 'switch',
						),
					),
				);

				/*** Product Category */
				$this->sections[] = array(
					'title'  => esc_html__( 'Product Category', 'mipro' ),
					'icon'   => 'el-icon-tags',
					'fields' => array(),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Layout', 'mipro' ),
					'fields'     => array(
						array(
							'id'      => 'kft_prod_cat_layout',
							'type'    => 'image_select',
							'title'   => esc_html__( 'Product Category Layout', 'mipro' ),
							'des'     => esc_html__( 'Select main content and sidebar alignment.', 'mipro' ),
							'options' => $kft_layouts,
							'default' => 'full-width',
						),
						array(
							'title'   => esc_html__( 'Left Sidebar', 'mipro' ),
							'id'      => 'kft_prod_cat_left_sidebar',
							'default' => 'product-category-sidebar',
							'type'    => 'select',
							'options' => mipro_get_sidebars(),
						),
						array(
							'title'   => esc_html__( 'Right Sidebar', 'mipro' ),
							'id'      => 'kft_prod_cat_right_sidebar',
							'default' => 'product-category-sidebar',
							'type'    => 'select',
							'options' => mipro_get_sidebars(),
						),
						array(
							'title'   => esc_html__( 'Off Canvas Sidebar on Mobile', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_show_sidebar_button',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Color Swatches', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Show Color Swatches', 'mipro' ),
							'desc'    => esc_html__( 'Show List of Color Swatches', 'mipro' ),
							'id'      => 'kft_enable_color_swatches',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title' => esc_html__( 'Color Swatches use Variation Images', 'mipro' ),
							'desc'  => esc_html__( 'Display Images Variation for Color Swatches', 'mipro' ),
							'id'    => 'kft_color_swatches_images',
							'type'  => 'switch',
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Grid, List View', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Show Grid, List view', 'mipro' ),
							'desc'    => esc_html__( 'Show product in grid or list view', 'mipro' ),
							'id'      => 'kft_enable_grid_list',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Default catalog view', 'mipro' ),
							'desc'    => esc_html__( 'Display products in grid or list view by default', 'mipro' ),
							'id'      => 'kft_grid_list_default',
							'type'    => 'select',
							'default' => 'grid',
							'options' => array(
								'grid' => esc_html__( 'Grid', 'mipro' ),
								'list' => esc_html__( 'List', 'mipro' ),
							),
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Data Setting', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Ajax Shop', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_ajax_shop',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Show Filters Area', 'mipro' ),
							'id'      => 'kft_show_filters_area',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Columns', 'mipro' ),
							'id'      => 'kft_prod_cat_columns',
							'default' => '3',
							'type'    => 'select',
							'options' => array(
								3 => 3,
								4 => 4,
								5 => 5,
								6 => 6,
							),
						),
						array(
							'title'   => esc_html__( 'Products Per Page', 'mipro' ),
							'desc'    => esc_html__( 'Number of products per page', 'mipro' ),
							'id'      => 'kft_prod_per_page',
							'default' => 9,
							'type'    => 'text',
						),
						array(
							'id'      => 'kft_per_page_options',
							'type'    => 'text',
							'title'   => esc_html__( 'Per page variations', 'mipro' ),
							'default' => '12,24,36,-1',
							'desc'    => esc_html__( 'For example: 12,24,36,-1. Set -1 to show all products', 'mipro' ),
						),
						array(
							'id'      => 'kft_shop_pagination',
							'type'    => 'select',
							'title'   => esc_html__( 'Products pagination', 'mipro' ),
							'options' => array(
								'pagination' => esc_html__( 'Pagination', 'mipro' ),
								'loadmore'   => esc_html__( '"Load more" button', 'mipro' ),
								'infinit'    => esc_html__( 'Infinit scrolling', 'mipro' ),
							),
							'default' => 'pagination',
						),
						array(
							'title'   => esc_html__( 'Product Thumbnail', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_thumbnail',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Label', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_label',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Categories', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_cat',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Title', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_title',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product SKU', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_sku',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Rating', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_rating',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Price', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_price',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Add To Cart Button', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat_add_to_cart',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Short Description - Grid View', 'mipro' ),
							'desc'    => esc_html__( 'Show product description on grid view', 'mipro' ),
							'id'      => 'kft_prod_cat_grid_desc',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'    => esc_html__( 'Grid View - Limit Words', 'mipro' ),
							'desc'     => '',
							'id'       => 'kft_prod_cat_grid_desc_words',
							'default'  => 8,
							'type'     => 'text',
							'required' => array( array( 'kft_prod_cat_grid_desc', 'equals', 1 ) ),
						),
						array(
							'title'   => esc_html__( 'Product Short Description - List View', 'mipro' ),
							'desc'    => esc_html__( 'Show product description on list view', 'mipro' ),
							'id'      => 'kft_prod_cat_list_desc',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'    => esc_html__( 'List View - Limit Words', 'mipro' ),
							'desc'     => '',
							'id'       => 'kft_prod_cat_list_desc_words',
							'default'  => 50,
							'type'     => 'text',
							'required' => array( array( 'kft_prod_cat_list_desc', 'equals', 1 ) ),
						),
					),
				);
				/* Product Details Config  */
				$this->sections[] = array(
					'icon'       => 'el el-icon-indent-left',
					'icon_class' => 'icon',
					'title'      => esc_html__( 'Product Details', 'mipro' ),
					'fields'     => array(),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Layout', 'mipro' ),
					'fields'     => array(
						array(
							'id'      => 'kft_prod_layout',
							'type'    => 'image_select',
							'title'   => esc_html__( 'Product Detail Layout', 'mipro' ),
							'des'     => esc_html__( 'Select main content and sidebar alignment.', 'mipro' ),
							'options' => $kft_layouts,
							'default' => 'full-width',
						),
						array(
							'title'   => esc_html__( 'Left Sidebar', 'mipro' ),
							'id'      => 'kft_prod_left_sidebar',
							'default' => 'product-detail-sidebar',
							'type'    => 'select',
							'options' => mipro_get_sidebars(),
						),
						array(
							'title'   => esc_html__( 'Right Sidebar', 'mipro' ),
							'id'      => 'kft_prod_right_sidebar',
							'default' => 'product-detail-sidebar',
							'type'    => 'select',
							'options' => mipro_get_sidebars(),
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Data Setting', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Product Variation Color Swatches', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_variation_swatches',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Label', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_label',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Navigation', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_show_prod_navigation',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Title', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_title',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Title In Content', 'mipro' ),
							'desc'    => esc_html__( 'Display the product title in the page content instead of above the breadcrumbs', 'mipro' ),
							'id'      => 'kft_prod_title_in_content',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Rating', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_rating',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product SKU', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_sku',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Availability', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_availability',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Short Description', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_excerpt',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Count Down Timer', 'mipro' ),
							'desc'    => esc_html__( 'You have to activate Mipro plugin', 'mipro' ),
							'id'      => 'kft_prod_count_down',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Price', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_price',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Add To Cart Button', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_add_to_cart',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Categories', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_cat',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Tags', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_tag',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Sharing', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_sharing',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Product Images', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Product Zoom', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_zoom',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product PhotoSwipe Lightbox', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_lightbox',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Zoom Button', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_zoom_button',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Thumbnail', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_thumbnail',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Thumbnails Style', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_thumbnails_style',
							'default' => 'horizontal',
							'type'    => 'select',
							'options' => array(
								'vertical'   => esc_html__( 'Vertical', 'mipro' ),
								'horizontal' => esc_html__( 'Horizontal', 'mipro' ),
							),
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Sticky Product Bar', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Enable Sticky Product Bar', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_sticky_bar',
							'default' => 0,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Show Sticky Product Image', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_show_product_sticky_image',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Show Sticky Product name', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_show_product_sticky_name',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Show Sticky Product Rating', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_sticky_rating',
							'default' => 1,
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Show Sticky Product Price', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_sticky_price',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Show Sticky Product Add to cart Button', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_product_sticky_cart',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Size Chart', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Product Size Chart', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_show_prod_size_chart',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Size Chart Image', 'mipro' ),
							'desc'    => esc_html__( 'Select an image file for all Product', 'mipro' ),
							'id'      => 'kft_prod_size_chart',
							'default' => array( 'url' => get_parent_theme_file_uri( '/assets/images/size-chart.jpg' ) ),
							'type'    => 'media',
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Product Tab', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Product Tabs', 'mipro' ),
							'desc'    => esc_html__( 'Enable Product Tabs', 'mipro' ),
							'id'      => 'kft_prod_tabs',
							'default' => 1,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Tabs Style', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_style_tabs',
							'default' => 'default',
							'type'    => 'select',
							'options' => array(
								'default'   => esc_html__( 'Default', 'mipro' ),
								'accordion' => esc_html__( 'Accordion', 'mipro' ),
								'vertical'  => esc_html__( 'Vertical', 'mipro' ),
							),
						),
						array(
							'title'   => esc_html__( 'Product Tabs Position', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_tabs_position',
							'default' => 'after_summary',
							'fold'    => 'kft_prod_tabs',
							'type'    => 'select',
							'options' => array(
								'after_summary'  => esc_html__( 'After Summary', 'mipro' ),
								'inside_summary' => esc_html__( 'Inside Summary', 'mipro' ),
							),
						),
						array(
							'title'   => esc_html__( 'Product Custom Tab', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_custom_tab',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'fold'    => 'kft_prod_tabs',
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Product Custom Tab Title', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_custom_tab_title',
							'default' => 'Custom tab',
							'fold'    => 'kft_prod_tabs',
							'type'    => 'text',
						),
						array(
							'title'   => esc_html__( 'Product Custom Tab Content', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_custom_tab_content',
							'default' => 'You can add the content for product',
							'fold'    => 'kft_prod_tabs',
							'type'    => 'textarea',
						),
					),
				);
				$this->sections[] = array(
					'subsection' => true,
					'title'      => esc_html__( 'Upsell, Related Product', 'mipro' ),
					'fields'     => array(
						array(
							'title'   => esc_html__( 'Up-Sell Products', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_upsells',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
						array(
							'title'   => esc_html__( 'Related Products', 'mipro' ),
							'desc'    => '',
							'id'      => 'kft_prod_related',
							'default' => 0,
							'on'      => esc_html__( 'Show', 'mipro' ),
							'off'     => esc_html__( 'Hide', 'mipro' ),
							'type'    => 'switch',
						),
					),
				);

			};

			/* Blog Settings */
			$this->sections[] = array(
				'icon'       => 'el el-file-edit',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Blog', 'mipro' ),
				'fields'     => array(),
			);

			// Blog
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Blog', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_blog_layout',
						'type'    => 'image_select',
						'title'   => esc_html__( 'Blog Layout', 'mipro' ),
						'des'     => esc_html__( 'Select main content and sidebar alignment.', 'mipro' ),
						'options' => $kft_layouts,
						'default' => 'right-sidebar',
					),
					array(
						'title'   => esc_html__( 'Left Sidebar', 'mipro' ),
						'id'      => 'kft_blog_left_sidebar',
						'default' => 'blog-sidebar',
						'type'    => 'select',
						'options' => mipro_get_sidebars(),
					),
					array(
						'title'   => esc_html__( 'Right Sidebar', 'mipro' ),
						'id'      => 'kft_blog_right_sidebar',
						'default' => 'blog-sidebar',
						'type'    => 'select',
						'options' => mipro_get_sidebars(),
					),
					array(
						'title'   => esc_html__( 'Blog Thumbnail', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_thumbnail',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Lazy Loading', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_lazyload',
						'default' => 0,
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Date', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_date',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Title', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_title',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Author', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_author',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Comment', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_comment',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Count View', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_count_view',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Read More Button', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_read_more',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Categories', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_categories',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Tags', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_tags',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Excerpt', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_excerpt',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Excerpt Strip All Tags', 'mipro' ),
						'desc'    => esc_html__( 'Strip all html tags in Excerpt', 'mipro' ),
						'id'      => 'kft_blog_excerpt_strip_tags',
						'default' => 0,
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Excerpt Max Words', 'mipro' ),
						'desc'    => esc_html__( 'Input -1 to show full excerpt', 'mipro' ),
						'id'      => 'kft_blog_excerpt_max_words',
						'default' => '-1',
						'type'    => 'text',
					),
				),
			);

			/** Blog Detail */
			$this->sections[] = array(
				'subsection' => true,
				'title'      => esc_html__( 'Blog Details', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_blog_details_layout',
						'type'    => 'image_select',
						'title'   => esc_html__( 'Blog Detail Layout', 'mipro' ),
						'des'     => esc_html__( 'Select main content and sidebar alignment.', 'mipro' ),
						'options' => $kft_layouts,
						'default' => 'right-sidebar',
					),
					array(
						'title'   => esc_html__( 'Left Sidebar', 'mipro' ),
						'id'      => 'kft_blog_details_left_sidebar',
						'default' => 'blog-detail-sidebar',
						'type'    => 'select',
						'options' => mipro_get_sidebars(),
					),
					array(
						'title'   => esc_html__( 'Right Sidebar', 'mipro' ),
						'id'      => 'kft_blog_details_right_sidebar',
						'default' => 'blog-detail-sidebar',
						'type'    => 'select',
						'options' => mipro_get_sidebars(),
					),
					array(
						'title'   => esc_html__( 'Blog Thumbnail', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_thumbnail',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Date', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_date',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Title', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_title',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Content', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_content',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Categories', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_categories',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Tags', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_tags',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Sharing', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_sharing',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Navigation', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_navigation',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Author Box', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_author_box',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Related Posts', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_related_posts',
						'default' => 0,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
					array(
						'title'   => esc_html__( 'Blog Comment Form', 'mipro' ),
						'desc'    => '',
						'id'      => 'kft_blog_details_comment_form',
						'default' => 1,
						'on'      => esc_html__( 'Show', 'mipro' ),
						'off'     => esc_html__( 'Hide', 'mipro' ),
						'type'    => 'switch',
					),
				),
			);

			/* Instagram */
			$this->sections[] = array(
				'icon'       => 'el el-instagram',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Instagram', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'instagram_user_id',
						'type'    => 'text',
						'title'   => esc_html__( 'User ID', 'mipro' ),
						'default' => '',
					),
					array(
						'id'      => 'instagram_access_token',
						'type'    => 'text',
						'title'   => esc_html__( 'Access Token', 'mipro' ),
						'default' => '',
					),
					array(
						'id'    => 'instagram_info',
						'type'  => 'info',
						'title' => esc_html__( 'How to Get User ID and Access Token', 'mipro' ),
						'style' => 'critical',
						'desc'  => wp_kses(
							__( '1. You need connect Instagram to Facebook before get token, Read more: <a href="https://smashballoon.com/instagram-business-profiles/" target="_blank">https://smashballoon.com/instagram-business-profiles/</a> <br> 2. You can get User ID & Access Token in here: <a href="https://smashballoon.com/instagram-feed/token/" target="_blank">https://smashballoon.com/instagram-feed/token/</a>  Then you choose <strong>Bussiness</strong>', 'mipro' ),
							array(
								'a'      => array(
									'href'   => array(),
									'target' => array(),
								),
								'br'     => array(),
								'strong' => array(),
							)
						),
					),
				),
			);

			/** Maintenance */
			$this->sections[] = array(
				'icon'       => 'el el-off',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Maintenance', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_maintenance_mode',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable maintenance mode', 'mipro' ),
						'default' => 0,
					),
					array(
						'id'    => 'kft_maintenance_mode_page',
						'type'  => 'select',
						'title' => esc_html__( 'Maintenance mode page', 'mipro' ),
						'desc'  => esc_html__( 'Select page to maintenance mode. For example: "Coming soon" or You can create page: Page > Add new and choose Template "Blank Page Template" in Page Attributes', 'mipro' ),
						'data'  => 'pages',
					),
				),
			);

			/** Social Button */
			$this->sections[] = array(
				'icon'       => 'el el-link',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Social Button', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_social_button',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Social Button', 'mipro' ),
						'default' => 0,
					),
					array(
						'id'      => 'kft_social_button_mobile',
						'type'    => 'switch',
						'title'   => esc_html__( 'Disable Social Button on Mobile', 'mipro' ),
						'default' => 1,
					),
					array(
						'id'      => 'kft_social_position',
						'type'    => 'select',
						'title'   => esc_html__( 'Social position', 'mipro' ),
						'options' => array(
							'left'  => esc_html__( 'Left', 'mipro' ),
							'right' => esc_html__( 'Right', 'mipro' ),
						),
						'default' => 'right',
					),
					array(
						'id'      => 'kft_social_type',
						'type'    => 'select',
						'title'   => esc_html__( 'Social type', 'mipro' ),
						'options' => array(
							'share'  => esc_html__( 'Share', 'mipro' ),
							'follow' => esc_html__( 'Follow', 'mipro' ),
						),
						'default' => 'follow',
					),
					array(
						'id'       => 'facebook_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Facebook link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'twitter_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Twitter link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'instagram_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Instagram link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'google_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Google link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'youtube_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Youtube link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'pinterest_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Pinterest link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'linkedin_link',
						'type'     => 'text',
						'title'    => esc_html__( 'LinkedIn link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
					array(
						'id'       => 'reddit_link',
						'type'     => 'text',
						'title'    => esc_html__( 'Reddit link', 'mipro' ),
						'default'  => '#',
						'required' => array(
							array( 'kft_social_type', 'equals', 'follow' ),
						),
					),
				),
			);

			/* Cookie Notice */
			$this->sections[] = array(
				'icon'       => 'el el-bullhorn',
				'icon_class' => 'icon',
				'title'      => esc_html__( 'Cookie Notice', 'mipro' ),
				'fields'     => array(
					array(
						'id'      => 'kft_cookie_notice',
						'type'    => 'switch',
						'title'   => esc_html__( 'Enable Cookie Notice', 'mipro' ),
						'default' => 0,
					),
					array(
						'id'       => 'kft_cookie_text',
						'type'     => 'textarea',
						'title'    => esc_html__( 'Message', 'mipro' ),
						'subtitle' => esc_html__( 'Enter the cookie notice message', 'mipro' ),
						'default'  => esc_html__( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'mipro' ),
					),
					array(
						'id'       => 'kft_cookie_info_link',
						'type'     => 'select',
						'title'    => esc_html__( 'More info link', 'mipro' ),
						'subtitle' => esc_html__( 'Select page to information about cookies', 'mipro' ),
						'data'     => 'pages',
					),
					array(
						'id'       => 'kft_cookie_expiry',
						'type'     => 'text',
						'title'    => esc_html__( 'Cookie Expiry', 'mipro' ),
						'subtitle' => esc_html__( 'The ammount of time that cookies should be store for (day).', 'mipro' ),
						'default'  => '30',
					),
				),
			);
		}
		function setHelpTabs() {

		}
		function setArguments() {

			$theme      = wp_get_theme();
			$this->args = array(
				'opt_name'                  => 'mipro_opt',
				'menu_type'                 => 'menu',
				'display_name'              => $theme->get( 'Name' ),
				'display_version'           => $theme->get( 'Version' ),
				'allow_sub_menu'            => true,
				'menu_title'                => esc_html__( 'Theme Options', 'mipro' ),
				'page_title'                => esc_html__( 'Theme Options', 'mipro' ),
				'templates_path'            => get_parent_theme_file_uri( '/inc/third-party/options-framework/templates' ),
				'google_api_key'            => '',
				'disable_google_fonts_link' => false,
				'google_update_weekly'      => false,
				'async_typography'          => false,
				'admin_bar'                 => true,
				'admin_bar_icon'            => 'fa fa-cogs',
				'admin_bar_priority'        => 50,
				'global_variable'           => '',
				'dev_mode'                  => false,
				'update_notice'             => true,
				'customizer'                => true,
				'page_priority'             => 61,
				'page_parent'               => 'themes.php',
				'page_permissions'          => 'manage_options',
				'menu_icon'                 => get_parent_theme_file_uri( '/assets/images/icon_option.png' ),
				'last_tab'                  => '',
				'page_icon'                 => 'icon-themes',
				'page_slug'                 => '_options',
				'save_defaults'             => true,
				'default_show'              => false,
				'default_mark'              => '',
				'show_import_export'        => true,
				'show_options_object'       => false,
				'transient_time'            => 60 * MINUTE_IN_SECONDS,
				'output'                    => true,
				'output_tag'                => true,
				'footer_credit'             => 'v1.0',
				'database'                  => '',
				'system_info'               => false,
				'hints'                     => array(
					'icon'          => 'el el-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				),
			);
		}
	}

	global $redux_mipro_settings;
	$redux_mipro_settings = new Mipro_Redux_Framework_Option();
}
