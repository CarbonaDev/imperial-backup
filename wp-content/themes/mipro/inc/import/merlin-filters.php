<?php
/**
 * Available filters for extending Merlin WP.
 *
 * @package   Merlin Filters
 * @author    Joyce
 */

/** Merlin Import files */
function mipro_merlin_import_files() {
	return array(
		array(
			'import_file_name'             => 'Home 1',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import/import-file/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import/import-file/widgets.wie',
			'local_import_rev_slider_file' => trailingslashit( get_template_directory() ) . 'inc/import/import-file/revslider/home-5.zip',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import/import-file/theme-options.json',
					'option_name' => 'mipro_opt',
				),
			),
			'custom_set_home_page'         => 'Home 5',
		),
		array(
			'import_file_name'             => 'Home 2',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import/import-file/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import/import-file/widgets.wie',
			'local_import_rev_slider_file' => trailingslashit( get_template_directory() ) . 'inc/import/import-file/revslider/home6-v2.zip',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import/import-file/theme-options.json',
					'option_name' => 'mipro_opt',
				),
			),
			'custom_set_home_page'         => 'Home6',
		),
		array(
			'import_file_name'             => 'Home 3',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import/import-file/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import/import-file/widgets.wie',
			'local_import_rev_slider_file' => trailingslashit( get_template_directory() ) . 'inc/import/import-file/revslider/home7.zip',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import/import-file/theme-options.json',
					'option_name' => 'mipro_opt',
				),
			),
			'custom_set_home_page'         => 'Home7',
		),
		array(
			'import_file_name'             => 'Home 4',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/import/import-file/demo-content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/import/import-file/widgets.wie',
			'local_import_rev_slider_file' => trailingslashit( get_template_directory() ) . 'inc/import/import-file/revslider/home-8.zip',
			'local_import_redux'           => array(
				array(
					'file_path'   => trailingslashit( get_template_directory() ) . 'inc/import/import-file/theme-options.json',
					'option_name' => 'mipro_opt',
				),
			),
			'custom_set_home_page'         => 'Home 8',
		),
	);
}
add_filter( 'merlin_import_files', 'mipro_merlin_import_files' );

/**
 * Execute custom code after the whole import has finished.
 */
function mipro_merlin_after_import_setup() {

	/** Menu Locations */
	$locations = get_theme_mod( 'nav_menu_locations' );
	$menus     = wp_get_nav_menus();

	if ( $menus ) {
		foreach ( $menus as $menu ) {
			if ( $menu->name == 'Shop by Categories' ) {
				$locations['vertical'] = $menu->term_id;
			}
		}
	}
	set_theme_mod( 'nav_menu_locations', $locations );

	/** Visual Composer Custom Post Type */
	update_option( 'wpb_js_content_types', array( 'page', 'kft_footer' ) );

	/* Setup WC Pages */
	$woopages = array(
		'woocommerce_shop_page_id'      => 'Shop',
		'woocommerce_cart_page_id'      => 'Shopping cart',
		'woocommerce_checkout_page_id'  => 'Checkout',
		'woocommerce_myaccount_page_id' => 'My Account',
	);

	foreach ( $woopages as $woo_page_name => $woo_page_title ) {
		$woopage = get_page_by_title( $woo_page_title );
		if ( isset( $woopage->ID ) && $woopage->ID ) {
			update_option( $woo_page_name, $woopage->ID );
		}
	}

	/* Setup WC Product Images */
	update_option( 'woocommerce_single_image_width', 550 );
	update_option( 'woocommerce_thumbnail_image_width', 330 );
	update_option( 'woocommerce_thumbnail_cropping', 'custom' );
	update_option( 'woocommerce_thumbnail_cropping_custom_width', '330' );
	update_option( 'woocommerce_thumbnail_cropping_custom_height', '413' );

	/* Enable YITH Compare Button */
	if ( class_exists( 'YITH_Woocompare' ) ) {
		update_option( 'yith_woocompare_compare_button_in_products_list', 'yes' );
	}

	if ( class_exists( 'YITH_WCWL' ) ) {
		update_option( 'yith_wcwl_after_add_to_wishlist_behaviour', 'view' );
		update_option( 'yith_wcwl_product_added_text', 'Product added!' );
		update_option( 'yith_wcwl_add_to_wishlist_style', 'link' );
		update_option( 'yith_wcwl_add_to_wishlist_icon', 'none' );
	}

	/** Create WC Attribute */
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
		$attribute_names     = array( 'Color', 'Size' );
		$register_attributes = array();

		foreach ( wc_get_attribute_taxonomies() as $attr ) {
			$attr                  = (array) $attr;
			$register_attributes[] = $attr['attribute_label'];
		}

		foreach ( $attribute_names as $attribute_name ) {
			global $wpdb;
			if ( ! in_array( $attribute_name, $register_attributes ) ) {
				$attribute = array(
					'attribute_label'   => $attribute_name,
					'attribute_name'    => strtolower( $attribute_name ),
					'attribute_type'    => 'select',
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => 0,
				);
				if ( 'Color' === $attribute_name ) {
					$attribute['attribute_type'] = 'color';
				}
				$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
				delete_transient( 'wc_attribute_taxonomies' );
			}
		}
	}

	/* Disable WC Notices */
	if ( class_exists( 'WC_Admin_Notices' ) ) {
		WC_Admin_Notices::remove_notice( 'install' );
	}

	delete_option( '_wc_needs_pages' );
	delete_transient( '_wc_activation_redirect' );

	flush_rewrite_rules();

}
add_action( 'merlin_after_all_import', 'mipro_merlin_after_import_setup' );

/**
 * Custom content for the generated child theme's functions.php file.
 *
 * @param string $output Generated content.
 * @param string $slug Parent theme slug.
 */
function mipro_generate_child_functions_php( $output, $slug ) {
	$output = "
		<?php
		function mipro_child_enqueue_styles() {
		    wp_enqueue_style( 'mipro-style' , get_template_directory_uri() . '/style.css' );
		    wp_enqueue_style( 'mipro-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'mipro-style' ) );
		}
		add_action(  'wp_enqueue_scripts', 'mipro_child_enqueue_styles' );\n
	";
	$output = trim( preg_replace( '/\t+/', '', $output ) );
	return $output;
}
add_filter( 'merlin_generate_child_functions_php', 'mipro_generate_child_functions_php', 10, 2 );

/**
 * Custom for Import
 *
 * @param string $selected_import_index Array() index.
 */
function mipro_merlin_import_custom( $selected_import_index ) {
	$import      = mipro_merlin_import_files();
	$import_file = $import[ $selected_import_index ];

	/* Set Home page after Import */
	if ( isset( $import_file['custom_set_home_page'] ) ) {
		$import_home = $import_file['custom_set_home_page'];
		$homepage    = get_page_by_title( $import_home );
		if ( isset( $homepage ) && $homepage->ID ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $homepage->ID );
		}
	}
}
add_action( 'merlin_after_all_import', 'mipro_merlin_import_custom' );
