<?php
/** Remove redirect wizard */
add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );

/* Remove woocommerce hook */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

/* * * Shop - Category ** */
add_action('woocommerce_before_shop_loop_item_title', 'mipro_product_thumbnail', 10);
add_action('woocommerce_after_shop_loop_item_title', 'mipro_product_label', 1);
add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_categories', 25);
if (mipro_get_opt('kft_prod_cat_rating')) {
   add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 21);
}

add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_title', 20);
add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_sku', 30);
add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_short_description', 40);
add_action('woocommerce_after_shop_loop_item', 'mipro_template_product_short_description_listview', 60);
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 50);
add_action('woocommerce_after_shop_loop_item', 'mipro_template_loop_add_to_cart', 70);
add_filter('loop_shop_per_page', 'mipro_change_products_per_page_shop');

/* Single page */
add_action('kft_before_product_image', 'mipro_product_label', 10);
add_action('kft_before_product_image', 'mipro_template_single_product_zoom_button', 20);
add_action('kft_before_product_image', 'mipro_template_single_product_video_button', 30);
add_action('kft_before_product_image', 'mipro_product_video_360', 40);

add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 1);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 2);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 3);
add_action('woocommerce_single_product_summary', 'mipro_template_product_size_chart_button', 38);
add_action('woocommerce_single_product_summary', 'mipro_template_single_meta', 60);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 70);

add_action('woocommerce_share', 'mipro_template_product_social_sharing', 9);

if ( function_exists('kft_template_loop_time_deals') ) {
    add_action('woocommerce_single_product_summary', 'kft_template_loop_time_deals',4);
}

add_filter('woocommerce_available_variation', 'mipro_variable_product_price_filter', 10, 3);
add_filter('woocommerce_product_description_heading', '__return_empty_string');
add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');

add_filter('woocommerce_output_related_products_args', 'mipro_output_related_products_args_filter');

if ( ! is_admin() ) {
    /* Fix for WooCommerce Tab Manager plugin */
    add_filter('woocommerce_product_tabs', 'mipro_product_remove_tabs', 999);
    add_filter('woocommerce_product_tabs', 'mipro_add_product_custom_tab', 90);
}
/* * * End Product ** */

function mipro_product_label() {

    global $product, $post;
    $out_of_stock = false;
    if ( ! $product->is_in_stock() && ! is_product() ) {
        $out_of_stock = true;
    }
    ?>
    <div class="product-labels">
        <?php

        /* Sale label */
        if ( $product->is_on_sale() && ! $out_of_stock ) { 
            $percentage = '';

            if ( $product->get_type() == 'variable' ) {

                $available_variations = $product->get_variation_prices();
                $max_percentage = 0;

                foreach ( $available_variations['regular_price'] as $key => $regular_price ) {
                    $sale_price = $available_variations['sale_price'][$key];

                    if ( $sale_price < $regular_price ) {
                        $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

                        if ( $percentage > $max_percentage ) {
                            $max_percentage = $percentage;
                        }
                    }
                }

                $percentage = $max_percentage;
            } elseif ( $product->get_type() == 'simple' || $product->get_type() == 'external' ) {
                $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
            }

            if ( $percentage && mipro_get_opt('kft_product_sale_percentage') ) {
                echo '<span class="onsale percent">-' . $percentage . '%' . '</span>';
            } else {
                echo '<span class="onsale">' . esc_html__('Sale', 'mipro') . '</span>';
            }

        }

        /* Hot label */
        if ( $product->is_featured() && ! $out_of_stock && mipro_get_opt('kft_product_feature_label') ) {
            echo '<span class="featured">' . esc_html__('Hot', 'mipro') . '</span>';
        }

        /* Out of stock */
        if ( $out_of_stock && mipro_get_opt('kft_product_out_of_stock_label') ) {
            echo '<span class="out-of-stock">' . esc_html__('Sold out', 'mipro') . '</span>';
        }
        ?>
    </div>
    <?php
}

function mipro_product_thumbnail() {
    global $product;
    $back_image = ( (int) mipro_get_opt('kft_effect_product') == 0 ) ? false : true;
    $back_image_style = mipro_get_opt('kft_effect_hover_product_img');

    $image_size = apply_filters( 'kft_loop_product_thumbnail', 'woocommerce_thumbnail' );
    $attachment_ids = $product->get_gallery_image_ids();

    if ( ! is_array($attachment_ids) || ( is_array( $attachment_ids ) && count( $attachment_ids ) == 0) ) {
        $back_image = false;
    }

    echo woocommerce_get_product_thumbnail( $image_size );
    if ( $back_image ) {
        echo '<span class="hover-image has-hover image-hover-' . esc_attr( $back_image_style ) . '">';
        echo wp_get_attachment_image( $attachment_ids[0], $image_size, 0, array( 'class' => 'product-hover-image' ) );
        echo '</span>';
    }
}

function mipro_template_product_title() {
    echo '<h3 class="product-title product-name">';
    echo '<a href="' . esc_url( get_the_permalink() ) . '">' . esc_html( get_the_title() ) . '</a>';
    echo '</h3>';
}

function mipro_template_loop_add_to_cart() {

    if ( mipro_get_opt('kft_enable_catalog_mode') ) {
        return;
    }

    echo '<div class="kft-add-to-cart add-to-cart">';
    woocommerce_template_loop_add_to_cart();
    echo '</div>';
}

function mipro_template_product_sku() {
    global $product, $post;
    echo '<span class="product-sku">' . esc_attr( $product->get_sku() ) . '</span>';
}

function mipro_template_product_short_description() {
    global $product, $post;
    $grid_limit_words = absint( mipro_get_opt('kft_prod_cat_grid_desc_words') );
    $show_grid_desc = mipro_get_opt('kft_prod_cat_grid_desc');

    if ( empty( $post->post_excerpt ) ) {
        return;
    }

    if ( ! ( is_tax( get_object_taxonomies('product') ) || is_post_type_archive('product') ) ) : ?>
        <div class="short-description">
            <?php mipro_the_excerpt_max_words( $grid_limit_words, true, '', true ); ?>
        </div>

        <?php elseif ( $show_grid_desc ) : ?>
          <div class="short-description grid" style="<?php echo mipro_get_opt('kft_enable_grid_list') ? 'display: none' : ''; ?>" >
            <?php mipro_the_excerpt_max_words( $grid_limit_words, true, '', true ); ?>
        </div>
        <?php
    endif;
}

function mipro_template_product_short_description_listview() {
    global $product, $post;
    $list_limit_words = absint( mipro_get_opt('kft_prod_cat_list_desc_words') );
    $show_list_desc = mipro_get_opt('kft_prod_cat_list_desc');
    $is_archive = is_tax( get_object_taxonomies('product') ) || is_post_type_archive('product');
    if ( $show_list_desc && $is_archive ) : ?>
        <div class="short-description list" style="display: none" >
            <?php mipro_the_excerpt_max_words( $list_limit_words, true, '', true ); ?>
        </div>
        <?php
    endif;
}

function mipro_template_product_categories() {
    global $product;
    if(mipro_get_opt('kft_prod_cat_cat')):
     ?>
    
    <div class="product-categories">
        <?php echo wc_get_product_category_list( $product->get_id(), ', ' ); ?>
    </div>

    <?php
endif;
}

function mipro_change_products_per_page_shop() {
    $per_page = 12;
    $get_per_page = mipro_get_products_per_page();
    if ( is_numeric( $get_per_page ) ) {
        $per_page = $get_per_page;
    }
    return $per_page;
}

add_action('woocommerce_before_shop_loop', 'mipro_products_per_page_select', 20);
if( ! function_exists('mipro_products_per_page_select') ) {
    function mipro_products_per_page_select() {
        global $wp_query;

        $link = '';
        $cat = '';
        $cat = $wp_query->get_queried_object();
        $per_page_options = mipro_get_opt('kft_per_page_options');

        $products_per_page_options = ( ! empty($per_page_options) ) ? explode(',', $per_page_options) : array(12,24,36,-1); ?>

        <div class="kft-products-per-page">
            <span><?php esc_html_e( 'Show: ', 'mipro' ); ?></span>
            <div class="per-page-options">
               
               
                    <?php foreach ( $products_per_page_options as $key => $value ) : ?>
                        <span>
                            <a href="<?php echo add_query_arg( 'kft_per_page', $value, mipro_shop_page_link() ); ?>" class="kft-per-page-options <?php echo esc_attr( ( $value == mipro_get_products_per_page() ) ? 'chosen' : '' ); ?>">
                                <span><?php
                                $text = '%s';
                                esc_html( printf( $text, $value == -1 ? esc_html__( 'All', 'mipro' ) : $value ) );
                                ?></span>
                            </a>
                        </span>
                    <?php endforeach; ?>
                
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists('mipro_get_products_per_page') ) {
    function mipro_get_products_per_page() {
        if( ! class_exists('WC_Session_Handler') ) {
            return;
        } 
        $s = new WC_Session_Handler(); 

        if ( isset( $_REQUEST['kft_per_page'] ) ) {
            return intval( $_REQUEST['kft_per_page'] );
        }
        elseif ( $s->__isset( 'products_per_page' ) ) {
            return intval( $s->__get( 'products_per_page' ) );
        }
        else {
            return intval( mipro_get_opt('kft_prod_per_page') );
        }
    }
}


if ( ! function_exists('mipro_products_per_page_action') ) {
    add_action( 'init', 'mipro_products_per_page_action', 100 );
    function mipro_products_per_page_action() {
        if ( isset( $_REQUEST['kft_per_page'] ) ) {
            if ( ! class_exists('WC_Session_Handler') ) {
                return;
            } 
            $s = new WC_Session_Handler(); 
            $s->set( 'products_per_page', intval( $_REQUEST['kft_per_page'] ) );
        }
    }
}

if ( ! function_exists( 'mipro_shop_page_link' ) ) {
    function mipro_shop_page_link() {
        if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
            $link = home_url();
        } elseif ( is_shop() ) {
            $link = get_permalink( wc_get_page_id( 'shop' ) );
        } elseif ( is_product_category() ) {
            $link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
        } elseif ( is_product_tag() ) {
            $link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
        } else {
            $queried_object = get_queried_object();
            $link = get_term_link( $queried_object->slug, $queried_object->taxonomy );
        }

        // Min/Max.
        if ( isset( $_GET['min_price'] ) ) {
            $link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
        }

        if ( isset( $_GET['max_price'] ) ) {
            $link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
        }

        // Order by.
        if ( isset( $_GET['orderby'] ) ) {
            $link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
        }

        /**
         * Search Arg.
         * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
         */
        if ( get_search_query() ) {
            $link = add_query_arg( 's', rawurlencode(  wp_specialchars_decode( get_search_query() ) ), $link );
        }

        // Post Type Arg.
        if ( isset( $_GET['post_type'] ) ) {
            $link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );
        }

        // Min Rating Arg.
        if ( isset( $_GET['rating_filter'] ) ) {
            $link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
        }

        // All current filters.
        if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.Found, WordPress.CodeAnalysis.AssignmentInCondition.Found
            foreach ( $_chosen_attributes as $name => $data ) {
                $filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
                if ( ! empty( $data['terms'] ) ) {
                    $link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
                }
                if ( 'or' === $data['query_type'] ) {
                    $link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
                }
            }
        }

        return $link;
    }
}

add_action('woocommerce_before_shop_loop', 'mipro_gridlist_toggle_button', 40);
function mipro_gridlist_toggle_button() {

    if ( ! mipro_get_opt('kft_enable_grid_list') ) {
        return;
    } ?>

    <nav class="grid_list_nav">
        <a href="#" id="grid" title="<?php esc_attr_e( 'Grid view', 'mipro' ); ?>">&#8862; <span><?php esc_html_e( 'Grid view', 'mipro' ); ?></span></a><a href="#" id="list" title="<?php esc_attr_e( 'List view', 'mipro' ); ?>">&#8863; <span><?php esc_html_e( 'List view', 'mipro' ); ?></span></a>
    </nav>

    <?php
}

/* * * End Shop - Category ** */

/* * * Single Product * * */
function mipro_template_single_product_zoom_button() {
    ?>
    <div class="product-zoom-button"><a href="#"><span><?php echo esc_html_e( 'Zoom', 'mipro' ); ?></span></a></div>
    <?php
}

function mipro_template_single_product_video_button() {
    global $product;
    $video_url = get_post_meta( $product->get_id(), 'kft_prod_video_url', true );
    if ( ! empty( $video_url ) ) {
        echo '<a class="kft-single-video kft-video-lightbox" href="' . esc_url( $video_url ) . '"></a>';
    }
}

function mipro_template_single_navigation() {
    $next = get_next_post();
    $prev = get_previous_post();

    $next = ( ! empty( $next ) ) ? wc_get_product( $next->ID ) : false;
    $prev = ( ! empty( $prev ) ) ? wc_get_product( $prev->ID ) : false;
    ?>
    <div class="kft-nav-product">
        <?php if ( ! empty( $prev ) ) : ?>
            <a href="<?php echo esc_url( $prev->get_permalink() ); ?>" class="prev">
                <div class="nav-product prev-product">
                    <div class="product-image">
                        <?php echo wp_kses( $prev->get_image(), array( 'img' => array( 'class' => true, 'width' => true, 'height' => true, 'src' => true, 'alt' => true, 'data-src' => true ) ) ); ?>
                    </div>
                    <div class="product-description">
                        <span class="product-title"><?php echo esc_html( $prev->get_title() ); ?></span>
                        <span class="price"><?php echo wp_kses_post( $prev->get_price_html() ); ?></span>
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if ( ! empty( $next ) ) : ?>
            <a href="<?php echo esc_url( $next->get_permalink() ); ?>" class="next">
                <div class="nav-product next-product">
                    <div class="product-image">
                        <?php echo wp_kses( $next->get_image(), array( 'img' => array( 'class' => true, 'width' => true, 'height' => true, 'src' => true, 'alt' => true, 'data-src' => true ) ) ); ?>
                    </div>
                    <div class="product-description">
                        <span class="product-title"><?php echo esc_html( $next->get_title() ); ?></span>
                        <span class="price"><?php echo wp_kses_post( $next->get_price_html() ); ?></span>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>
    <?php
}

function mipro_template_product_social_sharing() {
    if ( function_exists('mipro_template_social_sharing') ) {
        ?>
        <div class="product-share">
            <div class="product-share-title"><?php esc_html_e( 'Share:', 'mipro' ); ?></div>
            <?php mipro_template_social_sharing(); ?>
        </div>
        <?php

    }
}

/* Sidebar Button */
if ( ! function_exists('mipro_show_sidebar_button') ) {
    add_action('woocommerce_before_shop_loop', 'mipro_show_sidebar_button', 25);
    function mipro_show_sidebar_button() {
        $content_class = mipro_get_content_layout( mipro_get_opt('kft_prod_cat_layout') );
        if ( mipro_get_opt('kft_show_sidebar_button') ) {
            if ( $content_class['left_sidebar'] && is_active_sidebar( mipro_get_opt('kft_prod_cat_left_sidebar') ) || $content_class['right_sidebar'] && is_active_sidebar( mipro_get_opt('kft_prod_cat_right_sidebar') ) ) {
                ?>
                <div class="kft-show-sidebar-button">
                    <a href="#"><?php esc_html_e( 'Sidebar', 'mipro' ); ?></a>
                </div>
                <?php

            }
        }
    }
}

/* Filters Button */
if ( ! function_exists('mipro_filters_button') ) {
    add_action('woocommerce_before_shop_loop', 'mipro_filters_button', 15);
    function mipro_filters_button() {
        if ( mipro_get_opt('kft_show_filters_area') && is_active_sidebar('product-filters-content') ) {
            ?>
            <div class="kft-filters-button">
                <a href="#"><?php esc_html_e( 'Filters', 'mipro' ); ?></a>
            </div>

            <div class="kft-filters-content">
                <div class="close-sidebar"><span><?php esc_html_e( 'Close', 'mipro' ); ?></span></div>
                <div class="filter-content">
                    <?php dynamic_sidebar('product-filters-content'); ?>
                </div>
            </div>
            <?php
        }
    }
}

function mipro_template_single_meta() {
    global $product;

    echo '<div class="product-meta">';
    do_action('woocommerce_product_meta_start');
    if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type('variable') ) && mipro_get_opt('kft_prod_sku') ) {
        echo '<div class="product-sku">' . esc_html__( 'Sku: ', 'mipro' ) . '<span class="sku" itemprop="sku">' . ( ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'mipro' ) ) . '</span></div>';
    }
    if ( mipro_get_opt('kft_prod_cat') ) {
        echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-single-cats"><span>' . esc_html__( 'Categories:', 'mipro' ) . '</span><span class="cat-links">', '</span></div>');
    }
    if ( mipro_get_opt('kft_prod_tag') ) {
        echo wc_get_product_tag_list( $product->get_id(), ', ', '<div class="product-single-tags"><span>' . esc_html__( 'Tags:', 'mipro' ) . '</span><span class="tag-links">', '</span></div>' );
    }
    do_action( 'woocommerce_product_meta_end' );
    echo '</div>';
}

/* Product Size Chart*/
function mipro_template_product_size_chart_button() {
    $size_chart = mipro_get_opt('kft_prod_size_chart');
    $image_url = esc_url( $size_chart['url'] );
    if ( mipro_get_opt('kft_show_prod_size_chart') && strlen( $image_url ) > 0 ) {
        echo '<div class="sizechart-single"><a class="size-guide-btn" href="' . esc_url( $image_url ) . '"><i class="icon-chart"></i> ' . esc_html__( 'Size Chart', 'mipro' ) . '</a></div>';
    }
}

/* * * Product tab ** */
function mipro_product_remove_tabs( $tabs = array() ) {

    if ( ! mipro_get_opt('kft_prod_tabs') ) {
        return array();
    }
    return $tabs;
}

function mipro_add_product_custom_tab( $tabs = array() ) {
    global $post;

    $custom_tab = get_post_meta( $post->ID, 'kft_prod_custom_tab', true );
    $custom_tabs = get_post_meta( $post->ID, 'kft_prod_custom_tabs', true );

    if ( $custom_tab && $custom_tabs ) {
        $i = 90;
        foreach ( (array) $custom_tabs as $tab ) {
            $tab_key = 'kft_custom_' . $i; 
            if ( ! empty( $tab['tab_title'] ) && ! empty( $tab['tab_content'] ) ) {
                $tabs[ $tab_key ] = array(
                    'title'     => $tab['tab_title'],
                    'priority'  => $i++,
                    'callback'  => 'mipro_product_custom_tab_content',
                    'content'   => $tab['tab_content'],
                );
            }
        } 
    }
    elseif ( mipro_get_opt('kft_prod_custom_tab') ) {
        $custom_tab_title = mipro_get_opt('kft_prod_custom_tab_title');
        
        $tabs['kft_custom'] = array(
            'title'     => $custom_tab_title,
            'priority'  => 90,
            'callback'  => 'mipro_product_custom_tab_content',
        );
    }

    return $tabs;
}

function mipro_product_custom_tab_content( $key, $tab ) {
    global $post;

    $custom_tab = get_post_meta( $post->ID, 'kft_prod_custom_tab', true );
    $custom_tabs = get_post_meta( $post->ID, 'kft_prod_custom_tabs', true );
    if ( $custom_tab && $custom_tabs ) {
        $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $tab['content']) . "\n" );
        echo do_shortcode( shortcode_unautop( $content ) );
    } 
    elseif ( mipro_get_opt('kft_prod_custom_tab') ) {
        $custom_tab_content = mipro_get_opt('kft_prod_custom_tab_content');
        echo do_shortcode( stripslashes( wp_specialchars_decode( $custom_tab_content ) ) );
    }
}

/* Related products */
function mipro_output_related_products_args_filter( $args ) {
    $args['posts_per_page'] = 6;
    $args['columns'] = 5;
    return $args;
}

/* Show product price */
function mipro_variable_product_price_filter( $value, $object = null, $variation = null ) {
    if ( $value['price_html'] == '' ) {
        $value['price_html'] = '<span class="price">' . $variation->get_price_html() . '</span>';
    }
    return $value;
}

/* Add footer PhotoSwipe template */
add_action('wp_footer', 'mipro_photoswipe_template', 1000);
function mipro_photoswipe_template() {
    if ( is_singular('product') ) {
        get_template_part('woocommerce/single-product/photo-swipe-template');
    }
}

/* * * General hook ** */
add_action('woocommerce_after_shop_loop_item_title', 'mipro_template_loop_add_to_cart', 10006);

function mipro_product_group_button_start() {
    $num_icon = 0;

    if ( ! mipro_get_opt('kft_enable_catalog_mode') ) {
        $num_icon++;
    }

    echo "<div class=\"kft-product-buttons\" >";
}

function mipro_product_group_button_end() {
    echo "</div>";
}

function mipro_meta_start() {
    echo "<div class='kft-product-buttons'>";
}

function mipro_meta_end() {
    echo "</div>";
}

add_action('woocommerce_after_shop_loop_item_title', 'mipro_product_group_button_start', 10000);
add_action('woocommerce_after_shop_loop_item_title', 'mipro_product_group_button_end', 10007);
add_action('woocommerce_after_shop_loop_item', 'mipro_meta_start', 69);
add_action('woocommerce_after_shop_loop_item', 'mipro_meta_end', 100);

/* Wishlist */
function mipro_wishlist_button() {
    if ( class_exists('YITH_WCWL_Shortcode') ) {
        echo YITH_WCWL_Shortcode::add_to_wishlist( array() );
    }
}
add_action('woocommerce_after_shop_loop_item_title', 'mipro_wishlist_button', 10002);
add_action('woocommerce_after_shop_loop_item', 'mipro_wishlist_button', 80);

/* Compare */
if ( class_exists('YITH_Woocompare') && get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ) {
    global $yith_woocompare;
    $is_ajax = ( defined('DOING_AJAX') && DOING_AJAX );
    if ( $yith_woocompare->is_frontend() || $is_ajax ) {
        if ( $is_ajax ) {
            if ( defined('YITH_WOOCOMPARE_DIR') && ! class_exists('YITH_Woocompare_Frontend') ) {
                $compare_frontend_class = YITH_WOOCOMPARE_DIR . 'includes/class.yith-woocompare-frontend.php';
                if ( file_exists($compare_frontend_class) ) {
                    require_once $compare_frontend_class;
                }
            }
            $yith_woocompare->obj = new YITH_Woocompare_Frontend();
        }
        remove_action('woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20);

        function mipro_compare_button() {
            if ( wp_is_mobile() ) {
                return;
            }

            global $yith_woocompare, $product;
            echo '<div class="kft-compare"> <a class="compare" href="' . esc_url( $yith_woocompare->obj->add_product_url( $product->get_id() ) ) . '" data-product_id="' . esc_attr( $product->get_id() ) . '">' . get_option('yith_woocompare_button_text') . '</a></div>';
        }

        add_action('woocommerce_after_shop_loop_item_title', 'mipro_compare_button', 10003);
        add_action('woocommerce_after_shop_loop_item', 'mipro_compare_button', 70);

        add_filter('option_yith_woocompare_button_text', 'mipro_compare_button_text_filter', 99);

        function mipro_compare_button_text_filter($button_text) {
            return '<i class="icon-shuffle"></i>' . esc_html( $button_text ) . '';
        }

    }

    /* Compare - Add custom style */
    if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'yith-woocompare-view-table' ) {
        add_action('wp_print_styles', 'mipro_add_custom_style_compare_popup', 1000);
    }

    function mipro_add_custom_style_compare_popup() {
        wp_enqueue_style('mipro-default');
        wp_enqueue_style('mipro-style');
        wp_enqueue_style('font-awesome');
        wp_enqueue_style('mipro-font-google');

        /* Add dynamic style for iframe*/
        mipro_register_custom_css();
    }
}

/* * * End General hook ** */

/* * * Cart - Checkout hooks ** */
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10);
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display', 10);

add_action('woocommerce_proceed_to_checkout', 'mipro_cart_continue_shopping_button', 20);

/* Continue Shopping button */
function mipro_cart_continue_shopping_button() {
    echo '<a href="' . esc_url( wc_get_page_permalink('shop') ) . '" class="button button-secondary">' . esc_html__( 'Continue Shopping', 'mipro' ) . '</a>';
}
/**
 * ------------------------------------------------------------------------------------------------
 * My account remove logout link
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists('mipro_remove_my_account_logout') ) {
    function mipro_remove_my_account_logout($items) {
        unset( $items['customer-logout'] );
        return $items;
    }
    add_filter('woocommerce_account_menu_items', 'mipro_remove_my_account_logout', 10);
}
/**
 * ------------------------------------------------------------------------------------------------
 * My account wrapper
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists('mipro_my_account_wrapp_start') ) {
    function mipro_my_account_wrapp_start() {
        echo '<div class="woocommerce-my-account-inner">';
    }
    add_action('woocommerce_account_navigation', 'mipro_my_account_wrapp_start', 1);
}

if ( ! function_exists('mipro_my_account_wrapp_end') ) {
    function mipro_my_account_wrapp_end() {
        echo '</div><!-- .woocommerce-my-account-inner -->';
    }
    add_action('woocommerce_account_content', 'mipro_my_account_wrapp_end', 10000);
}
/**
 * ------------------------------------------------------------------------------------------------
 * My account dashboard links
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists('mipro_my_account_dashboard_links') ) {
    function mipro_my_account_dashboard_links() {
        ?>
        <div class="my-account-dashboard-links">

            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                <div class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>-link">
                    <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                </div>
            <?php endforeach; ?>

            <?php if ( class_exists('YITH_WCWL') ) : ?>
                <?php $wishlist_page_id = yith_wcwl_object_id( get_option('yith_wcwl_wishlist_page_id') ); ?>
                <div class="wishlist-link">
                    <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>"><?php echo get_the_title( $wishlist_page_id ); ?></a></li>
                </div>
            <?php endif;?>

        </div>
        <?php

    }
    add_action('woocommerce_account_dashboard', 'mipro_my_account_dashboard_links', 10);
}

/* Product Sticky Bar */
if ( ! function_exists('mipro_sticky_product') ) {
    function mipro_sticky_product() {
        if ( mipro_is_woocommerce_activated() && is_product() && mipro_get_opt('kft_product_sticky_bar') ) {
            global $post;

            $product = wc_get_product($post->ID);
            if ( $product->is_in_stock() ) { ?>
                <div class="mipro_product_sticky">
                    <div class="container">

                        <?php if ( mipro_get_opt('kft_show_product_sticky_image') ) : ?>
                            <span class="product_sticky_image"><?php echo woocommerce_get_product_thumbnail(); ?></span>
                        <?php endif; ?>

                        <div class="product_sticky_detail">
                            <?php if ( mipro_get_opt('kft_show_product_sticky_name') ) : ?>
                                <span><?php echo wp_kses_post( $product->get_name() ); ?></span>
                            <?php endif; ?>
                            
                        </div>
                        
                        <?php if ( mipro_get_opt('kft_product_sticky_price') ) : ?>
                            <p class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
                        <?php endif; ?>

                        <?php if ( mipro_get_opt('kft_product_sticky_cart') ): ?>
                            <?php mipro_template_loop_add_to_cart(); ?>
                        <?php endif; ?>

                    </div>
                </div>
                <?php

            }
        }
    }
    add_action('wp_footer', 'mipro_sticky_product');
}

/* Color Swatches */
if ( ! function_exists('mipro_color_swatches') ) {
    function mipro_color_swatches( $attribute_name = 'pa_color' ) {
        global $product;

        $id = $product->get_id();

        if ( empty( $id ) || !$product->is_type('variable') || ! mipro_get_opt('kft_enable_color_swatches') ) {
            return false;
        }

        $variations = $product->get_available_variations();

        if ( empty( $variations ) ) {
            return false;
        }

        $swatches = mipro_get_variations( $attribute_name, $variations, $id );

        if ( empty( $swatches ) ) {
            return false;
        }

        $output = '<div class="color-swatches">';

        foreach ( $swatches as $key => $swatch ) {
            $style = $class = '';

            if ( ! empty( $swatch['color'] ) ) {
                $style = 'background-color:' . $swatch['color'];
                $class .= ' kft-tooltip';
            } else if ( ! empty( $swatch['image'] ) ) {
                $style = 'background-image: url(' . $swatch['image'] . ')';
                $class .= ' kft-tooltip';
            } else {
                $class .= 'color-text ';
            }

            $data = '';

            if ( isset( $swatch['image_src'] ) ) {
                $data .= 'data-src="' . $swatch['image_src'] . '"';
                $data .= ' data-srcset="' . $swatch['image_srcset'] . '"';

                if ( mipro_get_opt('kft_color_swatches_images') ) {
                    $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $swatch['variation_id'] ), 'shop_thumbnail' );
                    if ( ! empty( $thumbnail ) ) {
                        $style = 'background-image: url(' . $thumbnail[0] . ')';
                        $class .= ' swatch-is-image';
                    }
                }
            }

            $term = get_term_by( 'slug', $key, $attribute_name );

            if ( is_object( $term ) ) {
                $output .= '<div class="color-swatch ' . esc_attr( $class ) . '" style="' . esc_attr( $style ) . '" ' . $data . '>' . $term->name . '</div>';
            }
        }

        $output .= '</div>';

        return $output;

    }
}

if ( ! function_exists('mipro_get_variations') ) {
    function mipro_get_variations( $attribute_name, $variations, $product_id = false ) {
        $swatches = array();
        foreach ( $variations as $key => $variation ) {
            $option = array();
            $attr_key = 'attribute_' . $attribute_name;
            
            if ( ! isset( $variation['attributes'][$attr_key] ) ) {
                return;
            }

            $value = $variation['attributes'][$attr_key];

            if ( ! empty($variation['image']['src'] ) ) {
                $option = array(
                    'variation_id' => $variation['variation_id'],
                    'image_src' => $variation['image']['src'],
                    'image_srcset' => $variation['image']['srcset'],
                );
            }

            $swatch = mipro_get_swatch( $product_id, $attribute_name, $value );

            $swatches[$value] = array_merge ($swatch, $option );
        }

        return $swatches;

    }
}

if ( ! function_exists('mipro_get_swatch') ) {
    function mipro_get_swatch( $id, $attr_name, $value ) {
        $swatches = array();

        $color = $image = '';

        $term = get_term_by( 'slug', $value, $attr_name );
        if ( is_object( $term ) ) {
            $color = get_term_meta( $term->term_id, 'color_color', true );
            $image = get_term_meta( $term->term_id, 'color_image', true );
        }

        if ( $color != '' ) {
            $swatches['color'] = $color;
        }

        if ( $image != '' ) {
            $swatches['image'] = $image;
        }

        return $swatches;
    }
}

// Product Video 360
if ( ! function_exists('mipro_product_video_360') ) {
    function mipro_product_video_360() {
        global $post;
        $gallery = get_post_meta( $post->ID, 'kft_product_360', true );

        if ( empty( $gallery ) ) {
            return;
        }

        $id = rand( 10,9999 );
        $width = $height = 0;
        $frames_count = count( $gallery );
        $images_array = array();
        ?>

        <div class="product-360-btn">
            <a href="#product-360-wrap"><span><?php esc_html_e( 'Open 360 view', 'mipro' ); ?></span></a>
        </div>
        <div id="product-360-wrap" class="product-360-wrap mfp-hide">
            <div class="threesixty threesixty-id-<?php echo esc_attr( $id ); ?>">
                <ul class="threesixty_images">
                    <?php foreach( (array)$gallery as $gallery_id => $gallery_url ) : ?>
                        <?php
                        $img = wp_get_attachment_image_src( $gallery_id, 'full' );
                        $width = $img[1];
                        $height = $img[2];
                        $images_array[] = "'" . $img[0] . "'";
                        ?>
                    <?php endforeach; ?>
                </ul>
                <div class="spinner">
                    <span>0%</span>
                </div>
            </div>
        </div>
        <?php
        wp_add_inline_script('mipro-global', '(function($) {
            "use strict";
            $(document).ready(function($) {
                $(".threesixty-id-' . esc_js( $id ) . '").ThreeSixty({
                    totalFrames: ' . esc_js( $frames_count ) . ',
                    endFrame: ' . esc_js( $frames_count ) . ',
                    currentFrame: 1,
                    imgList: ".threesixty_images",
                    progress: ".spinner",
                    imgArray: ' . "[" . implode(',', $images_array) . "]" . ',
                    height: ' . esc_js( $height ) . ',  
                    width: ' . esc_js( $width ) . ',
                    responsive: true,
                    navigation: true,
                    disableSpin: false
                    });
                    });
                })(jQuery);', 'after');
    }
}
if ( ! function_exists('mipro_products_cate_shop') ) {
    function mipro_products_cate_shop() {
        if ( ! class_exists('MiproCore') ) {
            return;
        }
        $instance = array(
            'title' => '',
            'show_post_count' => false,
            'show_sub_cat'   => false,
            'hide_empty' => true,
            'orderby' => '',
            'order' => 'ASC',
            'include_cat' => ''

        );
     
       the_widget('Mipro_Product_Categories_Widget', $instance );
     
    }
}
