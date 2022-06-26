<?php
/**
 * Register sidebar
 * (c) Joyce
 */

if ( ! function_exists('mipro_get_list_sidebars') ) {
    function mipro_get_list_sidebars() {
        $sidebars = array(
            array(
                'name' => esc_html__( 'Blog Sidebar', 'mipro' ),
                'id' => 'blog-sidebar',
                'description' => esc_html__( 'Add widgets in your blog.', 'mipro' ),
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title-wrap"><h4 class="widget-title">',
                'after_title' => '</h4></div>',
            ),
            array(
                'name' => esc_html__( 'Blog Detail Sidebar', 'mipro' ),
                'id' => 'blog-detail-sidebar',
                'description' => esc_html__( 'Add widgets in your blog detail.', 'mipro' ),
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title-wrap"><h4 class="widget-title">',
                'after_title' => '</h4></div>',
            ),
            array(
                'name' => esc_html__( 'Product Category Sidebar', 'mipro' ),
                'id' => 'product-category-sidebar',
                'description' => esc_html__( 'Add widgets in shop and product category page.', 'mipro' ),
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title-wrap"><h4 class="widget-title">',
                'after_title' => '</h4></div>',
            ),
            array(
                'name' => esc_html__( 'Product Filters Area Content', 'mipro' ),
                'id' => 'product-filters-content',
                'description' => esc_html__( 'Add widgets in product filters content.', 'mipro' ),
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title-wrap"><h4 class="widget-title">',
                'after_title' => '</h4></div>',
            ),
            array(
                'name' => esc_html__( 'Product Detail Sidebar', 'mipro' ),
                'id' => 'product-detail-sidebar',
                'description' => esc_html__( 'Add widgets in product detail page.', 'mipro' ),
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title-wrap"><h4 class="widget-title">',
                'after_title' => '</h4></div>',
            ),
        );

        $custom_sidebars = mipro_get_custom_sidebar();
        if ( is_array( $custom_sidebars ) ) {
            foreach ( $custom_sidebars as $name ) {
                $sidebars[] = array(
                    'name' => '' . $name . '',
                    'id' => sanitize_title( $name ),
                    'class' => 'mipro_custom_sidebar',
                    'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<div class="widget-title-wrap"><h4 class="widget-title">',
                    'after_title' => '</h4></div>',
                );
            }
        }

        return $sidebars;
    }
}

if ( ! function_exists('mipro_get_footer_widget') ) {
    function mipro_get_footer_widget() {
        $footerwg = array(
            array(
                'name' => esc_html__( 'Footer Top', 'mipro' ),
                'id' => 'footer-top',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'description' => esc_html__( 'Add widgets in your footer.', 'mipro' ),
            ),
            array(
                'name' => esc_html__( 'Footer Middle', 'mipro' ),
                'id' => 'footer-middle',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'description' => esc_html__( 'Add widgets in your footer.', 'mipro' ),
            ),
            array(
                'name' => esc_html__( 'Footer Bottom', 'mipro' ),
                'id' => 'footer-bottom',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'description' => esc_html__( 'Add widgets in your footer.', 'mipro' ),
            ),
        );

        return $footerwg;
    }
}

function mipro_register_widget_area() {
    $mipro_default_sidebars = mipro_get_list_sidebars();
    $mipro_footer_widget = mipro_get_footer_widget();
    $sidebars = array_merge( $mipro_default_sidebars, $mipro_footer_widget );
    foreach ( $sidebars as $sidebar ) {
        register_sidebar( $sidebar );
    }
}
add_action('widgets_init', 'mipro_register_widget_area');

/**
* Get sidebars list for options
*/
if ( ! function_exists('mipro_get_sidebars') ) {
    function mipro_get_sidebars() {
        $mipro_default_sidebars = mipro_get_list_sidebars();
        $sidebars = array();
        if ( $mipro_default_sidebars ) {
            foreach ( $mipro_default_sidebars as $id => $sidebar ) {
                $sidebars[$sidebar['id']] = $sidebar['name'];
            }
        }
        return $sidebars;
    }
}

/**
 * Add Custom Sidebar
 */

if ( ! function_exists('mipro_add_sidebar_action') ) {
    function mipro_add_sidebar_action() {
        if (! wp_verify_nonce($_GET['_wpnonce_mipro_widgets'], 'mipro-add-sidebar-widgets') ) {
            die( 'Security check' );
        }

        if ( $_GET['mipro_sidebar_name'] == '' ) {
            die('Empty Name');
        }

        $option_name = 'mipro_custom_sidebars';
        if (! get_option($option_name) || get_option($option_name) == '' ) {
            delete_option($option_name);
        }

        $new_sidebar = $_GET['mipro_sidebar_name'];
        $result = mipro_add_sidebar( $new_sidebar );

        if ( $result ) {
            die( $result );
        } else {
            die('error');
        }

    }
}

if ( ! function_exists('mipro_add_sidebar') ) {
    function mipro_add_sidebar( $name ) {
        $option_name = 'mipro_custom_sidebars';
        $result = $result2 = false;
        if (get_option($option_name)) {
            $custom_sidebars = mipro_get_custom_sidebar();
            $custom_sidebars[] = trim($name);
            $result = update_option($option_name, $custom_sidebars);
        } else {
            $custom_sidebars[] = $name;
            $result2 = add_option($option_name, $custom_sidebars);
        }
        if ($result) {
            return 'Updated';
        } elseif ($result2) {
            return 'added';
        } else {
            die('error');
        }

    }
}

/**
 * Delete Custom sidebar
 */

if ( ! function_exists('mipro_delete_sidebar') ) {
    function mipro_delete_sidebar() {
        $option_name = 'mipro_custom_sidebars';
        $delete_sidebar = trim($_GET['mipro_sidebar_name']);

        if ( get_option( $option_name ) ) {
            $custom_sidebars = mipro_get_custom_sidebar();

            foreach ( $custom_sidebars as $key => $value ) {
                if ( $value == $delete_sidebar ) {
                    unset( $custom_sidebars[$key] );
                }
            }

            $result = update_option( $option_name, $custom_sidebars );
        }

        if ( $result ) {
            die('Deleted');
        } else {
            die('error');
        }

    }
}

/**
 * Get Custom sidebar
 */

if ( ! function_exists('mipro_get_custom_sidebar') ) {
    function mipro_get_custom_sidebar() {
        $option_name = 'mipro_custom_sidebars';
        return get_option( $option_name );
    }
}

/**
 * Add form Custom sidebar
 */

if ( ! function_exists('mipro_sidebar_form') ) {
    function mipro_sidebar_form() {
        ?>
        <form action="<?php echo esc_url( admin_url('widgets.php') ); ?>" method="post" id="mipro_add_sidebar_form">
         <h2><?php echo esc_html_e( 'Custom Sidebar', 'mipro' ); ?></h2>
         <?php wp_nonce_field('mipro-add-sidebar-widgets', '_wpnonce_mipro_widgets', false); ?>
         <input type="text" name="mipro_sidebar_name" id="mipro_sidebar_name" />
         <button type="submit" class="button-primary" value="add-sidebar"><?php esc_html_e( 'Add Sidebar', 'mipro' ); ?></button>
     </form>
     <?php

 }
}
add_action('sidebar_admin_page', 'mipro_sidebar_form', 30);
add_action('wp_ajax_mipro_add_sidebar', 'mipro_add_sidebar_action');
add_action('wp_ajax_mipro_delete_sidebar', 'mipro_delete_sidebar');
