<?php
/**
 * Active King Pro
 */
define('KC_LICENSE', 'plild623-tq7t-5krl-q2nr-ycp4-xqbkwkox8xh7');

/**
 * KingComposer map
 * (c) Joyce
 */
add_action('init', 'mipro_kc_map_shortcode', 99);
function mipro_kc_map_shortcode() {

    if ( ! function_exists('kc_add_map') ) {
        return;
    }

    $product_args = array(
        'taxonomy' => 'product_cat',
        'orderby' => 'name',
        'show_count' => 0,
        'pad_counts' => 0,
        'hierarchical' => 1,
        'title_li' => '',
        'hide_empty' => 0,
    );

    $product_categories = get_categories( $product_args );
    $product_cats = array();

    foreach ( $product_categories as $cat ) {
        $product_cats[$cat->term_id] = $cat->name;
    }

    /*** Counter Up Shortcode ***/
    kc_add_map( array(
        'kft_counter' => array(
            'name' => esc_html__('Counter Up', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'sl-paper-plane',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Number', 'mipro'),
                        'name' => 'number',
                        'admin_label' => true,
                        'value' => '0',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Subject', 'mipro'),
                        'name' => 'meta',
                        'admin_label' => true,
                        'value' => '',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro')),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                    array('property' => 'background'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro')),
                                ),
                                esc_html__('Number', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.number'),
                                ),
                                esc_html__('Subject', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.meta'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.meta'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/*** Video Shortcode ***/
    kc_add_map(array(
        'kft_video' => array(
            'name' => esc_html__('Video', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-play',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Video Url', 'mipro'),
                    'name' => 'src',
                    'admin_label' => true,
                    'value' => '',
                    'description' => esc_html__('Add link Vimeo or Youtube Video', 'mipro'),
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Size', 'mipro'),
                    'name' => 'size',
                    'options' => array(
                        'auto-size' => esc_html__('Auto Size', 'mipro'),
                        'set-size' => esc_html__('Set Size', 'mipro'),
                    ),
                    'value' => 'auto-size',
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Width', 'mipro'),
                    'name' => 'width',
                    'value' => '800',
                    'description' => esc_html__('Ex: 800', 'mipro'),
                    'relation' => array('parent' => 'size', 'show_when' => array('set-size')),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Height', 'mipro'),
                    'name' => 'height',
                    'value' => '450',
                    'description' => esc_html__('Ex: 450', 'mipro'),
                    'relation' => array('parent' => 'size', 'show_when' => array('set-size')),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Extra Class', 'mipro'),
                    'name' => 'class',
                ),
            ),
        ),
    ));

/***  Product Categories Shortcode ***/
    kc_add_map(array(
        'kft_product_categories' => array(
            'name' => esc_html__('Product Categories', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-list ',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                        'value' => '',
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Categories Layout', 'mipro'),
                        'name' => 'layout',
                        'admin_label' => false,
                        'options' => array(
                            'grid' => esc_html__('Grid', 'mipro'),
                            'masonry' => esc_html__('Masonry', 'mipro'),
                            'slider' => esc_html__('Slider', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Columns', 'mipro'),
                        'name' => 'columns',
                        'admin_label' => true,
                        'value' => '4',
                        'options' => array(
                            'min' => '1',
                            'max' => '8',
                        ),
                        'description' => esc_html__('Number of Columns', 'mipro'),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Rows', 'mipro'),
                        'name' => 'rows',
                        'admin_label' => true,
                        'value' => '1',
                        'options' => array(
                            'min' => '1',
                            'max' => '4',
                        ),
                        'description' => esc_html__('Number of Rows', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Limit', 'mipro'),
                        'name' => 'per_page',
                        'admin_label' => true,
                        'value' => 5,
                        'description' => esc_html__('Number of Product Categories', 'mipro'),
                    ),
                    array(
                        'type' => 'multiple',
                        'label' => esc_html__('Product Categories', 'mipro'),
                        'name' => 'ids',
                        'options' => $product_cats,
                        'description' => esc_html__('List of product categories', 'mipro'),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Hide empty product categories', 'mipro'),
                        'name' => 'hide_empty',
                        'description' => '',
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show product category title', 'mipro'),
                        'name' => 'show_title',
                        'value' => 'yes',
                        'description' => '',
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show product category description', 'mipro'),
                        'name' => 'show_description',
                        'description' => '',
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show navigation button', 'mipro'),
                        'name' => 'show_nav',
                        'value' => 'yes',
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show dots button', 'mipro'),
                        'name' => 'dots',
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Auto play', 'mipro'),
                        'name' => 'auto_play',
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Margin', 'mipro'),
                        'name' => 'margin',
                        'value' => '30',
                        'description' => esc_html__('Set margin between items', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Desktop small items', 'mipro'),
                        'name' => 'desksmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '5',
                        ),
                        'value' => '4',
                        'description' => esc_html__('Set items on 991px', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Tablet items', 'mipro'),
                        'name' => 'tablet',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '5',
                        ),
                        'value' => '3',
                        'description' => esc_html__('Set items on 768px', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Tablet mini items', 'mipro'),
                        'name' => 'tabletmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '4',
                        ),
                        'value' => '2',
                        'description' => esc_html__('Set items on 640px', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Mobile items', 'mipro'),
                        'name' => 'mobile',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '4',
                        ),
                        'value' => '2',
                        'description' => esc_html__('Set items on 480px', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Mobile small items', 'mipro'),
                        'name' => 'mobilesmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '3',
                        ),
                        'value' => '1',
                        'description' => esc_html__('Set items on 0px', 'mipro'),
                        'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro')),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                    array('property' => 'background'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro')),
                                ),
                                esc_html__('Image', 'mipro') => array(
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'float', 'label' => esc_html__('Float', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.category-image'),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro'), 'selector' => '.category-image'),
                                ),
                                esc_html__('Content', 'mipro') => array(
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'float', 'label' => esc_html__('Float', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.category-content'),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro'), 'selector' => '.category-content'),
                                ),
                                esc_html__('Categories Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.category-content .product-title'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.category-content .product-title'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/*** Products Deals Shortcode ***/
    kc_add_map(array(
        'kft_products_deals' => array(
            'name' => esc_html__('Products Deals', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-clock-o',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                        'value' => '',
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Product Layout', 'mipro'),
                        'name' => 'product_layout',
                        'admin_label' => false,
                        'options' => array(
                            'grid' => esc_html__('Grid', 'mipro'),
                            'masonry' => esc_html__('Masonry', 'mipro'),
                            'slider' => esc_html__('Slider', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Style', 'mipro'),
                        'name' => 'style',
                        'admin_label' => false,
                        'options' => array(
                            'default' => esc_html__('Default', 'mipro'),
                            'overlay' => esc_html__('Overlay', 'mipro'),
                            'shade' => esc_html__('Shade', 'mipro'),
                            'vertical' => esc_html__('Vertical', 'mipro'),
                            'label' => esc_html__('Label', 'mipro'),
                            'push' => esc_html__('Push', 'mipro'),
                            'badge' => esc_html__('Badge', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Product type', 'mipro'),
                        'name' => 'product_type',
                        'admin_label' => true,
                        'options' => array(
                            'recent' => esc_html__('Recent', 'mipro'),
                            'sale' => esc_html__('Sale', 'mipro'),
                            'featured' => esc_html__('Featured', 'mipro'),
                            'best_selling' => esc_html__('Best Selling', 'mipro'),
                            'top_rated' => esc_html__('Top Rated', 'mipro'),
                            'mixed_order' => esc_html__('Mixed Order', 'mipro'),
                        ),
                        'description' => esc_html__('Select type of product', 'mipro'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Order by', 'mipro'),
                        'name' => 'orderby',
                        'admin_label' => false,
                        'options' => array(
                            '' => esc_html__('None', 'mipro'),
                            'ID' => esc_html__('ID', 'mipro'),
                            'date' => esc_html__('Date', 'mipro'),
                            'name' => esc_html__('Name', 'mipro'),
                            'title' => esc_html__('Title', 'mipro'),
                            'comment_count' => esc_html__('Comment count', 'mipro'),
                            'rand' => esc_html__('Random', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Sorting', 'mipro'),
                        'name' => 'order',
                        'admin_label' => false,
                        'options' => array(
                            '' => esc_html__('None', 'mipro'),
                            'DESC' => esc_html__('Descending', 'mipro'),
                            'ASC' => esc_html__('Ascending', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Rows', 'mipro'),
                        'name' => 'rows',
                        'admin_label' => true,
                        'value' => 1,
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Columns', 'mipro'),
                        'name' => 'columns',
                        'admin_label' => true,
                        'value' => 4,
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Per Page', 'mipro'),
                        'name' => 'per_page',
                        'admin_label' => true,
                        'value' => 5,
                        'description' => esc_html__('Number of Products', 'mipro'),
                    ),
                    array(
                        'type' => 'multiple',
                        'label' => esc_html__('Product Categories', 'mipro'),
                        'name' => 'product_cats',
                        'options' => $product_cats,
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Sale Countdown', 'mipro'),
                        'name' => 'show_countdown',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show Gallery', 'mipro'),
                        'name' => 'show_gallery',
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show Description', 'mipro'),
                        'name' => 'show_description',
                        'admin_label' => true,
                        'relation' => array('parent' => 'style', 'show_when' => array('vertical')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show navigation button', 'mipro'),
                        'name' => 'nav',
                        'value' => 'yes',
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show dots button', 'mipro'),
                        'name' => 'dots',
                        'admin_label' => false,
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Auto play', 'mipro'),
                        'name' => 'autoplay',
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Margin', 'mipro'),
                        'name' => 'margin',
                        'admin_label' => false,
                        'value' => '30',
                        'description' => esc_html__('Set margin between items', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Desktop small items', 'mipro'),
                        'name' => 'desksmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '5',
                        ),
                        'value' => '4',
                        'description' => esc_html__('Set items on 991px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Tablet items', 'mipro'),
                        'name' => 'tablet',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '4',
                        ),
                        'value' => '3',
                        'description' => esc_html__('Set items on 768px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Tablet mini items', 'mipro'),
                        'name' => 'tabletmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '4',
                        ),
                        'value' => '2',
                        'description' => esc_html__('Set items on 640px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Mobile items', 'mipro'),
                        'name' => 'mobile',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '3',
                        ),
                        'value' => '2',
                        'description' => esc_html__('Set items on 480px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Mobile small items', 'mipro'),
                        'name' => 'mobilesmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '3',
                        ),
                        'value' => '1',
                        'description' => esc_html__('Set items on 0px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                ),
            ),
        ),
    ));

/*** Products Widget Shortcode ***/
    kc_add_map(array(
        'kft_products_widget' => array(
            'name' => esc_html__('Products Widget', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-star',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Title', 'mipro'),
                    'name' => 'title',
                    'admin_label' => true,
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Product type', 'mipro'),
                    'name' => 'product_type',
                    'admin_label' => true,
                    'options' => array(
                        'recent' => esc_html__('Recent', 'mipro'),
                        'sale' => esc_html__('Sale', 'mipro'),
                        'featured' => esc_html__('Featured', 'mipro'),
                        'best_selling' => esc_html__('Best Selling', 'mipro'),
                        'top_rated' => esc_html__('Top Rated', 'mipro'),
                        'mixed_order' => esc_html__('Mixed Order', 'mipro'),
                    ),
                    'description' => esc_html__('Select type of product', 'mipro'),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Limit', 'mipro'),
                    'name' => 'per_page',
                    'admin_label' => true,
                    'value' => 6,
                    'description' => esc_html__('Number of Products', 'mipro'),
                ),
                array(
                    'type' => 'multiple',
                    'label' => esc_html__('Product Categories', 'mipro'),
                    'name' => 'product_cats',
                    'options' => $product_cats,
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show product image', 'mipro'),
                    'name' => 'show_image',
                    'value' => 'yes',
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Thumbnail size', 'mipro'),
                    'name' => 'thumbnail_size',
                    'admin_label' => true,
                    'options' => array(
                        'shop_thumbnail' => esc_html__('Thumbnails', 'mipro'),
                        'shop_catalog' => esc_html__('Catalog Images', 'mipro'),
                        'shop_single' => esc_html__('Single Product Image', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show product name', 'mipro'),
                    'name' => 'show_title',
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show product price', 'mipro'),
                    'name' => 'show_price',
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show product rating', 'mipro'),
                    'name' => 'show_rating',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show product categories', 'mipro'),
                    'name' => 'show_categories',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show in a carousel slider', 'mipro'),
                    'name' => 'is_slider',
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Row', 'mipro'),
                    'name' => 'rows',
                    'admin_label' => false,
                    'value' => 3,
                    'description' => esc_html__('Number of Rows for slider', 'mipro'),
                    'relation' => array('parent' => 'is_slider', 'show_when' => 'yes'),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show navigation button', 'mipro'),
                    'name' => 'show_nav',
                    'relation' => array('parent' => 'is_slider', 'show_when' => 'yes'),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Auto play', 'mipro'),
                    'name' => 'auto_play',
                    'relation' => array('parent' => 'is_slider', 'show_when' => 'yes'),
                ),
            ),
        ),
    ));

/*** Products Shortcode ***/
    kc_add_map(array(
        'kft_products' => array(
            'name' => esc_html__('Products', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-hand-peace-o',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Product Layout', 'mipro'),
                        'name' => 'product_layout',
                        'admin_label' => false,
                        'options' => array(
                            'grid' => esc_html__('Grid', 'mipro'),
                            'masonry' => esc_html__('Masonry', 'mipro'),
                            'slider' => esc_html__('Slider', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Style', 'mipro'),
                        'name' => 'style',
                        'admin_label' => false,
                        'options' => array(
                            'default' => esc_html__('Default', 'mipro'),
                            'default no-rate' => esc_html__('Default No rate', 'mipro'),
                            'hover-bot' => esc_html__('Hover Bot', 'mipro'),
                            'overlay' => esc_html__('Overlay', 'mipro'),
                            'overlay overlay-min' => esc_html__('Overlay Min', 'mipro'),
                            'overlay overlay-left' => esc_html__('Overlay Min Left', 'mipro'),
                            'shade' => esc_html__('Shade', 'mipro'),
                            'vertical' => esc_html__('Vertical', 'mipro'),
                            'label' => esc_html__('Label', 'mipro'),
                            'push' => esc_html__('Push', 'mipro'),
                            'badge' => esc_html__('Badge', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Product type', 'mipro'),
                        'name' => 'product_type',
                        'admin_label' => true,
                        'options' => array(
                            'recent' => esc_html__('Recent', 'mipro'),
                            'sale' => esc_html__('Sale', 'mipro'),
                            'featured' => esc_html__('Featured', 'mipro'),
                            'best_selling' => esc_html__('Best Selling', 'mipro'),
                            'top_rated' => esc_html__('Top Rated', 'mipro'),
                            'mixed_order' => esc_html__('Mixed Order', 'mipro'),
                        ),
                        'description' => esc_html__('Select type of product', 'mipro'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Order by', 'mipro'),
                        'name' => 'orderby',
                        'admin_label' => false,
                        'options' => array(
                            '' => esc_html__('None', 'mipro'),
                            'ID' => esc_html__('ID', 'mipro'),
                            'date' => esc_html__('Date', 'mipro'),
                            'name' => esc_html__('Name', 'mipro'),
                            'title' => esc_html__('Title', 'mipro'),
                            'comment_count' => esc_html__('Comment count', 'mipro'),
                            'rand' => esc_html__('Random', 'mipro'),
                        ),
                        'description' => esc_html__('If you choose "Order by". Product will don\'t show with "Product type"', 'mipro'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Sorting', 'mipro'),
                        'name' => 'order',
                        'admin_label' => false,
                        'options' => array(
                            '' => esc_html__('None', 'mipro'),
                            'DESC' => esc_html__('Descending', 'mipro'),
                            'ASC' => esc_html__('Ascending', 'mipro'),
                        ),
                        'description' => esc_html__('If you choose "Sorting". Product will don\'t show with "Product type"', 'mipro'),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Rows', 'mipro'),
                        'name' => 'rows',
                        'admin_label' => true,
                        'value' => 1,
                        'options' => array(
                            'min' => 1,
                            'max' => 4,
                        ),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Columns', 'mipro'),
                        'name' => 'columns',
                        'admin_label' => true,
                        'value' => 4,
                        'options' => array(
                            'min' => 1,
                            'max' => 6,
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Per Page', 'mipro'),
                        'name' => 'per_page',
                        'admin_label' => true,
                        'value' => 5,
                        'description' => esc_html__('Number of Products', 'mipro'),
                    ),
                    array(
                        'type' => 'multiple',
                        'label' => esc_html__('Product Categories', 'mipro'),
                        'name' => 'product_cats',
                        'options' => $product_cats,
                    ),
                    array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show category', 'mipro'),
                    'name' => 'show_cate',
                    'admin_label' => false,
                     ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Sale Countdown', 'mipro'),
                        'name' => 'show_countdown',
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show load more button', 'mipro'),
                        'name' => 'show_load_more',
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('grid', 'masonry')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Load more text', 'mipro'),
                        'name' => 'load_more_text',
                        'value' => 'Show more',
                        'relation' => array('parent' => 'show_load_more', 'show_when' => 'yes'),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show navigation button', 'mipro'),
                        'name' => 'nav',
                        'value' => 'yes',
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show dots button', 'mipro'),
                        'name' => 'dots',
                        'admin_label' => false,
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Auto play', 'mipro'),
                        'name' => 'autoplay',
                        'admin_label' => false,
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Margin', 'mipro'),
                        'name' => 'margin',
                        'admin_label' => false,
                        'value' => '30',
                        'description' => esc_html__('Set margin between items', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Desktop small items', 'mipro'),
                        'name' => 'desksmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '5',
                        ),
                        'value' => '4',
                        'description' => esc_html__('Set items on 991px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Tablet items', 'mipro'),
                        'name' => 'tablet',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '5',
                        ),
                        'value' => '3',
                        'description' => esc_html__('Set items on 768px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Tablet mini items', 'mipro'),
                        'name' => 'tabletmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '4',
                        ),
                        'value' => '2',
                        'description' => esc_html__('Set items on 640px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Mobile items', 'mipro'),
                        'name' => 'mobile',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '3',
                        ),
                        'value' => '2',
                        'description' => esc_html__('Set items on 480px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Mobile small items', 'mipro'),
                        'name' => 'mobilesmini',
                        'admin_label' => false,
                        'options' => array(
                            'min' => '1',
                            'max' => '3',
                        ),
                        'value' => '1',
                        'description' => esc_html__('Set items on 0px', 'mipro'),
                        'relation' => array('parent' => 'product_layout', 'show_when' => array('slider')),
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro')),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                ),
                                esc_html__('Images', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.kft-product .images>a'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.kft-product .images>a'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.kft-product .images>a'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.kft-product .images>a'),
                                ),
                                esc_html__('Meta', 'mipro') => array(
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.kft-product .item-information'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.kft-product .item-information'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.kft-product .item-information'),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.kft-product .item-information'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.kft-product .item-information'),
                                ),
                                esc_html__('Product Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.product-name>a'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.product-name>a'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ));

/*** Countdown ***/
    kc_add_map(array(
        'kft_countdown' => array(
            'name' => esc_html__('Countdown', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-sort-numeric-desc',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Date', 'mipro'),
                        'name' => 'date',
                        'value' => '2018/12/12',
                        'description' => esc_html__('Final date in the format Y/m/d. For example 2018/12/12', 'mipro'),
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro')),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                    array('property' => 'background'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro')),
                                ),
                                esc_html__('Box', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.countdown-timer > div'),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro'), 'selector' => '.countdown-timer > div'),
                                ),
                                esc_html__('Number', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.number'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.number'),
                                ),
                                esc_html__('Meta', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.countdown-meta'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.countdown-meta'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/*** Google Map ***/
/*
    kc_add_map(array(
        'kft_google_map' => array(
            'name' => esc_html__('Google Map', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-map-o',
            'is_container' => true,
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Address', 'mipro'),
                        'admin_label' => true,
                        'name' => 'address',
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Zoom', 'mipro'),
                        'name' => 'zoom',
                        'value' => 12,
                        'options' => array(
                            'min' => 0,
                            'max' => 20,
                        ),
                        'description' => esc_html__('Input a number between 0 and 20', 'mipro'),
                    ),
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('Map Icon', 'mipro'),
                        'name' => 'icon',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => esc_html__('Style (Json)', 'mipro'),
                        'name' => 'styles',
                        'description' => wp_kses(__('You can add Google Maps styles on the website: <a target="_blank" href="http://snazzymaps.com/">Snazzy Maps</a><br>Ex: [{"featureType":"administrative","parentType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","parentType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","parentType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","parentType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","parentType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","parentType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","parentType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","parentType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]', 'mipro'), array('a' => array('href' => array(), 'target' => array()), 'br' => array())),
                    ),
                    array(
                        'type' => 'toggle',
                        'label' => esc_html__('Show Content', 'mipro'),
                        'name' => 'show_content',
                        'description' => esc_html__('Show content information on Map', 'mipro'),
                    ),
                    array(
                        'type' => 'textarea_html',
                        'label' => esc_html__('Content', 'mipro'),
                        'name' => 'content',
                        'relation' => array('parent' => 'show_content', 'show_when' => 'yes'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Content Position', 'mipro'),
                        'name' => 'content_position',
                        'options' => array(
                            'top_left' => esc_html__('Top Left', 'mipro'),
                            'top_center' => esc_html__('Top Center', 'mipro'),
                            'top_right' => esc_html__('Top Right', 'mipro'),
                            'center_left' => esc_html__('Center Left', 'mipro'),
                            'center' => esc_html__('Center', 'mipro'),
                            'center_right' => esc_html__('Center Right', 'mipro'),
                            'bottom_left' => esc_html__('Bottom Left', 'mipro'),
                            'bottom_center' => esc_html__('Bottom Center', 'mipro'),
                            'bottom_right' => esc_html__('Bottom Right', 'mipro'),
                        ),
                        'relation' => array('parent' => 'show_content', 'show_when' => 'yes'),
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro')),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                ),
                                esc_html__('Content', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro'), 'selector' => '.google-map-content'),
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.google-map-content *'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.google-map-content'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    )); */

/*** Brands Shortcode ***/
    $brand_args = array(
        'taxonomy' => 'kft_brand_cat'
        , 'hierarchical' => 1
        , 'hide_empty' => 0
        , 'parent' => 0
        , 'title_li' => ''
        , 'child_of' => 0,
    );
    $brand_cats = get_categories($brand_args);
    $brand_categories = array();

    foreach ($brand_cats as $brand_cat) {
        $brand_categories[$brand_cat->term_id] = $brand_cat->name;
    }

    kc_add_map(array(
        'kft_brands_slider' => array(
            'name' => esc_html__('Brands Slider', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-picture-o ',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Block title', 'mipro'),
                    'name' => 'title',
                    'admin_label' => true,
                ),
                array(
                    'type' => 'multiple',
                    'label' => esc_html__('Brand Categories', 'mipro'),
                    'name' => 'categories',
                    'admin_label' => true,
                    'options' => $brand_categories,
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Limit', 'mipro'),
                    'name' => 'per_page',
                    'admin_label' => true,
                    'value' => '7',
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Rows', 'mipro'),
                    'name' => 'rows',
                    'admin_label' => true,
                    'options' => array(
                        'min' => 1,
                        'max' => 3,
                    ),
                    'value' => 1,
                    'description' => esc_html__('Number of Rows', 'mipro'),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Columns', 'mipro'),
                    'name' => 'columns',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                    'value' => '4',
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Margin', 'mipro'),
                    'name' => 'margin_image',
                    'admin_label' => false,
                    'value' => '30',
                    'description' => esc_html__('Set margin between items', 'mipro'),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Activate link', 'mipro'),
                    'name' => 'active_link',
                    'admin_label' => false,
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show navigation button', 'mipro'),
                    'name' => 'nav',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Autoplay', 'mipro'),
                    'name' => 'autoplay',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Desktop small items', 'mipro'),
                    'name' => 'desksmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                    'value' => '4',
                    'description' => esc_html__('Set items on 991px', 'mipro'),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet items', 'mipro'),
                    'name' => 'tablet',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                    'value' => '3',
                    'description' => esc_html__('Set items on 768px', 'mipro'),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet mini items', 'mipro'),
                    'name' => 'tabletmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '5',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 640px', 'mipro'),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile items', 'mipro'),
                    'name' => 'mobile',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 480px', 'mipro'),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile small items', 'mipro'),
                    'name' => 'mobilesmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 0px', 'mipro'),
                ),
            ),
        ),
    ));

/* Testimonials */
    kc_add_map(array(
        'kft_testimonials' => array(
            'name' => esc_html__('Testimonials', 'mipro'),
            'title' => esc_html__('Testimonials', 'mipro'),
            'nested' => true,
            'accept_child' => 'kft_testimonial,kc_testimonial',
            'category' => 'Custom Element',
            'icon' => 'fa-users',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Title', 'mipro'),
                    'name' => 'title',
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Layout', 'mipro'),
                    'name' => 'layout',
                    'options' => array(
                        'slider' => esc_html__('Slider', 'mipro'),
                        'grid' => esc_html__('Grid', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Style', 'mipro'),
                    'name' => 'style',
                    'options' => array(
                        'default' => esc_html__('Default', 'mipro'),
                        'boxed' => esc_html__('Boxed', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Columns', 'mipro'),
                    'name' => 'columns',
                    'value' => '1',
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Margin', 'mipro'),
                    'name' => 'margin',
                    'value' => '30',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => 'slider',
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Autoplay', 'mipro'),
                    'name' => 'autoplay',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => array('slider'),
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show Navigation', 'mipro'),
                    'name' => 'show_nav',
                    'group' => 'Slider Options',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => array('slider'),
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show dots', 'mipro'),
                    'name' => 'show_dots',
                    'group' => 'Slider Options',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => array('slider'),
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Extra class name', 'mipro'),
                    'name' => 'extra_class',
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Desktop small items', 'mipro'),
                    'name' => 'desksmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '3',
                    'description' => esc_html__('Set items on 991px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet items', 'mipro'),
                    'name' => 'tablet',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 768px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet mini items', 'mipro'),
                    'name' => 'tabletmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 640px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile items', 'mipro'),
                    'name' => 'mobile',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 480px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile small items', 'mipro'),
                    'name' => 'mobilesmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 0px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
            ),
        ),
    ));

    kc_add_map(array(
        'kft_testimonial' => array(
            'name' => esc_html__('Testimonial', 'mipro'),
            'accept_parent' => 'kft_testimonials',
            'category' => 'Custom Element',
            'icon' => 'fa-user',
            'is_container' => true,
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('User Avatar', 'mipro'),
                        'name' => 'image',
                        'description' => esc_html__('Select image from media library.', 'mipro'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Image Width', 'mipro'),
                        'name' => 'img_width',
                        'value' => '80',
                        'description' => esc_html__('Example: 80', 'mipro'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Image Position', 'mipro'),
                        'name' => 'image_position',
                        'admin_label' => false,
                        'options' => array(
                            'top' => esc_html__('Top', 'mipro'),
                            'center' => esc_html__('Center', 'mipro'),
                            'left' => esc_html__('Left', 'mipro'),
                            'right' => esc_html__('Right', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Name', 'mipro'),
                        'name' => 'name',
                        'admin_label' => true,
                        'description' => esc_html__('User name', 'mipro'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Company', 'mipro'),
                        'name' => 'company',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea_html',
                        'label' => esc_html__('Text', 'mipro'),
                        'name' => 'content',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Extra class name', 'mipro'),
                        'name' => 'extra_class',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.testimonial-wrapper'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.testimonial-wrapper'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.testimonial-wrapper'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.testimonial-wrapper'),
                                ),
                                esc_html__('Image', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.avatar'),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro'), 'selector' => '.avatar'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.avatar'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.avatar'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.avatar img'),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.avatar'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.avatar'),
                                    array('property' => 'float', 'label' => esc_html__('Float', 'mipro'), 'selector' => '.avatar'),
                                ),
                                esc_html__('Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.name'),
                                ),
                                esc_html__('Company', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.company'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.company'),
                                ),
                                esc_html__('Description', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.excerpt'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.excerpt'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ));

/*** Banner Shortcode ***/
    kc_add_map(array(
        'kft_banners' => array(
            'name' => esc_html__('Banners Slider', 'mipro'),
            'title' => esc_html__('Banners Slider', 'mipro'),
            'nested' => true,
            'accept_child' => 'kft_banner',
            'category' => 'Custom Element',
            'icon' => 'fa-sliders',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Title', 'mipro'),
                    'name' => 'title',
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Columns', 'mipro'),
                    'name' => 'columns',
                    'value' => '1',
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Margin', 'mipro'),
                    'name' => 'margin',
                    'value' => '30',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => 'slider',
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Autoplay', 'mipro'),
                    'name' => 'autoplay',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => array('slider'),
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show Navigation', 'mipro'),
                    'name' => 'show_nav',
                    'group' => 'Slider Options',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => array('slider'),
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show dots', 'mipro'),
                    'name' => 'show_dots',
                    'group' => 'Slider Options',
                    'relation' => array(
                        'parent' => 'layout',
                        'show_when' => array('slider'),
                    ),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Extra class name', 'mipro'),
                    'name' => 'extra_class',
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Desktop small items', 'mipro'),
                    'name' => 'desksmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '3',
                    'description' => esc_html__('Set items on 991px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet items', 'mipro'),
                    'name' => 'tablet',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 768px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet mini items', 'mipro'),
                    'name' => 'tabletmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 640px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile items', 'mipro'),
                    'name' => 'mobile',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 480px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile small items', 'mipro'),
                    'name' => 'mobilesmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 0px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
            ),
        ),
    ));

    kc_add_map(array(
        'kft_banner' => array(
            'name' => esc_html__('Banner', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-file-image-o',
            'is_container' => true,
            'params' => array(

                esc_html__('General', 'mipro') => array(
                     array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => false,
                        'value' => '',
                       
                    ),
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('Background Image', 'mipro'),
                        'name' => 'bg_image',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Image Size', 'mipro'),
                        'name' => 'image_size',
                        'admin_label' => false,
                        'value' => 'full',
                        'description' => esc_html__('Ex: "thumbnail", "medium", "large", "full" or "600x400"', 'mipro'),
                    ),
                    array(
                        'type' => 'color_picker',
                        'label' => esc_html__('Overlay', 'mipro'),
                        'name' => 'overlay',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'link',
                        'label' => esc_html__('Link', 'mipro'),
                        'name' => 'link',
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Hover Effect', 'mipro'),
                        'name' => 'hover_effect',
                        'admin_label' => false,
                        'options' => array(
                            'none' => esc_html__('None', 'mipro'),
                            'parallax' => esc_html__('Parallax', 'mipro'),
                            'zoom' => esc_html__('Zoom', 'mipro'),
                            'zoom-long' => esc_html__('Zoom Long', 'mipro'),
                            'zoom-fade' => esc_html__('Zoom Fade', 'mipro'),
                            'blur' => esc_html__('Blur', 'mipro'),
                            'fade-in' => esc_html__('Fade In', 'mipro'),
                            'fade-out' => esc_html__('Fade Out', 'mipro'),
                            'color' => esc_html__('Color', 'mipro'),
                            'grayscale' => esc_html__('Grayscale', 'mipro'),
                        ),
                        'description' => esc_html__('Add Hover Effect on Image', 'mipro'),
                    ),
                    array(
                        'type' => 'textarea_html',
                        'label' => esc_html__('Banner Content', 'mipro'),
                        'name' => 'content',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Banner Content Position ', 'mipro'),
                        'name' => 'position_content',
                        'admin_label' => false,
                        'options' => array(
                            'left-top' => esc_html__('Left Top', 'mipro'),
                            'left-bottom' => esc_html__('Left Bottom', 'mipro'),
                            'left-center' => esc_html__('Left Center', 'mipro'),
                            'right-top' => esc_html__('Right Top', 'mipro'),
                            'right-bottom' => esc_html__('Right Bottom', 'mipro'),
                            'right-center' => esc_html__('Right Center', 'mipro'),
                            'center-top' => esc_html__('Center Top', 'mipro'),
                            'center-bottom' => esc_html__('Center Bottom', 'mipro'),
                            'center-center' => esc_html__('Center Center', 'mipro'),
                        ),
                        'value' => 'center-center',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Extra Class', 'mipro'),
                        'name' => 'extra_class',
                        'admin_label' => false,
                        'value' => '',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                ),
                                esc_html__('Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.section-title-main'),
                                    
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'font-style', 'label' => esc_html__('Font Style', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'text-decoration', 'label' => esc_html__('Text Decoration', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.section-title-main'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.section-title-main'),
                                ),
                                esc_html__('Content', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro'), 'selector' => '.content'),
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.content *'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.content'),
                                ),
                                 esc_html__('Link Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'color', 'label' => esc_html__('Hover Color', 'mipro'), 'selector' => '.link-titlea:hover'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'font-style', 'label' => esc_html__('Font Style', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.link-title'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'text-decoration', 'label' => esc_html__('Text Decoration', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.link-titlea'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.link-title'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.link-title'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.link-title'),
                                ),

                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/*** Image Gallery ***/
    kc_add_map(array(
        'kft_images_gallery' => array(
            'name' => esc_html__('Images Gallery', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-indent',
            'params' => array(
                array(
                    'type' => 'attach_images',
                    'label' => esc_html__('Image', 'mipro'),
                    'name' => 'images',
                    'admin_label' => false,
                    'value' => '',
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Image Size', 'mipro'),
                    'name' => 'image_size',
                    'admin_label' => false,
                    'value' => 'full',
                    'description' => esc_html__('Ex: thumbnail, medium, large, full or 400x200', 'mipro'),
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Layout', 'mipro'),
                    'name' => 'layout',
                    'admin_label' => true,
                    'options' => array(
                        'grid' => esc_html__('Grid', 'mipro'),
                        'masonry' => esc_html__('Masonry', 'mipro'),
                        'slider' => esc_html__('Slider', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('On click action', 'mipro'),
                    'name' => 'action',
                    'options' => array(
                        '' => '',
                        'lightbox' => esc_html__('Lightbox', 'mipro'),
                        'links' => esc_html__('Custom link', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'link',
                    'label' => esc_html__('Custom links', 'mipro'),
                    'name' => 'custom_links',
                    'relation' => array('parent' => 'action', 'show_when' => array('links')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Columns', 'mipro'),
                    'name' => 'columns',
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                    'value' => '3',
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Margin', 'mipro'),
                    'name' => 'margin',
                    'description' => '',
                    'value' => '30',
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show navigation', 'mipro'),
                    'name' => 'nav',
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show dots', 'mipro'),
                    'name' => 'dots',
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Autoplay', 'mipro'),
                    'name' => 'autoplay',
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Desktop small items', 'mipro'),
                    'name' => 'desksmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                    'value' => '4',
                    'description' => esc_html__('Set items on 991px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet items', 'mipro'),
                    'name' => 'tablet',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '6',
                    ),
                    'value' => '3',
                    'description' => esc_html__('Set items on 768px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet mini items', 'mipro'),
                    'name' => 'tabletmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '5',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 640px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile items', 'mipro'),
                    'name' => 'mobile',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 480px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile small items', 'mipro'),
                    'name' => 'mobilesmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 0px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
            ),
        ),
    ));

/*** Shortcode Blogs ***/
    $post_args = array(
        'type' => 'post',
        'child_of' => 0,
        'parent' => '',
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => 1,
        'hierarchical' => 1,
        'exclude' => '',
        'include' => '',
        'number' => '',
        'taxonomy' => 'category',
        'pad_counts' => false,
    );

    $post_categories = get_categories($post_args);
    $post_cats = array();

    foreach ($post_categories as $cat) {
        $post_cats[$cat->term_id] = $cat->name;
    }

    kc_add_map(array(
        'kft_blogs' => array(
            'name' => esc_html__('Blogs', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-list-alt ',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Blog title', 'mipro'),
                    'name' => 'blog_title',
                    'admin_label' => true,
                    'value' => '',
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Blog Layout', 'mipro'),
                    'name' => 'layout',
                    'admin_label' => true,
                    'options' => array(
                        'grid' => esc_html__('Grid', 'mipro'),
                        'slider' => esc_html__('Slider', 'mipro'),
                        'masonry' => esc_html__('Masonry', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Blog Style', 'mipro'),
                    'name' => 'style',
                    'admin_label' => true,
                    'options' => array(
                        '' => esc_html__('Default', 'mipro'),
                        'blog-v1' => esc_html__('Stande', 'mipro'),
                        'blog-v2' => esc_html__('Lipton', 'mipro'),
                        'blog-v3' => esc_html__('Mapper', 'mipro'),
                        'blog-v4' => esc_html__('ALone', 'mipro'),
                        'blog-v5' => esc_html__('Cupperi', 'mipro'),
                        'blog-v6' => esc_html__('Version V6', 'mipro'),
                        'blog-v7' => esc_html__('Version V7', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Columns', 'mipro'),
                    'name' => 'columns',
                    'admin_label' => true,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '3',
                    'description' => esc_html__('Number of Columns', 'mipro'),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Limit', 'mipro'),
                    'name' => 'limit',
                    'admin_label' => true,
                    'value' => '5',
                    'description' => esc_html__('Number of Posts', 'mipro'),
                ),
                array(
                    'type' => 'multiple',
                    'label' => esc_html__('Categories', 'mipro'),
                    'name' => 'categories',
                    'options' => $post_cats,
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Order by', 'mipro'),
                    'name' => 'orderby',
                    'admin_label' => false,
                    'options' => array(
                        'none' => esc_html__('None', 'mipro'),
                        'ID' => esc_html__('ID', 'mipro'),
                        'date' => esc_html__('Date', 'mipro'),
                        'name' => esc_html__('Name', 'mipro'),
                        'title' => esc_html__('Title', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Order', 'mipro'),
                    'name' => 'order',
                    'admin_label' => false,
                    'options' => array(
                        'DESC' => esc_html__('Descending', 'mipro'),
                        'ASC' => esc_html__('Ascending', 'mipro'),
                    ),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show post title', 'mipro'),
                    'name' => 'title',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show thumbnail', 'mipro'),
                    'name' => 'thumbnail',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show posted by author', 'mipro'),
                    'name' => 'author',
                    'admin_label' => false,
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show comment count', 'mipro'),
                    'name' => 'comment',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show date', 'mipro'),
                    'name' => 'date',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show post excerpt', 'mipro'),
                    'name' => 'excerpt',
                    'admin_label' => false,
                    'value' => 1,
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show count view', 'mipro'),
                    'name' => 'view',
                    'admin_label' => false,
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show continue reading button', 'mipro'),
                    'name' => 'readmore',
                    'admin_label' => false,
                    'value' => 'yes',
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Number of words in excerpt', 'mipro'),
                    'name' => 'excerpt_words',
                    'admin_label' => false,
                    'value' => '16',
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show load more button', 'mipro'),
                    'name' => 'load_more',
                    'value' => 'no',
                    'admin_label' => false,
                    'relation' => array('parent' => 'layout', 'show_when' => array('grid', 'masonry')),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Load more button text', 'mipro'),
                    'name' => 'load_more_text',
                    'admin_label' => false,
                    'value' => 'Show more',
                    'relation' => array('parent' => 'load_more', 'show_when' => 'yes'),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show navigation button', 'mipro'),
                    'name' => 'nav',
                    'admin_label' => false,
                    'value' => 'yes',
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Show dots button', 'mipro'),
                    'name' => 'dots',
                    'admin_label' => false,
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'toggle',
                    'label' => esc_html__('Auto play', 'mipro'),
                    'name' => 'autoplay',
                    'admin_label' => false,
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Margin', 'mipro'),
                    'name' => 'margin',
                    'admin_label' => false,
                    'value' => '30',
                    'description' => esc_html__('Set margin between items', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Desktop small items', 'mipro'),
                    'name' => 'desksmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '3',
                    'description' => esc_html__('Set items on 991px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet items', 'mipro'),
                    'name' => 'tablet',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 768px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Tablet mini items', 'mipro'),
                    'name' => 'tabletmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '4',
                    ),
                    'value' => '2',
                    'description' => esc_html__('Set items on 640px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile items', 'mipro'),
                    'name' => 'mobile',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 480px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
                array(
                    'type' => 'number_slider',
                    'label' => esc_html__('Mobile small items', 'mipro'),
                    'name' => 'mobilesmini',
                    'admin_label' => false,
                    'options' => array(
                        'min' => '1',
                        'max' => '3',
                    ),
                    'value' => '1',
                    'description' => esc_html__('Set items on 0px', 'mipro'),
                    'relation' => array('parent' => 'layout', 'show_when' => array('slider')),
                ),
            ),
        ),
    ));

/* Shortcode Features Box */
    kc_add_map(array(
        'kft_feature' => array(
            'name' => esc_html__('Feature Box', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-square-o',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Style', 'mipro'),
                        'name' => 'icon_style',
                        'admin_label' => true,
                        'options' => array(
                            'icon' => esc_html__('Icon', 'mipro'),
                            'image' => esc_html__('Image', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'icon_picker',
                        'label' => esc_html__('Select Icon', 'mipro'),
                        'name' => 'icon',
                        'admin_label' => true,
                        'value' => '',
                        'relation' => array('parent' => 'icon_style', 'show_when' => array('icon')),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Icon position', 'mipro'),
                        'name' => 'icon_position',
                        'admin_label' => true,
                        'options' => array(
                            'top' => esc_html__('Top', 'mipro'),
                            'center' => esc_html__('Center', 'mipro'),
                            'left' => esc_html__('Left', 'mipro'),
                            'right' => esc_html__('Right', 'mipro'),
                        ),
                        'value' => 'center',
                        'relation' => array('parent' => 'icon_style', 'show_when' => array('icon')),
                    ),
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('Image Thumbnail', 'mipro'),
                        'name' => 'img_id',
                        'admin_label' => false,
                        'value' => '',
                        'relation' => array('parent' => 'icon_style', 'show_when' => array('image')),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Image Style', 'mipro'),
                        'name' => 'image_style',
                        'admin_label' => true,
                        'options' => array(
                            'default' => esc_html__('Default', 'mipro'),
                            'overlay' => esc_html__('Overlay', 'mipro'),
                            'feature-label' => esc_html__('Label', 'mipro'),
                            'feature-vertical' => esc_html__('Vertical', 'mipro'),
                        ),
                        'description' => '',
                        'relation' => array('parent' => 'icon_style', 'show_when' => array('image')),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Feature title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                        'value' => '',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => esc_html__('Short description', 'mipro'),
                        'name' => 'excerpt',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'link',
                        'label' => esc_html__('Link', 'mipro'),
                        'name' => 'link',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Extra class', 'mipro'),
                        'name' => 'extra_class',
                        'admin_label' => true,
                        'value' => '',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro')),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro')),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                ),
                                esc_html__('Content', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'opacity', 'label' => esc_html__('Opacity', 'mipro'), 'selector' => '.feature_content'),
                                    array('property' => 'color', 'label' => esc_html__('Content Color', 'mipro'), 'selector' => '.feature_content *'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.feature_content'),
                                ),
                                esc_html__('Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'color', 'label' => esc_html__('Hover Color', 'mipro'), 'selector' => '.feature-title > a:hover'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'font-style', 'label' => esc_html__('Font Style', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.feature-title'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.feature-title'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'text-decoration', 'label' => esc_html__('Text Decoration', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'letter-spacing', 'label' => esc_html__('Letter Spacing', 'mipro'), 'selector' => '.feature-title > a'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.feature-title'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.feature-title'),
                                ),
                                esc_html__('Description', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.feature_info'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.feature_info'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/* Shortcode Instagram Feed */
    kc_add_map(array(
        'kft_instagram' => array(
            'name' => esc_html__('Instagram Feed', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-instagram',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                        'value' => 'Instagram',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Username', 'mipro'),
                        'name' => 'username',
                        'admin_label' => true,
                        'value' => '',
                        'description' => esc_html__('Enter username Instagram', 'mipro'),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Number', 'mipro'),
                        'name' => 'number',
                        'admin_label' => true,
                        'value' => '9',
                        'options' => array(
                            'min' => '1',
                            'max' => '12',
                        ),
                    ),
                    array(
                        'type' => 'number_slider',
                        'label' => esc_html__('Column', 'mipro'),
                        'name' => 'column',
                        'admin_label' => true,
                        'value' => '3',
                        'options' => array(
                            'min' => '1',
                            'max' => '5',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Image Size', 'mipro'),
                        'name' => 'size',
                        'admin_label' => true,
                        'options' => array(
                            'large' => esc_html__('Large', 'mipro'),
                            'thumbnail' => esc_html__('Thumbnail', 'mipro'),
                            'small' => esc_html__('Small', 'mipro'),
                            'original' => esc_html__('Original', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Target', 'mipro'),
                        'name' => 'target',
                        'admin_label' => true,
                        'options' => array(
                            '_self' => esc_html__('Current window', 'mipro'),
                            '_blank' => esc_html__('New window', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Cache time (hours)', 'mipro'),
                        'name' => 'cache_time',
                        'admin_label' => true,
                        'value' => '12',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                ),
                                esc_html__('Image', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.item'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.item'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.item'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.item img'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.item img'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.item'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/* Shortcode Mailchimp Subscription */
    $mc_forms = mipro_get_mailchimp_forms();
    $mc_form_option = array('' => '');
    foreach ($mc_forms as $mc_form) {
        $mc_form_option[$mc_form['id']] = $mc_form['title'];
    }
    kc_add_map(array(
        'kft_mailchimp_subscription' => array(
            'name' => esc_html__('Mailchimp Subscription', 'mipro'),
            'category' => esc_html__('Custom Element', 'mipro'),
            'icon' => 'fa-envelope-o',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Form', 'mipro'),
                        'name' => 'form',
                        'admin_label' => true,
                        'options' => $mc_form_option,
                    ),
                      array(
                        'type' => 'text',
                        'label' => esc_html__('Header Text', 'mipro'),
                        'name' => 'header_text',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                        'value' => 'Newsletter',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Intro Text', 'mipro'),
                        'name' => 'intro_text',
                        'admin_label' => true,
                        'value' => '',
                    ),
                   
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('Background Image', 'mipro'),
                        'name' => 'bg_image',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Text Style', 'mipro'),
                        'name' => 'text_style',
                        'admin_label' => false,
                        'options' => array(
                            'text-default' => esc_html__('Default', 'mipro'),
                            'text-light' => esc_html__('Light', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Style', 'mipro'),
                        'name' => 'style',
                        'admin_label' => false,
                        'options' => array(
                            'style-1' => esc_html__('Style 1', 'mipro'),
                            'style-2' => esc_html__('Style 2', 'mipro'),
                            'style-3' => esc_html__('Style 3', 'mipro'),
                            'style-4' => esc_html__('Style 4', 'mipro'),
                            'style-5' => esc_html__('Style 5', 'mipro'),
                            'style-6' => esc_html__('Style 6', 'mipro'),
                        ),
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('Image', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.mc4wp-form-fields'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.mc4wp-form-fields'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.mc4wp-form-fields'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.mc4wp-form-fields'),
                                    array('property' => 'justify-content', 'label' => esc_html__('Justify Content', 'mipro'), 'selector' => '.mc4wp-form-fields'),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ));

/* Shortcode Team Member */
    kc_add_map(array(
        'kft_team_member' => array(
            'name' => esc_html__('Team Member', 'mipro'),
            'category' => 'Custom Element',
            'is_container' => true,
            'icon' => 'fa-user-circle-o',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('User Avatar', 'mipro'),
                        'name' => 'image',
                        'value' => '',
                        'description' => esc_html__('Select image from media library.', 'mipro'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Image Style', 'mipro'),
                        'name' => 'style_img',
                        'admin_label' => true,
                        'options' => array(
                            'default' => esc_html__('Default', 'mipro'),
                            'circle' => esc_html__('Circle', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Name', 'mipro'),
                        'name' => 'name',
                        'admin_label' => true,
                        'value' => '',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Title', 'mipro'),
                        'name' => 'title',
                        'admin_label' => true,
                        'value' => 'CEO / FOUNDER',
                    ),
                    array(
                        'type' => 'link',
                        'label' => esc_html__('Link', 'mipro'),
                        'name' => 'link',
                        'value' => '',
                    ),
                    array(
                        'type' => 'textarea_html',
                        'label' => esc_html__('Text', 'mipro'),
                        'name' => 'content',
                        'admin_label' => false,
                        'value' => '',
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__(' Meta position', 'mipro'),
                        'name' => 'position',
                        'options' => array(
                            'meta' => esc_html__('On Meta', 'mipro'),
                            'thumbnail' => esc_html__('On Thumbnail', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => esc_html__('Social buttons style', 'mipro'),
                        'name' => 'icon_style',
                        'options' => array(
                            'colored' => esc_html__('Colored', 'mipro'),
                            'bordered' => esc_html__('Bordered', 'mipro'),
                            'small' => esc_html__('Small', 'mipro'),
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Facebook link', 'mipro'),
                        'name' => 'facebook',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Twitter link', 'mipro'),
                        'name' => 'twitter',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Google+ link', 'mipro'),
                        'name' => 'google_plus',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Linkedin link', 'mipro'),
                        'name' => 'linkedin',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Dribbble link', 'mipro'),
                        'name' => 'dribbble',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Instagram link', 'mipro'),
                        'name' => 'instagram',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Pinterest link', 'mipro'),
                        'name' => 'pinterest',
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Rss link', 'mipro'),
                        'name' => 'rss',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro')),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                ),
                                esc_html__('Image', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.image-team img'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.image-team img'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.image-team img'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.image-team img'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.image-team img'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.image-team img'),
                                ),
                                esc_html__('Content', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.content-member'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.content-member'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.content-member'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.content-member'),
                                    array('property' => 'background', 'label' => esc_html__('Background', 'mipro'), 'selector' => '.content-member'),
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.content-member'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.content-member'),
                                ),
                                esc_html__('Title', 'mipro') => array(
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-weight', 'label' => esc_html__('Font Weight', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-style', 'label' => esc_html__('Font Style', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'font-family', 'label' => esc_html__('Font Family', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'text-align', 'label' => esc_html__('Text Align', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'text-shadow', 'label' => esc_html__('Text Shadow', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'text-transform', 'label' => esc_html__('Text Transform', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'text-decoration', 'label' => esc_html__('Text Decoration', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.name'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.name'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

/* Shortcode Mega Menu */
    $menu_dropdown = array();
    $menus = wp_get_nav_menus();
    foreach ($menus as $menu) {
        $menu_dropdown[$menu->term_id] = $menu->name;
    }
    kc_add_map(array(
        'kft_mega_menu_wg' => array(
            'name' => esc_html__('Mega Menu Widget', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-bars',
            'params' => array(
                array(
                    'type' => 'text',
                    'label' => esc_html__('Title', 'mipro'),
                    'name' => 'title',
                    'admin_label' => true,
                    'value' => 'All Categories',
                ),
                array(
                    'type' => 'select',
                    'label' => esc_html__('Select Menu', 'mipro'),
                    'name' => 'nav_menu',
                    'admin_label' => true,
                    'options' => $menu_dropdown,
                ),
                array(
                    'type' => 'text',
                    'label' => esc_html__('Extra class name', 'mipro'),
                    'name' => 'extra_class',
                    'admin_label' => true,
                    'value' => '',
                ),
            ),
        ),
    ));

/* Video Button Shortcode */
    kc_add_map(array(
        'kft_video_button' => array(
            'name' => esc_html__('Video Button', 'mipro'),
            'category' => 'Custom Element',
            'icon' => 'fa-play-circle',
            'params' => array(
                esc_html__('General', 'mipro') => array(
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Video Url', 'mipro'),
                        'name' => 'video_url',
                        'admin_label' => true,
                        'value' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                        'description' => esc_html__('Enter Youtube or Vimeo Video', 'mipro'),
                    ),
                    array(
                        'type' => 'icon_picker',
                        'label' => esc_html__('Icon Play', 'mipro'),
                        'name' => 'icon',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'attach_image',
                        'label' => esc_html__('Select Image', 'mipro'),
                        'name' => 'image',
                        'description' => esc_html__('Set image poster for video', 'mipro'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Image Size', 'mipro'),
                        'name' => 'image_size',
                        'value' => 'full',
                        'description' => esc_html__('Ex: "thumbnail", "medium", "large", "full" or "600x400"', 'mipro'),
                    ),
                    array(
                        'type' => 'text',
                        'label' => esc_html__('Extra class name', 'mipro'),
                        'name' => 'extra_class',
                        'admin_label' => true,
                        'value' => '',
                    ),
                ),
                esc_html__('Styling', 'mipro') => array(
                    array(
                        'name' => 'css_custom',
                        'type' => 'css',
                        'options' => array(
                            array(
                                "screens" => "any,1024,999,767,479",
                                esc_html__('General', 'mipro') => array(
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro')),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro')),
                                    array('property' => 'display', 'label' => esc_html__('Display', 'mipro')),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro')),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro')),
                                ),
                                esc_html__('Icon', 'mipro') => array(
                                    array('property' => 'width', 'label' => esc_html__('Width', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'height', 'label' => esc_html__('Height', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'line-height', 'label' => esc_html__('Line Height', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'font-size', 'label' => esc_html__('Font Size', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'color', 'label' => esc_html__('Color', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'margin', 'label' => esc_html__('Margin', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'padding', 'label' => esc_html__('Padding', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'border', 'label' => esc_html__('Border', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'border-radius', 'label' => esc_html__('Border Radius', 'mipro'), 'selector' => '.video-icon'),
                                    array('property' => 'box-shadow', 'label' => esc_html__('Box Shadow', 'mipro'), 'selector' => '.video-icon'),
                                ),
                            ),
                        ),
                    ),
                ),
                esc_html__('Animate', 'mipro') => array(
                    array(
                        'name' => 'animate',
                        'type' => 'animate',
                    ),
                ),
            ),
        ),
    ));

}

?>