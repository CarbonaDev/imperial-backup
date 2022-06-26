<?php
class Mipro_Custom_Shortcodes {

    function __construct() {

        add_filter('the_content', array($this, 'remove_extra_p_tag'));
        add_filter('widget_text', array($this, 'remove_extra_p_tag'));

        add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
        require_once 'kc_shortcodes.php';
    }

    function remove_extra_p_tag($content) {

        $block = join("|", array('kft_button'));
        /* opening tag */
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

        /* closing tag */
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);

        return $rep;
    }

    function register_scripts() {
        $gmap_api_key = ! empty( mipro_get_opt('kft_gmap_api_key') ) ? mipro_get_opt('kft_gmap_api_key') : '';
        wp_enqueue_script( 'gmap-api', 'https://maps.google.com/maps/api/js?key=' . $gmap_api_key . '', array(), '', false );
    }
}
new Mipro_Custom_Shortcodes();
?>