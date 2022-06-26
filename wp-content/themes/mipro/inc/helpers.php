<?php

/* Page Layout Columns Class */
if ( ! function_exists('mipro_get_content_layout') ) {
    function mipro_get_content_layout( $page_column ) {
        $data = array();
        $left_sidebar = 0;
        $right_sidebar = 0;
        switch ( $page_column ) {
            case 'left-sidebar':
            $main_class = 'col-md-9 col-xs-12';
            $left_sidebar = 1;
            break;
            case 'right-sidebar':
            $main_class = 'col-md-9 col-xs-12';
            $right_sidebar = 1;
            break;
            case 'left-right-sidebar':
            $main_class = 'col-md-6 col-xs-12';
            $left_sidebar = 1;
            $right_sidebar = 1;
            break;
            default:
            $main_class = 'col-md-12 col-xs-12';
            break;
        }
        $data['left_sidebar'] = $left_sidebar;
        $data['right_sidebar'] = $right_sidebar;
        $data['main_class'] = $main_class;
        $data['left_sidebar_class'] = 'col-md-3 col-xs-12';
        $data['right_sidebar_class'] = 'col-md-3 col-xs-12';

        return $data;
    }
}

/* Header Template  */
if ( ! function_exists('mipro_get_header_template') ) {
    function mipro_get_header_template() {
        $header_layout = mipro_get_opt('kft_header_layout');
        get_template_part( 'template-parts/headers/header', $header_layout );
    }
}

/* Show Page Slider */
if ( ! function_exists('mipro_show_page_slider') ) {
    function mipro_show_page_slider() {
        global $mipro_page_options;
        switch ($mipro_page_options['kft_page_slider']) {
            case 'revslider':
            if ( function_exists( 'putRevSlider' ) ) {
                putRevSlider($mipro_page_options['kft_rev_slider'], '');
            }
            break;
            default:
            break;
        }
    }
}

/* Logo */
if ( ! function_exists('mipro_logo') ) {
    function mipro_logo() {
        $logo_image = get_parent_theme_file_uri( '/assets/images/logo.png' );
        $logo_text = get_bloginfo('name');
        $logo_img = mipro_get_opt('kft_logo');
        $logo_img_sticky = mipro_get_opt('kft_logo_sticky');
        $has_logo_sticky = isset( $logo_img_sticky['url'] ) && ! empty( $logo_img_sticky['url'] );

        if ( isset( $logo_img['url'] ) && $logo_img['url'] != '' ) {
            $logo_image = esc_url( $logo_img['url'] );
        }
        ?>

        <div class="logo <?php if ( $has_logo_sticky ) {
            echo esc_attr( 'logo-sticky-enable' );
        }
        ?>">

        <a href="<?php echo esc_url( home_url('/') ); ?>" class="logo-nomal">
            <?php if ( ! empty( $logo_image ) ) : ?>
                <img src="<?php echo esc_url( $logo_image ); ?>" alt="<?php echo esc_attr( $logo_text ); ?>" title="<?php echo esc_attr( $logo_text ); ?>" />
                <?php else : ?>
                    <?php echo esc_html( $logo_text ); ?>
                <?php endif; ?>
            </a>

            <?php if ( $has_logo_sticky ) : ?>
                <a href="<?php echo esc_url( home_url('/') ); ?>" class="logo-sticky" rel="home">
                    <img src="<?php echo esc_url( $logo_img_sticky['url'] ); ?>" alt="<?php echo esc_attr( $logo_text ); ?>" title="<?php echo esc_attr( $logo_text ); ?>" />
                </a>
            <?php endif; ?>
        </div>

        <?php
    }
}

/* * * Breadcrumbs ** */
if ( ! function_exists('mipro_breadcrumbs') ) {

    function mipro_breadcrumbs() {
        global $post, $wp_query;

        $divider = '<span class="divider"><i class="icon-arrow-right"></i></span>';

        $default = array(
            'home' => esc_attr__( 'Home', 'mipro' ),
            'search' => esc_attr__( 'Search results for ', 'mipro' ),
            '404' => esc_attr__( '404 - Page not Found', 'mipro' ),
            'category' => esc_attr__( 'Archive by category ', 'mipro' ),
            'tagged' => esc_attr__( 'Posts tagged ', 'mipro' ),
            'author' => esc_attr__( 'Articles posted by: ', 'mipro' ),
            'page' => esc_attr__( 'Page', 'mipro' ),
            'blog' => esc_attr__( 'Blog', 'mipro' ),
            'front-page' => '',
        );

        $args = apply_filters( 'mipro_breadcrumbs_defaults', $default );
        $default = wp_parse_args( $args, $default );

        // Woocommerce Breadcrumb
        if ( class_exists( 'WooCommerce' ) ) {
            if ( function_exists( 'woocommerce_breadcrumb' ) && is_woocommerce() ) {
                woocommerce_breadcrumb( array( 'wrap_before' => '<div class="breadcrumbs"><div class="breadcrumbs-content">', 'delimiter' => $divider, 'wrap_after' => '</div></div>' ) );
                return;
            }
        }

        $allowed_html = apply_filters( 'mipro_breadcrumbs_allowed_html', array(
            'a' => array( 'href' => array(), 'title' => array() ),
            'span' => array( 'class' => array() ),
            'div' => array( 'class' => array() ),
            'i' => array( 'class' => array() ),
        ) );

        $output = '';
        $output .= '<div class="breadcrumbs"><div class="breadcrumbs-content" itemscope itemtype="http://schema.org/BreadcrumbList">';
        if ( ! is_front_page() ) {
            $output .= '<a itemprop="url" href="' . esc_url( get_home_url() ) . '" title="' . esc_attr( $default['home'] ) . '"><span itemprop="title">' . esc_attr( $default['home'] ) . '</span></a>' . $divider;
            if ( is_home() ) {
                $output .= esc_attr( $default['blog'] );

            } elseif ( is_post_type_archive() ) {
                $post_type = get_post_type_object( get_post_type() );
                $output .= $post_type->labels->singular_name;

            } elseif ( is_tax() ) {
                $term = $GLOBALS['wp_query']->get_queried_object();
                $output .= $term->name;

            } elseif ( is_single() ) {
                $category = get_the_category();
                if ( ! empty( $category ) ) {
                    $output .= '<a itemprop="url" href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" title="' . esc_attr( $category[0]->cat_name ) . '">' . $category[0]->cat_name . '</a>' . $divider;
                }
                $output .= get_the_title();

            } elseif ( is_category() ) {
                $thisCat = get_category( get_query_var('cat'), false );
                if ( $thisCat->parent != 0 ) {
                    echo get_category_parents( $thisCat->parent, TRUE, ' ' );
                }
                $output .= $default['category'] . '"' . single_cat_title( '', false ) . '"';

            } elseif ( is_page() ) {
                if ( $post->post_parent ) {
                    $ancestors = get_post_ancestors( $post->ID );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $parents = '<a itemprop="url" href="' . esc_url( get_permalink( $ancestor ) ) . '" title="' . esc_attr( get_the_title( $ancestor ) ) . '">' . get_the_title( $ancestor ) . '</a>' . $divider;
                    }
                    $output .= $parents;
                    $output .= get_the_title();

                } else {
                    $output .= get_the_title();
                }

            } elseif ( is_tag() ) {
                $output .= $default['tagged'] . '"' . single_tag_title( '', false ) . '"';

            } elseif ( is_day() ) {

                $output .= '<a itemprop="url" href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '" title="' . esc_attr( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>' . $divider;
                // Month link
                $output .= '<a itemprop="url" href="' . esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ) . '" title="' . esc_attr( get_the_time('M') ) . '">' . get_the_time('M') . '</a>' . $divider;
                // Day display
                $output .= get_the_time('d');

            } elseif ( is_month() ) {
                $output .= '<a itemprop="url" href="' . esc_url( get_year_link( get_the_time('Y') ) ) . '" title="' . esc_attr( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>' . $divider;
                // Month display
                $output .= get_the_time('M');

            } elseif ( is_year() ) {
                // Display year archive
                $output .= get_the_time('Y');

            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );

                $output .= esc_attr( $default['author'] ) . $userdata->display_name;

            } elseif ( get_query_var('paged') ) {
                $output .= esc_attr( $default['page'] ) . ' ' . get_query_var('paged');

            } elseif ( is_search() ) {
                // Search results page
                $output .= esc_attr( $default['search'] ) . '"' . get_search_query() . '"';

            } elseif ( is_404() ) {
                $output .= esc_attr( $default['404'] );
            }
        } else {
            $output .= esc_attr( $default['front-page'] );
        }
        $output .= '</div></div>';

        echo wp_kses( $output, $allowed_html );
        wp_reset_postdata();
    }

}

if ( ! function_exists( 'mipro_page_heading' ) ) {
    function mipro_page_heading() {
        if ( mipro_get_opt('kft_breadcrumbs') || mipro_get_opt('kft_page_title') ) {
            $breadcrumb_img = mipro_get_opt('kft_bg_breadcrumbs');
            $breadcrumb_bg = ( isset( $breadcrumb_img['background-image'] ) ) ? $breadcrumb_img['background-image'] : '';
            $style = '';

            if ( $breadcrumb_bg != '' ) {
                $style = 'style="background-image: url(' . $breadcrumb_bg . ') !important"';
            }
            ?>
            <div class="kft-breadcrumb breadcrumb-<?php echo esc_attr( mipro_get_opt('kft_breadcrumb_layout') ); ?>" <?php echo wp_kses_post( $style ); ?>><div class="container"><div class="breadcrumb-title-inner">

                <?php if ( mipro_get_opt('kft_page_title') ) : ?>
                    <h1 class="breadcrumb-title"><?php echo mipro_get_the_title(); ?></h1>
                <?php endif; ?>

                <?php if ( mipro_get_opt('kft_breadcrumbs') ) {
                   mipro_breadcrumbs(); 
                }
                ?>
            </div></div></div>
            <?php
        }
    }
}

if ( ! function_exists('mipro_get_the_title') ) {
    function mipro_get_the_title() {

        if ( class_exists('WooCommerce') ) {
            if ( is_woocommerce() ) {
                if ( is_single() && ! is_attachment() ) {
                    echo get_the_title();
                } elseif ( ! is_single() ) {
                    woocommerce_page_title();
                }
                return;
            }
        }

        $post_page = get_option('page_for_posts');

        if ( is_404() ) {
            return esc_html__( 'Page not found', 'mipro' );
        }

        if ( is_home() ) {
            if ( empty( $post_page ) && ! is_single() && ! is_page() ) {
                return esc_html__( 'Blog', 'mipro' );
            }
            return get_the_title( $post_page );
        }

        // Homepage and Single Page
        if ( is_home() || is_single() || is_404() ) {
            return get_the_title();
        }

        // Search Page
        if ( is_search() ) {
            return sprintf( esc_html__( 'Search Results for: %s', 'mipro' ), get_search_query() );
        }

        // Archive Pages
        if ( is_archive() ) {
            if ( is_author() ) {
                return sprintf( esc_html__( 'All posts by %s', 'mipro' ), get_the_author() );
            } elseif ( is_day() ) {
                return sprintf( esc_html__( 'Daily Archives: %s', 'mipro' ), get_the_date() );
            } elseif ( is_month() ) {
                return sprintf( esc_html__( 'Monthly Archives: %s', 'mipro' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'mipro' ) ) );
            } elseif ( is_year() ) {
                return sprintf( esc_html__( 'Yearly Archives: %s', 'mipro' ), get_the_date(_x( 'Y', 'yearly archives date format', 'mipro' ) ) );
            } elseif ( is_tag() ) {
                return sprintf( esc_html__( 'Tag Archives: %s', 'mipro' ), single_tag_title( '', false ) );
            } elseif ( is_category() ) {
                return sprintf( esc_html__( 'Category Archives: %s', 'mipro' ), single_cat_title( '', false ) );
            } elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
                return esc_html__( 'Asides', 'mipro' );
            } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
                return esc_html__( 'Videos', 'mipro' );
            } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
                return esc_html__( 'Audio', 'mipro' );
            } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
                return esc_html__( 'Quotes', 'mipro' );
            } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
                return esc_html__( 'Galleries', 'mipro' );
            } else {
                return esc_html__( 'Archives', 'mipro' );
            }
        }

        return get_the_title();
    }
}

/* * * Add Inline Style Custom Style ** */
if ( ! function_exists('mipro_register_custom_css') ) {
    function mipro_register_custom_css() {
        global $post;

        ob_start();
        include_once get_parent_theme_file_path( '/inc/custom-style.php' );
        $output = ob_get_contents();
        ob_end_clean();

        if ( is_page() ) {
            $custom_css = get_post_meta( $post->ID, 'kft_page_custom_css', true );
            if ( ! empty( $custom_css ) ) {
                $output .= $custom_css;
            }
        }

        $dynamic_css = mipro_minify_css( $output );
        wp_add_inline_style( 'mipro-default', $dynamic_css );
        
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }
    add_action( 'wp_enqueue_scripts', 'mipro_register_custom_css', 9999 );
}

/* * * Popup * */
if ( ! function_exists('mipro_promo_popup') ) {
    add_action('wp_footer', 'mipro_promo_popup', 200);
    function mipro_promo_popup() {
        if ( ! mipro_get_opt('kft_enable_popup') ) {
            return;
        }

        if ( wp_is_mobile() && mipro_get_opt('kft_popup_hide_mobile') ) {
            return;
        }

        ?>
        <div class="kft-popup">
            <div class="kft-popup-wrapper">
                <?php
                if ( function_exists( 'kc_do_shortcode' ) ) {
                    echo kc_do_shortcode( mipro_get_opt('kft_popup_editor') );
                }
                else {
                    echo do_shortcode( mipro_get_opt('kft_popup_editor') );
                }
                ?>
            </div>
        </div>
        <?php

    }
}

/* * * Product Search Form ** */
if ( ! function_exists('mipro_search_by_category') ) {
    function mipro_search_by_category( $category = true ) {

        if ( mipro_is_woocommerce_activated() ) {
            $taxonomy = 'product_cat';
            $post_type = 'product';
            $placeholder_text = esc_attr__( 'Search for product ...', 'mipro' );
        } else {
            $taxonomy = 'category';
            $post_type = 'post';
            $placeholder_text = esc_attr__( 'Search for post ...', 'mipro' );
        }
        ?>

        <div class="search-form-wrapper">
            <form method="get" class="searchform" action="<?php echo esc_url( home_url('/') ); ?>" role="search">
                <?php if ( $category ) : ?>
                    <?php wp_dropdown_categories( array( 'show_option_all' => esc_html__( 'All categories', 'mipro' ), 'taxonomy' => $taxonomy, 'hierarchical' => true, 'name' => 'term', 'orderby' => 'name', 'value_field' => 'slug', 'class' => esc_attr( 'select-category' ) ) ); ?>
                <?php endif; ?>
                <div class="kft_search_products">
                    <input type="text" value="<?php echo get_search_query(); ?>" name="s" class="search-field" placeholder="<?php echo esc_attr( $placeholder_text ); ?>" autocomplete="off" />
                    <input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>" />
                    <input type="hidden" name="taxonomy" value="<?php echo esc_attr( $taxonomy ); ?>" />
                    <button type="submit" class="search-submit"></button>
                </div>
            </form>
        </div>

        <?php
    }
}

/* Ajax search */
add_action('wp_ajax_mipro_ajax_search', 'mipro_ajax_search');
add_action('wp_ajax_nopriv_mipro_ajax_search', 'mipro_ajax_search');
if ( ! function_exists('mipro_ajax_search') ) {
    function mipro_ajax_search() {
        global $wpdb, $post;

        check_ajax_referer( 'mipro-ajax-search', 'security' );

        $return = array(
            'status' => 'error',
            'html' => '',
        );
        if ( isset( $_REQUEST['s'] ) && $_REQUEST['s'] != '' ) {
            $has_woocommerce = mipro_is_woocommerce_activated();
            if ( $has_woocommerce ) {
                $taxonomy = 'product_cat';
                $post_type = 'product';
            } else {
                $taxonomy = 'category';
                $post_type = 'post';
            }
            $number = mipro_get_opt('kft_ajax_search_number_result');
            $num_result = isset( $number ) ? (int) $number : 10;
            $query = sanitize_text_field( $_REQUEST['s'] );
            $cat = isset( $_REQUEST['cat'] ) ? strip_tags( $_REQUEST['cat'] ) : '';
            $args = array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                's' => $query,
                'posts_per_page' => $num_result,
                'tax_query' => array(),
            );
            if ( $has_woocommerce ) {
                $args['meta_query'] = WC()->query->get_meta_query();
                $args['tax_query'] = WC()->query->get_tax_query();
            }
            if ( ! empty( $cat ) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'terms' => $cat,
                        'field' => 'slug',
                    ),
                );
            }
            $results = new WP_Query( $args );

            if ( $results->have_posts() ) {

                $return['status'] = 'success';
                $return['html'] .= '<ul class="kft-list-products">';
                while ( $results->have_posts() ) {
                    ob_start();
                    $results->the_post();

                    $image = '';
                    if ( $post_type == 'product' ) {
                        $product = wc_get_product( $post->ID );
                        $image = $product->get_image();
                    } else if ( has_post_thumbnail( $post->ID ) ) {
                        $image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
                    }

                    $return['html'] .= '<li>';
                    $return['html'] .= '<div class="search-form-wrapper-image">';
                    $return['html'] .= '<a href="' . esc_url( get_the_permalink( $post->ID ) ) . '">' . $image . '</a>';
                    $return['html'] .= '</div>';
                    $return['html'] .= '<div class="search-form-wrapper-meta item-information">';
                    $return['html'] .= '<a href="' . esc_url( get_the_permalink( $post->ID ) ) . '" class="product-title product-name">' . esc_attr( $post->post_title ) . '</a>';
                    if ( $post_type == 'product' ) {
                        if ( $price_html = $product->get_price_html() ) {
                            $return['html'] .= '<span class="price">' . $price_html . '</span>';
                        }
                    }
                    $return['html'] .= '</div>';
                    $return['html'] .= '</li>';
                }
                $return['html'] .= '</ul>';

                if ( isset( $results->post_count, $results->found_posts ) && $results->found_posts > $results->post_count ) {
                    $return['status'] = 'error';
                    $view_all_text = sprintf( esc_html__( 'View all %d results', 'mipro' ), $results->found_posts);

                    $return['html'] .= '<div class="view-all">';
                    $return['html'] .= '<a href="#">' . $view_all_text . '</a>';
                    $return['html'] .= '</div>';
                }
                wp_reset_postdata();
            } else {
                $return['html'] = '<span class="no-result">' . esc_html__( 'No matches found.', 'mipro' ) . '</span>';
                wp_reset_postdata();
            }
        }
        echo json_encode( $return );
        die();
    }
}

/* Post Thumbnail */
if ( ! function_exists('mipro_post_thumb') ) {
    function mipro_post_thumb( $args = array() ) {
        global $post;

        $defaults = array(
            'size' => 'large',
            'class' => 'post-image',
        );
        $args = wp_parse_args( $args, $defaults );
        $post_format = get_post_format();
        ?>

        <?php if ( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ) : ?>
            <a class="blog-image <?php echo esc_attr( $post_format ); ?> <?php echo esc_attr( ( $post_format == 'gallery' ) ? ('loading owl-carousel') : '' ); ?>" href="<?php the_permalink(); ?>">

                <?php
                if ( $post_format == 'gallery' ) {
                    $gallery = get_post_meta( $post->ID, 'kft_gallery', true );
                    foreach ( (array) $gallery as $gallery_id => $gallery_url ) {
                        echo wp_get_attachment_image( $gallery_id, $args['size'], 0, array( 'class' => $args['class'] ) );
                    }
                }

                if ( $post_format === false || $post_format == 'standard' ) {
                    if ( has_post_thumbnail() ) {
                        if ( mipro_get_opt('kft_blog_lazyload') && function_exists( 'mipro_add_lazy_load_attrs' ) ) {
                            mipro_add_lazy_load_attrs();
                        }
                        the_post_thumbnail( $args['size'], array( 'class' => $args['class'] ) );
                        if ( mipro_get_opt('kft_blog_lazyload') && function_exists( 'mipro_remove_lazy_load_attrs' ) ) {
                            mipro_remove_lazy_load_attrs();
                        }
                    }
                }
                ?>
            </a>
        <?php endif; ?>

        <?php
        if ( $post_format == 'video' ) {
            $video_url = get_post_meta( $post->ID, 'kft_video_url', true );
            if ( ! empty( $video_url ) ) {
                echo do_shortcode('[kft_video src="' . esc_url( $video_url ) . '"]');
            }
        }

        if ( $post_format == 'audio' ) {
            $audio_url = get_post_meta( $post->ID, 'kft_audio_url', true );
            if ( ! empty( $audio_url ) ) {
                $file_format = substr( $audio_url, -3, 3 );
                if ( in_array( $file_format, array('mp3', 'ogg', 'wav') ) ) {
                    echo do_shortcode('[audio ' . $file_format . '="' . $audio_url . '"]');
                } else {
                    echo do_shortcode('[kft_soundcloud url="' . esc_url( $audio_url ) . '" width="100%" height="166"]');
                }
            }
        }
    }
}

/* * * Get excerpt ** */
if ( ! function_exists('mipro_the_excerpt_max_words') ) {
    function mipro_the_excerpt_max_words( $limit = -1, $strip_html = true, $extra_str = '', $echo = true ) {
        $post = get_post(get_the_ID());
        if ( 'product' === $post->post_type ) {
            $excerpt = get_the_excerpt();
        } else {
            if ( has_excerpt() ) {
                $excerpt = get_the_excerpt();
            } else {
                $excerpt = get_the_content();
                $excerpt = apply_filters( 'the_content', $excerpt );
                $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
            }
        }

        if ( $strip_html ) {
            $excerpt = wp_strip_all_tags( $excerpt );
            $excerpt = strip_shortcodes( $excerpt );
        }

        if ( $limit != -1 ) {
            $result = mipro_string_limit_words( $excerpt, $limit );
            $result .= $extra_str;
        } else {
            $result = $excerpt;
        }

        if ( $echo ) {
            echo do_shortcode( $result );
        }

        return $result;
    }
}

if ( ! function_exists('mipro_string_limit_words') ) {
    function mipro_string_limit_words( $string, $limit, $extra_str = '' ) {
        $words = explode( ' ', $string, ($limit + 1) );
        if ( count( $words ) > $limit ) {
            array_pop( $words );
        }
        return implode(' ', $words);
    }
}

/** Related post args **/
if ( ! function_exists('mipro_get_related_posts_args') ) {
    function mipro_get_related_posts_args( $post_id ) {
        $taxs = wp_get_post_tags( $post_id );
        $args = array();
        if ( $taxs ) {
            $tax_ids = array();
            foreach ( $taxs as $individual_tax ) {
                $tax_ids[] = $individual_tax->term_id;
            }

            $args = array(
                'tag__in' => $tax_ids,
                'post__not_in' => array($post_id),
                'showposts' => 12,
                'ignore_sticky_posts' => 1,
            );
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array('post-format-gallery', 'post-format-quote'),
                    'operator' => 'NOT IN',
                ),
            );

        }

        return $args;
    }
}

/*** Pagination ***/
if ( ! function_exists('mipro_pagination') ) {
    function mipro_pagination( $query = null ) {
        global $wp_query;
        $max_num_pages = $wp_query->max_num_pages;
        $paged = $wp_query->get('paged');

        if ( $query != null ) {
            $max_num_pages = $query->max_num_pages;
            $paged = $query->get('paged');
        }

        if ( ! $paged ) {
            $paged = 1;
        }
        ?>
        <nav class="kft-pagination">
            <?php

            echo paginate_links( array(
                'base' => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
                'format' => '',
                'add_args' => '',
                'current' => max( 1, $paged ),
                'total' => $max_num_pages,
                'prev_text' => '',
                'next_text' => '',
                'type' => 'list',
                'end_size' => 3,
                'mid_size' => 3,
            ));
            ?>

        </nav>

        <?php

        ob_start();
        posts_nav_link();
        ob_get_clean();
    }
}

/**  Template for comments and pingbacks. */
if ( ! function_exists('mipro_comment') ) {
    function mipro_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback':
            case 'trackback':
            ?>
            <li class="post pingback">
                <p><?php esc_html_e( 'Pingback:', 'mipro' );?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'mipro' ), '<span class="edit-link">', '<span>'); ?>
            </p>

            <?php
            break;
            default:
            ?>

            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <article id="comment-<?php comment_ID(); ?>" class="comment-inner">

                    <div class="comment-content">
                        <div class="comment-author">
                            <?php echo get_avatar( $comment, 70 ); ?>
                        </div>

                        <div class="comment-box">
                            <strong><?php echo get_comment_author_link(); ?></strong>
                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <em><?php esc_html_e('Your comment is awaiting moderation.', 'mipro'); ?></em><br />
                            <?php endif; ?>

                            <div class="comment-excerpt"><?php comment_text(); ?></div>

                            <div class="comment-meta commentmetadata">
                                <time datetime="<?php comment_time('c'); ?>"><?php printf( esc_attr__( '%1$s at %2$s', 'mipro' ), get_comment_date(), get_comment_time() ); ?>
                            </time>

                            <?php edit_comment_link( esc_attr__( ' - Edit', 'mipro' ), ' ', ' ' ); ?>

                            <div class="reply">
                                <?php
                                comment_reply_link( array_merge( $args, array(
                                    'reply_text' => esc_attr__( 'Reply', 'mipro' ),
                                    'add_below' => 'comment',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth'],
                                )));
                                ?>

                            </div><!-- .reply -->
                        </div><!-- .comment-meta -->
                    </div><!-- .comment-box -->
                </div><!-- .comment-content -->
            </article><!-- #comment -->

            <?php
            break;
        endswitch;
    }
}

if ( ! function_exists( 'mipro_minify_css' ) ) {
    function mipro_minify_css( $css ) {
        // Normalize whitespace
        $css = preg_replace('/\s+/', ' ', $css);

        // Remove spaces before and after comment
        $css = preg_replace('/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css);
        // Remove comment blocks, everything between /* and */, unless
        // preserved with /*! ... */ or /** ... */
        $css = preg_replace('~/\*(?![\!|\*])(.*?)\*/~', '', $css);
        // Remove ; before }
        $css = preg_replace('/;(?=\s*})/', '', $css);
        // Remove space after , : ; { } */ >
        $css = preg_replace('/(,|:|;|\{|}|\*\/|>) /', '$1', $css);
        // Remove space before , ; { } ( ) >
        $css = preg_replace('/ (,|;|\{|}|>)/', '$1', $css);
        // Strips leading 0 on decimal values (converts 0.5px into .5px)
        $css = preg_replace('/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css);
        // Strips units if value is 0 (converts 0px to 0)
        $css = preg_replace('/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css);
        // Converts all zeros value into short-hand
        $css = preg_replace('/0 0 0 0/', '0', $css);
        // Shortern 6-character hex color codes to 3-character where possible
        $css = preg_replace('/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css);

        return trim( $css );

    }
}

/*** Get form Mailchimp ***/
if ( ! function_exists('mipro_get_mailchimp_forms') ) {
    function mipro_get_mailchimp_forms() {
        global $post;
        $args = array(
            'post_type' => 'mc4wp-form',
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $results = array();
        $forms = new WP_Query( $args );

        if ( $forms->have_posts() ) {
            while ( $forms->have_posts() ) {
                $forms->the_post();
                $results[] = array(
                    'id' => $post->ID,
                    'title' => $post->post_title,
                );
            }
        }

        wp_reset_postdata();
        return $results;
    }
}

/* Header Mobile button */
if ( ! function_exists('mipro_header_mobile_button') ) {
    function mipro_header_mobile_button() {
        ?>

        <div class="mobile-nav"><a href="#"><i class="icon-menu"></i></a></div>

        <?php

    }
}

/* Header Mobile Navigation */
if ( ! function_exists('mipro_header_mobile_navigation') ) {
    function mipro_header_mobile_navigation() {
        ?>
        <?php if ( ! is_page_template('blank.php') ) : ?>

            <div class="kft-mobile-navigation">
                <?php if ( mipro_get_opt('kft_enable_search') ) : ?>
                    <?php echo mipro_search_by_category( false ); ?>
                <?php endif; ?>

                <div class="mobile-menu-wrapper">
                    <?php
                    if ( has_nav_menu('mobile') ) {
                        wp_nav_menu( array( 'theme_location' => 'mobile', 'menu_class' => 'site-mobile-menu', 'container_class' => 'mobile-nav-wrapper' ) );
                    } else {
                        wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'mobile-nav-wrapper') );
                    }
                    ?>
                </div>
            </div>
            <?php

        endif;
    }
    add_action('mipro_after_body_open', 'mipro_header_mobile_navigation', 10);
}

/* Social Button */
if ( ! function_exists('mipro_social_button') ) {
    function mipro_social_button() {
        if ( wp_is_mobile() && ! mipro_get_opt('kft_social_button_mobile') || ! wp_is_mobile() && mipro_get_opt('kft_social_button') ) {
            ?>

            <div class="mipro-social-button <?php echo esc_attr( 'social-' . mipro_get_opt('kft_social_position') ); ?>">
                <?php if ( mipro_get_opt('kft_social_type') == 'share' && function_exists('mipro_template_social_sharing' ) ) : ?>
                <?php mipro_template_social_sharing(); ?>

                <?php elseif ( mipro_get_opt('kft_social_type') == 'follow' && function_exists('mipro_template_social_network') ) : ?>
                <?php mipro_template_social_network(); ?>
            <?php endif; ?>
        </div>

        <?php
    }
}
add_action('wp_footer', 'mipro_social_button');
}

/* Cookie Notice */
if ( ! function_exists('mipro_cookie_notice') ) {
    function mipro_cookie_notice() {
        if ( ! mipro_get_opt('kft_cookie_notice') ) {
            return;
        }
        $page_cookie = mipro_get_opt('kft_cookie_info_link');
        ?>

        <div class="mipro-cookie-notice">
            <div class="cookie-wrapper">
                <div class="cookie-text">
                    <?php echo mipro_get_opt('kft_cookie_text'); ?>
                </div>
                <div class="cookie-button">
                    <?php if ( $page_cookie ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $page_cookie ) ); ?>" class="cookie-info">
                            <?php esc_html_e( 'Read more', 'mipro' ); ?>
                        </a>
                    <?php endif; ?>
                    <a href="#" class="cookie-accept"><?php esc_html_e( 'Accept', 'mipro' ); ?></a>
                </div>
            </div>
        </div>

        <?php
    }
    add_action('wp_footer', 'mipro_cookie_notice');
}

/** Custom 404 Page * */
if ( ! function_exists('mipro_custom_404_page') ) {
    function mipro_custom_404_page( $page_template ) {
        global $wp_query;
        $custom_404 = mipro_get_opt( 'kft_custom_404_page' );
        if ( mipro_get_opt( 'kft_enable_custom_404_page' ) && ! empty( $custom_404 ) ) {
            $wp_query->query( 'page_id=' . $custom_404 );
            $wp_query->the_post();
            $page_template = get_page_template();
            rewind_posts();
        }

        return $page_template;
    }
    add_filter( '404_template', 'mipro_custom_404_page', 999 );
}

/** Maintenance Mode * */
if ( ! function_exists('mipro_maintenance_mode') ) {
    function mipro_maintenance_mode() {
        $maintenance_page = mipro_get_opt( 'kft_maintenance_mode_page' );
        if( ! mipro_get_opt( 'kft_maintenance_mode' ) || is_user_logged_in() || empty( $maintenance_page ) ) {
            return;
        }

        if( ! is_user_logged_in() && ! is_page( $maintenance_page ) ) {
            wp_redirect( get_permalink( $maintenance_page ) );
            exit();
        }
    }
    add_action( 'template_redirect', 'mipro_maintenance_mode');
}

/** Fonts handling. **/
if ( ! function_exists( 'mipro_upload_mimes' ) ) {
    add_filter( 'upload_mimes', 'mipro_upload_mimes' );
    function mipro_upload_mimes( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        $mimes['woff'] = 'font/woff';
        $mimes['woff2'] = 'font/woff2';
        $mimes['ttf'] = 'font/ttf';
        $mimes['eot'] = 'font/eot';

        return $mimes;
    }
}

/* * * Get custom fields ** */
if ( ! function_exists('mipro_get_custom_field') ) {
    function mipro_get_custom_field( $defaults, $field ) {
        $field = (array) $field;
        $custom_field = array();
        foreach ( $defaults as $name => $default ) {
            if ( array_key_exists( $name, $field ) ) {
                if ( is_array( $field[$name] ) && is_array( $default ) ) {
                    $custom_field[$name] = mipro_get_custom_field( $default, $field[$name] );
                } else {
                    $custom_field[$name] = $field[$name];
                }
            } else {
                $custom_field[$name] = $default;
            }
        }
        return $custom_field;
    }
}

/* Lazy Loading */
function mipro_lazy_loading( $attr, $attachment, $size ) {
    if ( $attachment ) {
        $attr['data-src'] = $attr['src'];
        $image = wp_get_attachment_image_src( $attachment->ID, $size );
        $attr['src'] = get_parent_theme_file_uri( '/assets/images/loading.gif' );
        $lazy_class = 'lazyload';
        $attr['class'] = ( isset( $attr['class'] ) ? $attr['class'] . " {$lazy_class}" : $lazy_class );
        if ( isset( $attr['srcset'] ) ) {
            $attr['data-srcset'] = $attr['srcset'];
            unset( $attr['srcset'], $attr['sizes'] );
        }

        $attr['class'] = ( isset( $attr['class'] ) ? $attr['class'] : '' );
    }

    return $attr;
}

/* Function to display number for posts. */
function mipro_get_post_views( $postID ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $postID, $count_key, true );

    if ( $count == '' ) {
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return "0";
    }

    return $count;
}

/* Function to display count views for post. */
function mipro_set_post_views( $postID ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $postID, $count_key, true );

    if ( $count == '' ) {
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

/* Change footer page */
if ( ! class_exists('AluraStudio_Demo') ) {
    add_filter( 'widget_display_callback', 'mipro_footer_callback', 10, 3 );
    function mipro_footer_callback( $instance, $object, $args ) {
        global $post;

        if ( is_page() && get_class( $object ) == 'Mipro_Footer_Widget' ) {
            if ( $args['name'] == esc_html__( 'Footer Top', 'mipro' ) ) {
                $block_id = get_post_meta( $post->ID, 'kft_footer_top', true );
            } elseif ( $args['name'] == esc_html__( 'Footer Bottom', 'mipro' ) ) {
                $block_id = get_post_meta( $post->ID, 'kft_footer_bottom', true );
            } else {
                $block_id = get_post_meta( $post->ID, 'kft_footer_middle', true );
            }
            if ( $block_id ) {
                $instance['block_id'] = $block_id;
            }
        }
        
        return $instance;
    }
}
