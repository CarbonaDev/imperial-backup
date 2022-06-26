<?php
/**
 * Include file Theme
 * (c) Joyce
 */

class Mipro_Theme_File {

    public $files_include = array();
    public $woocommerce_files_include = array();
    public $third_party_plugins = array();
    public $widget_file_include = array();
    public $kc_file = array();
    public $import = array();

    function __construct() {

        $this->files_include = array( 'sidebar', 'default-options', 'theme-options', 'theme-head', 'helpers', 'controls', 'walkers' );

        $this->third_party_plugins = array( 'tgm-plugin-activation/class-tgm-plugin-activation', 'merlin/vendor/autoload', 'merlin/class-merlin' );

        $this->kc_file = array( 'kc-map' );

        $this->import = array( 'merlin-config', 'merlin-filters' );

        $this->woocommerce_files_include = array( 'functions', 'quickview', 'hooks' );

        $this->widget_file_include = array( 'mega-menu', 'mailchimp-subscription', 'products', 'blogs', 'recent-comments', 'product-categories', 'product-filter-by-color', 'about-me' );

        $this->_third_party_plugins();
        $this->_include_files();
        $this->_widget_file();
        $this->_woocommerce_files();

        if ( class_exists( 'KingComposer' ) ) {
            $this->_kc_element();
        }

        if ( is_admin() ) {
            $this->_import();
            $this->_include_admin_files();
        }

    }

    /**
     * Widget forder
     *
     */
    function _widget_file() {

        foreach ( $this->widget_file_include as $file ) {
            $file_path = get_theme_file_path( '/inc/widgets/' . esc_html($file) . '.php' );
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            }
        }

    }

    /**
     * Include files fron inc/ folder
     *
     */
    function _include_files() {

        foreach ( $this->files_include as $file ) {
            $file_path = get_theme_file_path( '/inc/' . esc_html($file) . '.php' );
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            }
        }

    }

    /**
     * Include files from woocommerce/ folder
     *
     */
    function _woocommerce_files() {

        foreach ( $this->woocommerce_files_include as $file ) {
            $file_path = get_theme_file_path( '/inc/woocommerce/' . esc_html($file) . '.php' );
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            }
        }

    }

    /**
     * Include files in admin area
     *
     */
    function _include_admin_files() {

        require_once get_parent_theme_file_path( '/inc/custom-metaboxes.php' );

    }

    /**
     * Register 3d party plugins
     *
     */
    function _third_party_plugins() {

        foreach ( $this->third_party_plugins as $file ) {
            $file_path = get_parent_theme_file_path( '/inc/third-party/' . esc_html($file) . '.php' );
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            }
        }

    }

    /**
     * KingComposer kc-map
     *
     */
    function _kc_element() {

        foreach ( $this->kc_file as $file ) {
            $file_path = get_parent_theme_file_path( '/inc/kc-element/' . esc_html($file) . '.php' );
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            }
        }

    }
    
    /**
     * Import files
     *
     */
    function _import() {

        foreach ( $this->import as $file ) {
            $file_path = get_parent_theme_file_path( '/inc/import/' . esc_html($file) . '.php' );
            if ( file_exists( $file_path ) ) {
                require_once $file_path;
            }
        }

    }

}
new Mipro_Theme_File();
