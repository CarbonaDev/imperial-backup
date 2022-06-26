<?php

/**
 * Dont Update the Theme
 * https://gist.github.com/jaredatch/f406d6b2ca543cdb4898
 */
if ( ! function_exists( 'mipro_dont_update_theme' ) ) {
	function mipro_dont_update_theme( $r, $url ) {
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r; // Not a theme update request. Bail immediately.
		}
		$themes = json_decode( $r['body']['themes'] );
		$child  = get_option( 'stylesheet' );
		unset( $themes->themes->$child );
		$r['body']['themes'] = json_encode( $themes );
		return $r;
	}
	add_filter( 'http_request_args', 'mipro_dont_update_theme', 5, 2 );
}

/*
 * Adds custom classes to the array of body classes.
 */
function mipro_body_classes( $classes ) {
	global $mipro_page_options;
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	if ( is_customize_preview() ) {
		$classes[] = 'has-customizer';
	}
	if ( is_page() ) {
		if ( $mipro_page_options['kft_header_overlap'] ) {
			$classes[] = 'header-overlap';
		}
		if ( $mipro_page_options['kft_header_text_color'] != 'default' ) {
			$classes[] = 'header-color-' . $mipro_page_options['kft_header_text_color'];
		}
	}
	if ( 'blank' === get_header_textcolor() ) {
		$classes[] = 'title-tagline-hidden';
	}
	if ( mipro_get_opt( 'kft_show_sidebar_button' ) ) {
		$classes[] = 'off-canvas-shop-sidebar';
	}
	if ( mipro_get_opt( 'kft_enable_sticky_header' ) ) {
		$classes[] = 'has_sticky_header';
	}
	$layout_width = mipro_get_opt( 'kft_layout' );
	if ( $layout_width ) {
		$classes[] = 'wrapper-layout-' . $layout_width;
	}
	if ( mipro_get_opt( 'kft_ajax_shop' ) ) {
		$classes[] = 'is_ajax_shop';
	}

	return $classes;
}
add_filter( 'body_class', 'mipro_body_classes' );

/* * * Theme Setup * * */
function mipro_setup() {

	$GLOBALS['content_width'] = 1200;

	add_editor_style();

	load_theme_textdomain( 'mipro' );

	/** Add theme support. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'quote', 'video' ) );
	add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'custom-background' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'custom-header' );

	/* Support images for Gutenberg */
	add_theme_support( 'align-wide' );

	/* Translation */
	load_theme_textdomain( 'mipro', get_template_directory() . '/languages' );

	$locale      = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) ) {
		require_once $locale_file;
	}
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'Small', 'mipro' ),
				'shortName' => esc_html__( 'S', 'mipro' ),
				'size'      => 19.5,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'Normal', 'mipro' ),
				'shortName' => esc_html__( 'M', 'mipro' ),
				'size'      => 22,
				'slug'      => 'normal',
			),
			array(
				'name'      => esc_html__( 'Large', 'mipro' ),
				'shortName' => esc_html__( 'L', 'mipro' ),
				'size'      => 36.5,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'mipro' ),
				'shortName' => esc_html__( 'XL', 'mipro' ),
				'size'      => 49.5,
				'slug'      => 'huge',
			),
		)
	);
	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html__( 'Primary', 'mipro' ),
				'slug'  => 'primary',
				'color' => esc_html( mipro_get_opt( 'kft_primary_color' ) ),
			),
			array(
				'name'  => esc_html__( 'Secondary', 'mipro' ),
				'slug'  => 'secondary',
				'color' => esc_html( mipro_get_opt( 'kft_secondary_color' ) ),
			),
			array(
				'name'  => esc_html__( 'Dark Gray', 'mipro' ),
				'slug'  => 'dark-gray',
				'color' => '#111',
			),
			array(
				'name'  => esc_html__( 'Light Gray', 'mipro' ),
				'slug'  => 'light-gray',
				'color' => '#767676',
			),
			array(
				'name'  => esc_html__( 'White', 'mipro' ),
				'slug'  => 'white',
				'color' => '#FFF',
			),
		)
	);
	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );
	/* Register theme location. */
	register_nav_menus(
		array(
			'primary'  => esc_html__( 'Primary Navigation', 'mipro' ),
			'vertical' => esc_html__( 'Vertical Navigation', 'mipro' ),
			'mobile'   => esc_html__( 'Mobile Navigation', 'mipro' ),
		)
	);

	$starter_content = array(
		'widgets' => array(
			'blog-sidebar'        => array(
				'text_business_info',
				'text_about',
			),

			'blog-detail-sidebar' => array(
				'text_business_info',
			),
		),
	);
	$starter_content = apply_filters( 'mipro_starter_content', $starter_content );
	add_theme_support( 'starter-content', $starter_content );
}

add_action( 'after_setup_theme', 'mipro_setup' );

/* * * Check if WooCommerce is Active ** */
if ( ! function_exists( 'mipro_is_woocommerce_activated' ) ) {
	function mipro_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

if ( ! function_exists( 'mipro_get_theme_info' ) ) {
	/**
	 * Get theme Info
	 *
	 * @param string $parameter Info.
	 */
	function mipro_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() ) {
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		}
		return $theme_info->get( $parameter );
	}
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**  Body open hook. */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Load all files
 */
require_once get_parent_theme_file_path( '/inc/includes.php' );

/* Install Required Plugins */
add_action( 'tgmpa_register', 'mipro_register_required_plugins' );

function mipro_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'               => 'Mipro Core',
			'slug'               => 'mipro-core',
			'source'             => get_parent_theme_file_path( '/inc/plugins/mipro-core.zip' ),
			'required'           => true,
			'version'            => '1.4.0',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'     => 'CMB2',
			'slug'     => 'cmb2',
			'required' => true,
		),
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'King Composer',
			'slug'     => 'kingcomposer',
			'required' => false,
		),
		array(
			'name'               => 'KC Pro',
			'slug'               => 'kc_pro',
			'source'             => get_parent_theme_file_path( '/inc/plugins/kc_pro.zip' ),
			'required'           => true,
			'version'            => '1.9.4',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'               => 'Revolution Slider',
			'slug'               => 'revslider',
			'source'             => 'http://demo.alura-studio.com/plugins/revslider.zip',
			'required'           => false,
			'version'            => '6.3.1',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => 'YITH WooCommerce Wishlist',
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false,
		),
		array(
			'name'     => 'YITH WooCommerce Compare',
			'slug'     => 'yith-woocommerce-compare',
			'required' => false,
		),
		array(
			'name'     => 'Mailchimp for WordPress',
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php', // Parent menu slug.
		'capability'   => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true, // Show admin notices or not.
		'dismissable'  => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true, // Automatically activate plugins after installation or not.
		'message'      => '', // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
