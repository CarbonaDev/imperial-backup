<?php
/**
 * Option for Template
 *
 */

add_action('wp', 'mipro_template_controls');

function mipro_template_controls() {
    global $wp_query, $post, $mipro_page_options, $mipro_opt;

    /* Metaboxes Page Options */
    if ( is_page() || is_tax( get_object_taxonomies('product') ) || is_post_type_archive('product') ) {
        if ( is_page() ) {
            $page_id = $post->ID;
        }
        if ( is_tax( get_object_taxonomies('product') ) || is_post_type_archive('product') ) {
            $page_id = get_option('woocommerce_shop_page_id', 0);
        }
        $post_custom = get_post_custom($page_id);
        if ( ! is_array( $post_custom ) ) {
            $post_custom = array();
        }
        
        foreach ( $post_custom as $key => $value ) {
            if ( isset( $value[0] ) ) {
                $mipro_page_options[$key] = $value[0];
            }
        }
        $default = array(
            'kft_layout' => 'default',
            'kft_page_layout' => 'full-width',
            'kft_left_sidebar' => '',
            'kft_right_sidebar' => '',
            'kft_header_top_bar' => 0,
            'kft_header_top_bar_color' => '',
            'kft_header_top_bar_bg' => '',
            'kft_header_layout' => 'default',
            'kft_header_overlap' => 0,
            'kft_header_color' => '',
            'kft_header_text_color' => 'default',
            'kft_menu_id' => 0,
            'kft_breadcrumb_layout' => 'default',
            'kft_bg_breadcrumbs' => '',
            'kft_logo' => '',
            'kft_breadcrumbs' => 0,
            'kft_page_title' => 0,
            'kft_page_slider' => 0,
            'kft_page_slider_position' => 'before_main_content',
            'kft_rev_slider' => 0,
        );

        $mipro_page_options = mipro_get_custom_field( $default, $mipro_page_options );

        if ( $mipro_page_options['kft_layout'] != 'default' ) {
            $mipro_opt['kft_layout'] = $mipro_page_options['kft_layout'];
        }

        if ( $mipro_page_options['kft_header_top_bar'] ) {
            $mipro_opt['kft_header_top_bar'] = 0;
        }

        if ( $mipro_page_options['kft_header_top_bar_bg'] ) {
            $mipro_opt['kft-top-bar-bg']['rgba'] = $mipro_page_options['kft_header_top_bar_bg'];
        }

        if ( $mipro_page_options['kft_header_top_bar_color'] ) {
            $mipro_opt['kft-top-bar-color'] = $mipro_page_options['kft_header_top_bar_color'];
        }

        if ( $mipro_page_options['kft_header_layout'] != 'default' ) {
            $mipro_opt['kft_header_layout'] = $mipro_page_options['kft_header_layout'];
        }

        if ( $mipro_page_options['kft_page_title'] ) {
            $mipro_opt['kft_page_title'] = 0;
        }

        if ( $mipro_page_options['kft_breadcrumbs'] ) {
            $mipro_opt['kft_breadcrumbs'] = 0;
        }

        if ( $mipro_page_options['kft_breadcrumb_layout'] != 'default' ) {
            $mipro_opt['kft_breadcrumb_layout'] = $mipro_page_options['kft_breadcrumb_layout'];
        }

        if ( trim( $mipro_page_options['kft_bg_breadcrumbs'] ) != '' ) {
            $mipro_opt['kft_bg_breadcrumbs']['background-image'] = $mipro_page_options['kft_bg_breadcrumbs'];
        }

        if ( trim( $mipro_page_options['kft_logo'] ) != '' ) {
            $mipro_opt['kft_logo']['url'] = $mipro_page_options['kft_logo'];
        }

        if ( $mipro_page_options['kft_menu_id'] ) {
            add_filter('wp_nav_menu_args', 'mipro_filter_wp_nav_menu_args');
        }
    }

    /* Archive - Category product */
    if ( is_tax( get_object_taxonomies('product') ) || is_post_type_archive('product') ) {
        mipro_set_header_breadcrumb_layout_woocommerce_page('shop');

        add_action('wp_enqueue_scripts', 'mipro_grid_list_desc_style', 1000);

        if ( is_tax('product_cat') ) {
            $term = $wp_query->queried_object;
            if ( ! empty( $term->term_id ) ) {
                $bg_breadcrumbs_id = get_term_meta( $term->term_id, 'bg_breadcrumbs_id', true );
                $layout = get_term_meta( $term->term_id, 'layout', true );
                $left_sidebar = get_term_meta( $term->term_id, 'left_sidebar', true );
                $right_sidebar = get_term_meta( $term->term_id, 'right_sidebar', true );

                if ( $bg_breadcrumbs_id !== false ) {
                    $mipro_opt['kft_bg_breadcrumbs']['background-image'] = $bg_breadcrumbs_id;
                }

                if ( $layout != '' ) {
                    $mipro_opt['kft_prod_cat_layout'] = $layout;
                }

                if ( $layout != '' && $left_sidebar != '' ) {
                    $mipro_opt['kft_prod_cat_left_sidebar'] = $left_sidebar;
                }

                if ( $layout != '' && $right_sidebar != '' ) {
                    $mipro_opt['kft_prod_cat_right_sidebar'] = $right_sidebar;
                }
            }
        }

        if ( isset($mipro_opt['kft_prod_cat_layout']) && $mipro_opt['kft_prod_cat_layout'] == 'full-width' ) {
            $mipro_opt['kft_show_sidebar_button'] = 0;
        }
    }

    /* Single Post */
    if ( is_singular( 'post' ) ) {

        $mipro_opt['kft_page_title'] = $mipro_opt['kft_blog_details_title'];
        $post_layout = get_post_meta( $post->ID, 'kft_blog_details_layout', true );
        $post_sidebar_left = get_post_meta( $post->ID, 'kft_blog_details_left_sidebar', true );
        $post_sidebar_right = get_post_meta( $post->ID, 'kft_blog_details_right_sidebar', true );
        $bg_breadcrumbs = get_post_meta( $post->ID, 'kft_bg_breadcrumbs', true );

        if ( $post_layout != '' ) {
            $mipro_opt['kft_blog_details_layout'] = $post_layout;
        }
        if ( $post_layout != '' && $post_sidebar_left != '' ) {
            $mipro_opt['kft_blog_details_left_sidebar'] = $post_sidebar_left;
        }

        if ( $post_layout != '' && $post_sidebar_right != '' ) {
            $mipro_opt['kft_blog_details_right_sidebar'] = $post_sidebar_right;
        }

        if ( trim( $bg_breadcrumbs ) != '' ) {
            $mipro_opt['kft_bg_breadcrumbs']['background-image'] = $bg_breadcrumbs;
        }

        if ( get_post_meta( $post->ID, 'kft_blog_details_sharing', true ) ) {
            $mipro_opt['kft_blog_details_sharing'] = 0;
        }

        if ( get_post_meta( $post->ID, 'kft_blog_details_related_posts', true ) ) {
            $mipro_opt['kft_blog_details_related_posts'] = 0;
        }

        if ( get_post_meta( $post->ID, 'kft_blog_details_comment_form', true ) ) {
            $mipro_opt['kft_blog_details_comment_form'] = 0;
        }
    }

    /* Single product */
    if ( is_singular( 'product' ) ) {
        $mipro_opt['kft_page_title'] = $mipro_opt['kft_prod_title'];
        $prod_layout = get_post_meta( $post->ID, 'kft_prod_layout', true );
        $prod_sidebar_left = get_post_meta( $post->ID, 'kft_prod_left_sidebar', true );
        $prod_sidebar_right = get_post_meta( $post->ID, 'kft_prod_right_sidebar', true );
        if ( $prod_layout != '' ) {
            $mipro_opt['kft_prod_layout'] = $prod_layout;
        }

        if ( $prod_layout != '' && $prod_sidebar_left != '' ) {
            $mipro_opt['kft_prod_left_sidebar'] = $prod_sidebar_left;
        }

        if ($prod_layout != '' && $prod_sidebar_right != '') {
            $mipro_opt['kft_prod_right_sidebar'] = $prod_sidebar_right;
        }

        if ( get_post_meta( $post->ID, 'kft_prod_related', true ) ) {
            $mipro_opt['kft_prod_related'] = 0;
        }

        if ( get_post_meta( $post->ID, 'kft_prod_thumbnails_style', true ) ) {
            $mipro_opt['kft_prod_thumbnails_style'] = get_post_meta( $post->ID, 'kft_prod_thumbnails_style', true );
        }

        if ( get_post_meta( $post->ID, 'kft_show_size_chart', true ) ) {
            $mipro_opt['kft_show_prod_size_chart'] = 1;
        }

        if ( get_post_meta( $post->ID, 'kft_prod_size_chart', true ) ) {
            $mipro_opt['kft_prod_size_chart']['url'] = get_post_meta( $post->ID, 'kft_prod_size_chart', true );
        }

        if ( ! $mipro_opt['kft_prod_thumbnail'] ) {
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
        }

        if ( ! $mipro_opt['kft_prod_label'] ) {
            remove_action('kft_before_product_image', 'mipro_product_label', 10);
        }

        if ( ! $mipro_opt['kft_product_zoom_button'] || ! $mipro_opt['kft_product_lightbox'] ) {
            remove_action('kft_before_product_image', 'mipro_template_single_product_zoom_button', 20);
        }

        if ( $mipro_opt['kft_prod_title'] && isset( $mipro_opt['kft_prod_title_in_content'] ) && $mipro_opt['kft_prod_title_in_content'] ) {
            $mipro_opt['kft_prod_title'] = 0;
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 1);
        }

        if ( ! $mipro_opt['kft_prod_rating'] ) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 2);
        }

        if ( ! $mipro_opt['kft_prod_availability'] ) {
            add_filter('woocommerce_get_availability', '__return_empty_string', 1, 2);
        }

        if ( ! $mipro_opt['kft_prod_cat_grid_desc'] ) {
            remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_short_description', 40);
        }

        if ( ! $mipro_opt['kft_prod_price'] ) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 3);
            remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
        }

        if ( ! $mipro_opt['kft_prod_excerpt'] ) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        }

        if ( ! $mipro_opt['kft_prod_count_down'] ) {
            remove_action('woocommerce_single_product_summary', 'kft_template_loop_time_deals', 4);
        }

        if ( ! $mipro_opt['kft_prod_add_to_cart'] || $mipro_opt['kft_enable_catalog_mode'] ) {
            $terms = get_the_terms( $post->ID, 'product_type' );
            $product_type = ! empty( $terms ) ? sanitize_title( current($terms)->name ) : 'simple';
            if ( $product_type != 'variable' ) {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            } else {
                remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
            }
        }

        if ( ! $mipro_opt['kft_prod_sharing'] ) {
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 70);
        }

        if ( ! $mipro_opt['kft_show_prod_size_chart'] ) {
            remove_action('woocommerce_single_product_summary', 'mipro_template_product_size_chart_button', 80);
        }

        if ( ! $mipro_opt['kft_prod_upsells'] ) {
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
        }

        if ( ! $mipro_opt['kft_prod_related'] ) {
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        }

        if ( isset( $mipro_opt['kft_prod_tabs_position'] ) && $mipro_opt['kft_prod_tabs_position'] == 'inside_summary' ) {
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
            add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 50);
        }

        /* Breadcrumb */
        $bg_breadcrumbs = get_post_meta( $post->ID, 'kft_bg_breadcrumbs', true );
        if ( ! empty( $bg_breadcrumbs ) ) {
            $mipro_opt['kft_bg_breadcrumbs']['background-image'] = $bg_breadcrumbs;
        }

        if ( wp_is_mobile() ) {
            $mipro_opt['kft_prod_thumbnails_style'] = 'horizontal';
            $mipro_opt['kft_prod_style_tabs'] = 'accordion';
        }

    }

    /* WooCommerce - Other pages */
    if ( mipro_is_woocommerce_activated() ) {
        if ( is_cart() ) {
            mipro_set_header_breadcrumb_layout_woocommerce_page('cart');
        }

        if ( is_checkout() ) {
            mipro_set_header_breadcrumb_layout_woocommerce_page('checkout');
        }

        if ( is_account_page() ) {
            mipro_set_header_breadcrumb_layout_woocommerce_page('myaccount');
        }
        mipro_remove_woocommerce_hook();
    }
}

function mipro_remove_woocommerce_hook() {
    global $mipro_opt;

    if ( ! $mipro_opt['kft_prod_cat_thumbnail'] ) {
        remove_action('woocommerce_before_shop_loop_item_title', 'mipro_product_thumbnail', 10);
    }
    if ( ! $mipro_opt['kft_prod_cat_label'] ) {
        remove_action('woocommerce_after_shop_loop_item_title', 'mipro_product_label', 1);
    }
    if ( ! $mipro_opt['kft_prod_cat_cat'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_categories', 25);
    }
    if ( ! $mipro_opt['kft_prod_cat_title'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_title', 20);
    }
    if ( ! $mipro_opt['kft_prod_cat_sku'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_sku', 30);
    }
    if ( ! $mipro_opt['kft_prod_cat_rating'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 21);
    }
    if ( ! $mipro_opt['kft_prod_cat_price'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
    }
    if ( ! $mipro_opt['kft_prod_cat_add_to_cart'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'mipro_template_loop_add_to_cart', 70);
        remove_action('woocommerce_after_shop_loop_item_title', 'mipro_template_loop_add_to_cart', 10006);
    }
    if ( ! $mipro_opt['kft_prod_cat_grid_desc'] ) {
        remove_action('woocommerce_after_shop_loop_item', 'mipro_template_product_short_description', 40);
    }
}

function mipro_filter_wp_nav_menu_args( $args ) {
    global $post;
    if ( is_page() && ! is_admin() && ! empty($args['theme_location']) && $args['theme_location'] == 'primary' ) {
        $menu = get_post_meta($post->ID, 'kft_menu_id', true);
        if ( $menu ) {
            $args['menu'] = $menu;
        }
    }
    return $args;
}

function mipro_grid_list_desc_style() {
    $custom_css = ".products.list .short-description.list{display: inline-block !important;}";
    $custom_css .= ".products.grid .short-description.grid{display: inline-block !important;}";
    wp_add_inline_style('mipro-default', $custom_css);
}

function mipro_set_header_breadcrumb_layout_woocommerce_page( $page = 'shop' ) {
    global $mipro_opt;
    /* Header Layout */
    $header_layout = get_post_meta( wc_get_page_id( $page ), 'kft_header_layout', true );
    if ( $header_layout != 'default' && $header_layout != '' ) {
        $mipro_opt['kft_header_layout'] = $header_layout;
    }

    /* Breadcrumb Layout */
    $breadcrumb_layout = get_post_meta( wc_get_page_id( $page ), 'kft_breadcrumb_layout', true );
    if ( $breadcrumb_layout != 'default' && $breadcrumb_layout != '' ) {
        $mipro_opt['kft_breadcrumb_layout'] = $breadcrumb_layout;
    }
}
