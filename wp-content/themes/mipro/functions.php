<?php
/**
 *
 * The framework's functions
 */
require_once get_parent_theme_file_path( '/inc/functions.php' );

/**
 * Enqueue scripts and styles.
 */
function mipro_enqueue_scripts() {
    $version = mipro_get_theme_info( 'Version' );

	if ( ! class_exists( 'ReduxFramework' ) ) {
		wp_enqueue_style( 'mipro-font-google', mipro_google_font_url() );
	}

	// Load typekit fonts
	$typekit_id = mipro_get_opt( 'typekit_id' );
	if ( $typekit_id ) {
		wp_enqueue_style( 'mipro-typekit', '//use.typekit.net/' . esc_attr( $typekit_id ) . '.css', array(), null );
	}

	wp_dequeue_style( 'yith-wcwl-font-awesome' );
	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/assets/css/font-awesome.css' ), array(), $version );
	wp_enqueue_style( 'simple-line-icons', get_theme_file_uri( '/assets/css/simple-line-icons.css' ), array(), $version );

	/* Theme stylesheet. */
	wp_enqueue_style( 'mipro-style', get_stylesheet_uri(), array(), $version );

	wp_enqueue_style( 'mipro-default', get_theme_file_uri( '/assets/css/default.css' ), array(), $version );

	wp_enqueue_style( 'mipro-responsive', get_theme_file_uri( '/assets/css/responsive.css' ), array(), $version );
	wp_enqueue_style( 'mipro-shortcode', get_theme_file_uri( '/assets/css/shortcode.css' ), array(), $version );

	wp_enqueue_style( 'owl-carousel', get_theme_file_uri( '/assets/css/owl.carousel.min.css' ), array(), $version );
	wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.css' ), array(), $version );
	wp_enqueue_style( 'photoswipe', get_theme_file_uri( '/assets/css/photoswipe/photoswipe.css' ), array(), $version );
	wp_enqueue_style( 'photoswipe-default', get_theme_file_uri( '/assets/css/photoswipe/default-skin/default-skin.css' ), array(), $version );

	/* Enqueue scripts */
	wp_enqueue_script( 'owl-carousel', get_theme_file_uri( '/assets/js/owl.carousel.min.js' ), array(), $version, true );
	wp_enqueue_script( 'parallax', get_theme_file_uri( '/assets/js/jquery.parallax.js' ), array(), $version, true );
	wp_enqueue_script( 'magnific-popup', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array(), $version, true );
	wp_enqueue_script( 'photoswipe', get_theme_file_uri( '/assets/js/photoswipe.min.js' ), array(), $version, true );
	wp_enqueue_script( 'photoswipe-ui-default', get_theme_file_uri( '/assets/js/photoswipe-ui-default.min.js' ), array(), $version, true );
	wp_enqueue_script( 'imagesloaded', get_theme_file_uri( '/assets/js/imagesloaded.pkgd.min.js' ), array(), $version, true );
	wp_enqueue_script( 'isotope', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array(), $version, true );
	wp_enqueue_script( 'lazy', get_theme_file_uri( '/assets/js/jquery.lazy.min.js' ), array(), $version, true );
	wp_enqueue_script( 'bootstrap-tooltips', get_theme_file_uri( '/assets/js/jquery.tooltips.js' ), array(), $version, true );
	wp_enqueue_script( 'tween-max', get_theme_file_uri( '/assets/js/TweenMax.min.js' ), array(), $version, true );
	wp_enqueue_script( 'panr', get_theme_file_uri( '/assets/js/jquery.panr.js' ), array(), $version, true );
	wp_enqueue_script( 'waypoint', get_theme_file_uri( '/assets/js/jquery.waypoints.min.js' ), array(), $version, true );
	wp_enqueue_script( 'threesixty', get_theme_file_uri( '/assets/js/threesixty.min.js' ), array(), $version, true );
	wp_enqueue_script( 'countdown', get_theme_file_uri( '/assets/js/jquery.countdown.min.js' ), array(), $version, true );
	wp_enqueue_script( 'counter-up', get_theme_file_uri( '/assets/js/jquery.counterup.min.js' ), array(), $version, true );
	wp_enqueue_script( 'infinite-scroll', get_theme_file_uri( '/assets/js/infinite-scroll.pkgd.min.js' ), array(), $version, true );
	wp_enqueue_script( 'scroll-to', get_theme_file_uri( '/assets/js/jquery.scrollTo.min.js' ), array(), $version, true );
	wp_enqueue_script( 'easyzoom', get_theme_file_uri( '/assets/js/easyzoom.js' ), array(), $version, true );
	wp_enqueue_script( 'visible', get_theme_file_uri( '/assets/js/jquery.visible.min.js' ), array(), $version, true );

	wp_enqueue_script( 'cookie', get_theme_file_uri( '/assets/js/jquery.cookie.min.js' ), array( 'jquery' ), $version, true );

	if ( mipro_get_opt( 'kft_ajax_shop' ) && mipro_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) ) {
		wp_enqueue_script( 'pjax', get_theme_file_uri( '/assets/js/jquery.pjax.js' ), array(), $version, true );
	}

	if ( is_singular( 'product' ) && ( mipro_get_opt( 'kft_prod_thumbnails_style' ) == 'vertical' ) ) {
		wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array(), $version, true );
	}

	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'mipro-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'animation', get_theme_file_uri( '/assets/js/animation.js' ), array(), $version, true );

	$translations = array(
		'ajax_uri'               => esc_url( admin_url( 'admin-ajax.php' ) ),
		'kft_enable_ajax_search' => (int) mipro_get_opt( 'kft_ajax_search' ),
		'kft_ajax_search_nonce'  => wp_create_nonce( 'mipro-ajax-search' ),
		'kft_enable_popup'       => (int) mipro_get_opt( 'kft_enable_popup' ),
		'kft_popup_event'        => mipro_get_opt( 'kft_popup_event' ),
		'kft_popup_scroll'       => (int) mipro_get_opt( 'kft_popup_scroll' ),
		'kft_popup_timeout'      => (int) mipro_get_opt( 'kft_popup_timeout' ),
		'countdown_days'         => esc_html__( 'days', 'mipro' ),
		'countdown_hours'        => esc_html__( 'hours', 'mipro' ),
		'countdown_mins'         => esc_html__( 'mins', 'mipro' ),
		'countdown_sec'          => esc_html__( 'secs', 'mipro' ),
		'cart_message'           => esc_html__( ' has been added to your cart.', 'mipro' ),
		'kft_cookie_notice'      => (int) mipro_get_opt( 'kft_cookie_notice' ),
		'kft_cookie_expiry'      => (int) mipro_get_opt( 'kft_cookie_expiry' ),
		'kft_shop_pagination'    => mipro_get_opt( 'kft_shop_pagination' ),
		'kft_grid_list'          => ( mipro_get_opt( 'kft_grid_list_default' ) ) ? mipro_get_opt( 'kft_grid_list_default' ) : 'grid',
	);
	wp_localize_script( 'mipro-global', 'mipro_settings', $translations );

	wp_enqueue_script( 'wc-add-to-cart-variation' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mipro_enqueue_scripts', 1000 );

/* * * Enqueue admin style and scripts ** */
function mipro_admin_scripts() {
    $version = mipro_get_theme_info( 'Version' );

	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/assets/css/font-awesome.css' ), array(), $version );
	wp_enqueue_style( 'mipro-admin-style', get_theme_file_uri( '/assets/css/admin-style.css' ), array(), $version );
    wp_enqueue_script( 'mipro-admin-script', get_theme_file_uri( '/assets/js/admin-script.js' ), array( 'jquery' ), $version, true );
}
add_action( 'admin_enqueue_scripts', 'mipro_admin_scripts' );

/* * * Render google font link ** */
if ( ! function_exists( 'mipro_google_font_url' ) ) {
	function mipro_google_font_url() {
		$font_parse = 'Lato:100,100i,300,300i,400,400i,700,700i,900,900i|Poppins:300,400,500,600,700';

		$query_args = array(
			'family' => urldecode( $font_parse ),
			'subset' => rawurlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
}

//Removendo o Communication do my account
add_filter( 'shopmagic/core/communication_type/account_page_show', '__return_false' );