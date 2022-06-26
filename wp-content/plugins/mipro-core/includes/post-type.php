<?php

/*** Mipro Brands ***/
if (!class_exists('Mipro_Brands')) {
    class Mipro_Brands {
        public $post_type;

        function __construct() {
            $this->post_type = 'kft_brand';

            add_action('init', array($this, 'register_post_type'));
            add_action('init', array($this, 'register_taxonomy'));

        }

        function register_post_type() {
            $labels = array(
                'name' => esc_html_x('Brands', 'post type general name', 'mipro-core'),
                'singular_name' => esc_html_x('Brand', 'post type singular name', 'mipro-core'),
                'add_new' => esc_html_x('Add New', 'logo', 'mipro-core'),
                'add_new_item' => esc_html__('Add New Brand', 'mipro-core'),
                'edit_item' => esc_html__('Edit Brand', 'mipro-core'),
                'new_item' => esc_html__('New Brand', 'mipro-core'),
                'all_items' => esc_html__('All Brands', 'mipro-core'),
                'view_item' => esc_html__('View Brand', 'mipro-core'),
                'search_items' => esc_html__('Search Brands', 'mipro-core'),
                'not_found' => esc_html__('No Brands Found', 'mipro-core'),
                'not_found_in_trash' => esc_html__('No Brands Found In Trash', 'mipro-core'),
                'parent_item_colon' => '',
                'menu_name' => esc_html__('Brands', 'mipro-core'),
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => str_replace('kft_', '', $this->post_type)),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => array('title', 'thumbnail'),
                'menu_position' => 5,
                'menu_icon' => '',
                'menu_icon' => 'dashicons-images-alt',
            );
            register_post_type($this->post_type, $args);
        }

        function register_taxonomy() {
            $args = array(
                'labels' => array(
                    'name' => esc_html_x('Categories', 'taxonomy general name', 'mipro-core'),
                    'singular_name' => esc_html_x('Category', 'taxonomy singular name', 'mipro-core'),
                    'search_items' => esc_html__('Search Categories', 'mipro-core'),
                    'all_items' => esc_html__('All Categories', 'mipro-core'),
                    'parent_item' => esc_html__('Parent Category', 'mipro-core'),
                    'parent_item_colon' => esc_html__('Parent Category:', 'mipro-core'),
                    'edit_item' => esc_html__('Edit Category', 'mipro-core'),
                    'update_item' => esc_html__('Update Category', 'mipro-core'),
                    'add_new_item' => esc_html__('Add New Category', 'mipro-core'),
                    'new_item_name' => esc_html__('New Category Name', 'mipro-core'),
                    'menu_name' => esc_html__('Categories', 'mipro-core'),
                )
                , 'hierarchical' => true
                , 'show_ui' => true
                , 'show_admin_column' => true
                , 'query_var' => true,
            );
            register_taxonomy('kft_brand_cat', $this->post_type, $args);
        }
    }
}
new Mipro_Brands();

/*** Mipro Footer ***/
if (!class_exists('Mipro_Footer')) {
    class Mipro_Footer {
        public $post_type;

        function __construct() {
            $this->post_type = 'kft_footer';
            add_action('init', array($this, 'register_post_type'));
        }

        function register_post_type() {
            $labels = array(
                'name' => esc_html_x('Footer Builder', 'post type general name', 'mipro-core'),
                'singular_name' => esc_html_x('Footer Builder', 'post type singular name', 'mipro-core'),
                'add_new' => esc_html_x('Add New', 'logo', 'mipro-core'),
                'add_new_item' => esc_html__('Add New', 'mipro-core'),
                'edit_item' => esc_html__('Edit Footer Builder', 'mipro-core'),
                'new_item' => esc_html__('New Footer', 'mipro-core'),
                'all_items' => esc_html__('All Footer Builder', 'mipro-core'),
                'view_item' => esc_html__('View Footer Builder', 'mipro-core'),
                'search_items' => esc_html__('Search Footer Builder', 'mipro-core'),
                'not_found' => esc_html__('No Footer Found', 'mipro-core'),
                'not_found_in_trash' => esc_html__('No Footer Found In Trash', 'mipro-core'),
                'parent_item_colon' => '',
                'menu_name' => esc_html__('Footer Builder', 'mipro-core'),
            );
            $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => $this->post_type),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => array('title', 'editor'),
                'menu_position' => 5,
                'menu_icon' => 'dashicons-menu',
            );
            register_post_type($this->post_type, $args);
        }
    }
}
new Mipro_Footer();

?>