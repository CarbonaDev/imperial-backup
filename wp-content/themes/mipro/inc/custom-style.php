<?php 
/**
 * Custom Style (Dynamic Style)
 * (c) Joyce
 */

// Color Scheme
$kft_primary_color = mipro_get_opt('kft_primary_color');
$kft_secondary_color = mipro_get_opt('kft_secondary_color');
$kft_body_background_color = mipro_get_opt('kft_body_background_color');
$kft_top_bar_bg = mipro_get_opt('kft-top-bar-bg');
$kft_top_bar_color = mipro_get_opt('kft-top-bar-color');

// Typography
$title_font = mipro_get_opt('kft_title_font');
$kft_title_font = ! empty( $title_font['font-family'] ) ? $title_font['font-family'] : 'Jost';
$kft_title_font_weight = mipro_get_opt('kft_title_font_weight');
$body_font = mipro_get_opt('kft_body_font');
$kft_body_font = ! empty( $body_font['font-family'] ) ? $body_font['font-family'] : 'Jost';
$kft_font_size_body = mipro_get_opt('kft_font_size_body');
$kft_line_height_body = mipro_get_opt('kft_line_height_body');

// Breadcrumb
$kft_breadcrumbs_height = mipro_get_opt('kft_breadcrumbs_height');
$kft_breadcrumbs_mobile_height = mipro_get_opt('kft_breadcrumbs_mobile_height');
$kft_page_title_fontsize = mipro_get_opt('kft_page_title_fontsize');

?>	

body{
	line-height: <?php echo esc_html( $kft_line_height_body ) . "px"; ?>;
	font-size: <?php echo esc_html( $kft_font_size_body ) . "px"; ?>;
}

.section-title-main,.entry-summary > .product_title,
.related products > h2 span,h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, 
.widget-title.heading-title,
.widget-title.product-title,.newletter_sub_input .button.button-secondary,
.woocommerce div.product .woocommerce-tabs ul.tabs,
.kc-title-wrap,
#customer_login h2, .cart_totals h2,
.cart-popup-title .title-cart,
.widget-title,
.woocommerce div.product .woocommerce-tabs ul.tabs li a,
.woocommerce-Reviews .comment-reply-title,
.woocommerce .related.products h2 span, .related-posts h2 span,
.blog-post-default .entry-content .entry-title a,
.woocommerce div.product_sticky_detail > span,
.accordion-product-tabs .kc_accordion_header > a
{
	font-family: <?php echo ( false !== strpos( $kft_title_font, ' ' ) ) ? '"' . esc_html( $kft_title_font ) . '"' : esc_html( $kft_title_font ); ?>,sans-serif;
	<?php if ( $kft_title_font_weight ) : ?>
		font-weight: <?php echo esc_html( $kft_title_font_weight ); ?>;
	<?php endif; ?>
}

html, 
body,
label,
table.compare-list td,
input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], textarea,
.top-bar,
.info-open,
.info-phone,
.header-account .kft_login > a,
.header-account,
.header-wishlist *,
.dropdown-button span > span,p,
.wishlist-empty,
.search-form-wrapper form,
.kft-header-cart,
.product-labels,
.item-information .product-title,
.item-information .price,
.sidebar-widget ul.product-categories ul.children li a,
.sidebar-widget:not(.kft-product-categories-widget):not(.widget_product_categories):not(.kft-items-widget) :not(.widget-title),
.kft-products-tabs ul.tabs li span.title,
.woocommerce-pagination,
.woocommerce-result-count,
.woocommerce .products.list .product .price .amount,
.woocommerce-page .products.list .product .price .amount,
.products.list .short-description.list,
div.product .single_variation_wrap .amount,
div.product div[itemprop="offers"] .price .amount,
.orderby-title,
.blogs .post-info,
.blog .entry-info .entry-summary .short-content,
.single-post .entry-info .entry-summary .short-content,
.single-post article .post-info .info-category,
.single-post article .post-info .info-category,
#comments .comments-title,
#comments .comment-metadata a,
.post-navigation .nav-previous,
.post-navigation .nav-next,
.woocommerce-review-link,
.kft_feature_info,
.woocommerce div.product p.stock,
.woocommerce div.product .summary div[itemprop="description"],
.woocommerce div.product p.price,
.woocommerce div.product .woocommerce-tabs .panel,
.woocommerce div.product form.cart .group_table td.label,
.woocommerce div.product form.cart .group_table td.price,
footer,
footer a,
.blogs article .image-eff:before,
.blogs article a.gallery .owl-item:after, .nav-link span, .button-readmore,
.summary .product-meta,
div.product .summary .compare, div.product .summary .compare:hover,
div.product .summary .yith-wcwl-add-to-wishlist,.woocommerce div.product form.cart .button,
.countdown-meta, .countdown-timer > div .number, .tooltip,
.kft-counter,.woocommerce table.shop_table_responsive tr td::before, .woocommerce-page table.shop_table_responsive tr td::before,.woocommerce .cart-content .cart-collaterals table.shop_table th,
.woocommerce-cart table.cart input.button,
.single-post .single-cats a,
.comment-content *,.tags-link, .cats-link,.author,
#yith-wcwl-popup-message,.woocommerce-message,.woocommerce-error,
.woocommerce-info, .error404  .page-content h2,.excerpt, .info,.description,
table.compare-list tr th, table.compare-list tbody th
{
	font-family: <?php echo ( false !== strpos( $kft_body_font, ' ' ) ) ? '"' . esc_html( $kft_body_font ) . '"' : esc_html( $kft_body_font ); ?>,sans-serif;
}
body,
.site-footer,
.woocommerce div.product form.cart .group_table td.label,
.woocommerce .product .product-labels span,
.item-information .kft-product-buttons .yith-wcwl-add-to-wishlist a,  .item-information .kft-product-buttons .compare,
.info-company li i,
.social-icons .kft-tooltip:before,
.tagcloud a,
.product_thumbnails .owl-nav > button:before,
div.product .summary .yith-wcwl-add-to-wishlist a:before,
.pp_woocommerce div.product .summary .compare:before,
.woocommerce div.product .summary .compare:before,
.woocommerce-page div.product .summary .compare:before,
.woocommerce #content div.product .summary .compare:before,
.woocommerce-page #content div.product .summary .compare:before,
.woocommerce div.product form.cart .variations label,
.woocommerce-page div.product form.cart .variations label,
.pp_woocommerce div.product form.cart .variations label,
blockquote,
.woocommerce .widget_price_filter .price_slider_amount,
.wishlist-empty,
.woocommerce div.product form.cart .button,
.woocommerce table.wishlist_table
{
	font-size: <?php echo esc_html( $kft_font_size_body ) . "px" ?>;
}

.header-currency:hover .kft-currency > a,
.woocommerce a.remove:hover,
.has-dropdown .kft_cart_check > a.button.view-cart:hover,
.header-account .kft_login > a:hover,
.dropdown-button span:hover,
.woocommerce .products .star-rating,
.woocommerce-page .products .star-rating,
.star-rating:before,
div.product div[itemprop="offers"] .price .amount,
div.product .single_variation_wrap .amount,
.pp_woocommerce .star-rating:before,
.woocommerce .star-rating:before,
.woocommerce-page .star-rating:before,
.woocommerce-product-rating .star-rating span,
ins .amount,
.kft-meta-widget .price ins,
.kft-meta-widget .star-rating,
.ul-style.circle li:before,
.woocommerce form .form-row .required,
.blogs .comment-count i,
.blog .comment-count i,
.single-post .comment-count i,
.single-post article .post-info .info-category,
.single-post article .post-info .info-category .cat-links a,
.single-post article .post-info .info-category .vcard.author a,
.breadcrumb-title-inner .breadcrumbs-content,
.breadcrumb-title-inner .breadcrumbs-content span.current,
.breadcrumb-title-inner .breadcrumbs-content a:hover,
.woocommerce .product   .item-information .kft-product-buttons a:hover,
.woocommerce-page .product   .item-information .kft-product-buttons a:hover,
.kft-meta-widget.item-information .kft-product-buttons a:hover,
.kft-meta-widget.item-information .kft-product-buttons .yith-wcwl-add-to-wishlist a:hover,
.kft-quickshop-wrapper .owl-nav > button.owl-next:hover,
.kft-quickshop-wrapper .owl-nav > button.owl-prev:hover,
.comment-reply-link .icon,
body table.compare-list tr.remove td > a .remove:hover:before,
a:hover,
a:focus,
.blogs article h3.product-title a:hover,
article .post-info a:hover,
article .comment-content a:hover,
.main-navigation li li.focus > a,
.main-navigation li li:focus > a,
.main-navigation li li:hover > a,
.main-navigation li li a:hover,
.main-navigation li li a:focus,
.main-navigation li li.current_page_item a:hover,
.main-navigation li li.current-menu-item a:hover,
.main-navigation li li.current_page_item a:focus,
.main-navigation li li.current-menu-item a:focus,.woocommerce-account .woocommerce-MyAccount-navigation li.is-active a, article .post-info .cat-links a,article .post-info .tags-link a,
.vcard.author a,article .entry-header .cakft-link .cat-links a,.woocommerce-page .products.list .product h3.product-name a:hover,
.woocommerce .products.list .product h3.product-name a:hover,.kft-feature-box .feature_icon,.entry-content a, .comment-content a, .blogs  .date-time i, .blogs .entry-title a:hover,
.star-rating, div.product .summary .yith-wcwl-add-to-wishlist a:hover,
.woocommerce #content div.product .summary .compare:hover,
.woocommerce .products .star-rating,
.woocommerce-page .products .star-rating,
.star-rating:before,
div.product div[itemprop="offers"] .price .amount,
div.product .single_variation_wrap .amount,
.pp_woocommerce .star-rating:before,
.woocommerce .star-rating:before,
.woocommerce-page .star-rating:before,
.woocommerce-product-rating .star-rating span,
ins .amount,
.kft-meta-widget .price ins,
.kft-meta-widget .star-rating,
.ul-style.circle li:before,
.woocommerce form .form-row .required,
.blogs .comment-count i,
.blog .comment-count i,
.single-post .comment-count i,
.single-post article .post-info .info-category,
.single-post article .post-info .info-category .cat-links a,
.single-post article .post-info .info-category .vcard.author a,
.breadcrumb-title-inner .breadcrumbs-content,
.breadcrumb-title-inner .breadcrumbs-content span.current,
.breadcrumb-title-inner .breadcrumbs-content a:hover,.woocommerce a.remove:hover,
body table.compare-list tr.remove td > a .remove:hover:before,.newer-posts:hover .post-title,
.newer-posts:hover i,.order-posts:hover .post-title, .order-posts:hover i,.kft-recent-comments-widget .on_post a, .entry-content .date-time i, .blog .blockquote-meta .date-time i,.error404 .page-header h2,
.woocommerce-info .showcoupon,.woocommerce-info .showlogin,
body .sticky-header .navigation-wrapper .main-navigation .menu > li.item-level-0 > a:hover,
body .sticky-header .navigation-wrapper .main-navigation .menu > li.item-level-0 > a:hover:after,
.woocommerce .products .product .images a:hover, .kft-section-title .before-title,
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a,
.author-link,
body .kft-instagram-shortcode .widgettitle:before,
ul.social-sharing-blog li a:hover,
.blog-post-default .entry-content .entry-title a.post-title:hover,
 .entry-content .cate-content a:hover,
 .kft-blogs-shortcode .blogs .button-readmore:hover,
 body .header-layout4 .navigation-wrapper .main-navigation .menu>.item-level-0>a:hover,
 .woocommerce .widget_price_filter .price_slider_amount .button:hover,
 .single-post .related-posts .entry-content .entry-title a:hover,
 .images-slider-wrapper .owl-dots .owl-dot.active:before,
 .images-slider-wrapper .owl-dots .owl-dot:hover:before,
 .single-post .cat-links a:hover,
 body .kft-product-shortcode.is-grid.is-shade .load-more-wrapper a:hover,
 body .navigation-wrapper .main-navigation .menu li.current-menu-parent >a>span,
 .grid_list_nav a#grid.active,
.grid_list_nav a#list.active,
body .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item a:hover,
body .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item:hover span,
body .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.chosen a,
body .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.chosen span,
.woocommerce .kft-product-buttons .yith-wcwl-wishlistaddedbrowse a:before,
.woocommerce .kft-product-buttons .yith-wcwl-wishlistexistsbrowse a:before,
body .navigation-wrapper .main-navigation ul li.current-menu-item>a, body .navigation-wrapper .main-navigation ul li.current_page_ancestor.current-menu-ancestor>a
{
	color: <?php echo esc_html( $kft_primary_color ); ?>;
	transition:all 0.7s ease;
}
.has-dropdown .kft_cart_check > a.button.checkout:hover,
body input.wpcf7-submit:hover,
#yith-wcwl-popup-message,
.woocommerce .products.list .product .item-information .add-to-cart a:hover,
.woocommerce .products.list .product .item-information .button-in a:hover,
.woocommerce .products.list .product .item-information .kft-product-buttons  a:not(.quickview):hover,
.woocommerce .products.list .product .item-information .quickview i:hover,
.countdown-timer > div,
.tp-bullets .tp-bullet:after,
.woocommerce .product .product-labels .onsale,
.woocommerce #respond input#submit:hover, 
.woocommerce a.button:hover,
.woocommerce button.button:hover, 
.woocommerce input.button:hover,
.woocommerce .products .product  .images .button-in:hover a:hover,
.woocommerce nav.woocommerce-pagination ul li span.current,
.woocommerce-page nav.woocommerce-pagination ul li span.current,
.woocommerce nav.woocommerce-pagination ul li a.next:hover,
.woocommerce-page nav.woocommerce-pagination ul li a.next:hover,
.woocommerce nav.woocommerce-pagination ul li a.prev:hover,
.woocommerce-page nav.woocommerce-pagination ul li a.prev:hover,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce-page nav.woocommerce-pagination ul li a:hover,
.woocommerce .form-row input.button:hover,
.load-more-wrapper .button:hover,
.woocommerce div.product form.cart .button:hover,
.woocommerce div.product div.summary p.cart a:hover,
.woocommerce .wc-proceed-to-checkout a.button.alt:hover,
.woocommerce .wc-proceed-to-checkout a.button:hover,
.woocommerce-cart table.cart input.button:hover,
.owl-dots > .owl-dot span:hover,
.owl-dots > .owl-dot.active span,
footer .style-3 .newletter_sub .button.button-secondary.transparent,
.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
body div.pp_details a.pp_close:hover:before,
body.error404 .page-header a,
body .button.button-secondary,
.pp_woocommerce div.product form.cart .button,
.style1 .kft-countdown .countdown-timer > div,
.style2 .kft-countdown .countdown-timer > div,
.style3 .kft-countdown .countdown-timer > div,
#cboxClose:hover,
body > h1,
table.compare-list .add-to-cart td a:hover,
div.product.vertical-thumbnail .product-gallery .owl-controls div.owl-prev:hover,
div.product.vertical-thumbnail .product-gallery .owl-controls div.owl-next:hover,
ul > .page-numbers.current,
ul > .page-numbers:hover,.text_service a,
.post-item.sticky .post-info .entry-info .sticky-post,
.woocommerce .products.list .product   .item-information .compare.added:hover,.vertical-menu-heading, .cart-number, .kft-section-title b,.kft-section-title .sub-title,
.owl-nav > button:hover, .button-readmore:before, .mc4wp-form input[type=submit], .woocommerce .button.single_add_to_cart_button.alt:hover,.woocommerce .button.single_add_to_cart_button.alt.disabled,
.product_thumbnails .owl-nav .owl-prev:hover,
.product_thumbnails .owl-nav .owl-next:hover,
.single-post .single-cats a,.comment-form .form-submit input[type="submit"],
 #to-top a:hover,
.woocommerce .wc-proceed-to-checkout a.button.alt, .woocommerce .wc-proceed-to-checkout a.checkout-button,
.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,
.woocommerce div.product div.summary p.cart a,.widget_tag_cloud .tagcloud a.tag-cloud-link:hover,
.kft-mega-menu-shortcode .widgettitle,.header-layout3 .navigation-wrapper,
body .woocommerce.widget_shopping_cart .widget_shopping_cart_content .buttons > a.checkout,
body .woocommerce.widget_shopping_cart .widget_shopping_cart_content .buttons > a:hover,
.page-links > span:not(.page-links-title),
.widget_calendar #wp-calendar #today,.kft-button-shortcode.color-primary a,
.button.is-underline:before,
.mipro_product_sticky .container .kft-add-to-cart a,
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:after,
.woocommerce .products.list .product .item-information .add-to-cart a,
.mipro-cookie-notice .cookie-accept,
.header-layout4 .header-wishlist a span,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.button-readmore:after,
.header-layout5 .header-wishlist a span,
.header-layout6 .header-wishlist a span,
.kft-blogs-shortcode .blogs .button-readmore:hover:before,
.sidebar-widget .widget-title:after, .sidebar-widget .widgettitle:after, .sidebar-widget .widget-heading:after,
.images-slider-wrapper .owl-dots .owl-dot.active:after,
.images-slider-wrapper .owl-dots .owl-dot:hover:after,
.testimonial-item.testimonial-image-center .name:before,
.kft-mailchimp-shortcode.style-4  .mc4wp-form input[type=submit]:hover,
.kc_row .tabs-center .kc_tabs_nav>li>a:hover,
.kc_row .tabs-center .kc_tabs_nav>li.ui-tabs-active >a,
body .kft-product-shortcode.is-grid.is-shade .load-more-wrapper a:hover:before,
.kft-blogs-shortcode.blog-v5 .blogs .owl-dots .owl-dot.active:before,
.woocommerce div.product div.summary p.cart a,
.woocommerce div.product form.cart .button,
.woocommerce-widget-layered-nav ul .wc-layered-nav-term a:hover:after,
.woocommerce-widget-layered-nav ul .wc-layered-nav-term.chosen a:after,
.mipro-active-filters .widget_layered_nav_filters ul li a:hover,
.progress-bar-page-container *
{
	background-color: <?php echo esc_html( $kft_primary_color ); ?>;
}
a.link-titlea:hover:after
{
	background-color: <?php echo esc_html( $kft_primary_color );?> !important;
}
.has-dropdown .kft_cart_check > a.button.view-cart:hover,
.has-dropdown .kft_cart_check > a.button.checkout:hover,
body input.wpcf7-submit:hover,
.countdown-timer > div,
.woocommerce .products .product:hover,
.woocommerce-page .products .product:hover,
#right-sidebar .product_list_widget:hover li,
.woocommerce .product   .item-information .kft-product-buttons a:hover,
.woocommerce-page .product   .item-information .kft-product-buttons a:hover,
.kft-meta-widget.item-information .kft-product-buttons a:hover,
.kft-meta-widget.item-information .kft-product-buttons .yith-wcwl-add-to-wishlist a:hover,
.woocommerce .products .product:hover,
.woocommerce-page .products .product:hover,
.kft-products-tabs ul.tabs li:hover,
.kft-products-tabs ul.tabs li.current,
body div.pp_details a.pp_close:hover:before,
body .button.button-secondary,
.kft-quickshop-wrapper .owl-nav > button.owl-next:hover,
.kft-quickshop-wrapper .owl-nav > button.owl-prev:hover,
#cboxClose:hover, .woocommerce-account .woocommerce-MyAccount-navigation li.is-active,
.kft-product-items-widget .kft-meta-widget.item-information .kft-product-buttons .compare:hover,
.kft-product-items-widget .kft-meta-widget.item-information .kft-product-buttons .add_to_cart_button a:hover,
.woocommerce .product   .item-information .kft-product-buttons .add-to-cart a:hover,
.kft-meta-widget.item-information .kft-product-buttons .add-to-cart a:hover, .kft-products-tabs .tabs-header .tab-item.current, .kft-products-tabs .tabs-header .tab-item:hover,.newer-posts:hover i,
.order-posts:hover i, #to-top a:hover,
.woocommerce-account .woocommerce-my-account-navigation li:hover a:after, .woocommerce-account .woocommerce-my-account-navigation li.is-active a:after,.widget_tag_cloud .tagcloud a.tag-cloud-link:hover,
.button-style-outline a, .grid_list_nav a.active,
.kft-blogs-shortcode .blogs article .entry-header:hover:before,
.kc_row .tabs-center .kc_tabs_nav>li>a:hover,
.kc_row .tabs-center .kc_tabs_nav>li.ui-tabs-active >a,
.kft-blogs-shortcode.blog-v5 .blogs .owl-dots .owl-dot.active:before,
body .kft-product-shortcode.is-default.no-rate .load-more-wrapper a:hover,
.woocommerce-widget-layered-nav ul .wc-layered-nav-term a:hover:after,
.woocommerce-widget-layered-nav ul .wc-layered-nav-term.chosen a:after
{
	border-color: <?php echo esc_html( $kft_primary_color ); ?>;
}
body,
.kft-shoppping-cart a.kft_cart:hover,
#mega_main_menu.primary ul li .mega_dropdown > li.sub-style > .item_link .link_text,
.woocommerce a.remove,
.woocommerce .products .star-rating.no-rating,
.woocommerce-page .products .star-rating.no-rating,
.star-rating.no-rating:before,
.pp_woocommerce .star-rating.no-rating:before,
.woocommerce .star-rating.no-rating:before,
.woocommerce-page .star-rating.no-rating:before,
.woocommerce .product .images .kft-product-buttons > a,
.style1 .kft-countdown .countdown-timer > div .countdown-meta,
.style2 .kft-countdown .countdown-timer > div .countdown-meta,
.style3 .kft-countdown .countdown-timer > div .countdown-meta,
.style4 .kft-countdown .countdown-timer > div .number,
.style4 .kft-countdown .countdown-timer > div .countdown-meta,
body table.compare-list tr.remove td > a .remove:before,
.woocommerce-page .products.list .product h3.product-name a {
	color: <?php echo esc_html( $kft_secondary_color ); ?>;
}
.has-dropdown .kft_cart_check > a.button.checkout,
.pp_woocommerce div.product form.cart .button:hover,
.info-company li i,
body .button.button-secondary:hover,
.kft-button-shortcode.color-secondary a{
	background-color: <?php echo esc_html( $kft_secondary_color ); ?>;
}
.has-dropdown .kft_cart_check > a.button.checkout,
.pp_woocommerce div.product form.cart .button:hover,
body .button.button-secondary:hover,
#cboxClose{
	border-color: <?php echo esc_html( $kft_secondary_color ); ?>;
}

body {
	background-color: <?php echo esc_html( $kft_body_background_color ); ?>;
}

.top-bar {
	background-color: <?php echo esc_html( $kft_top_bar_bg['rgba'] ); ?>;
}
.top-bar, .top-bar a {
	color: <?php echo esc_html( $kft_top_bar_color ); ?>;
}
.kft-breadcrumb {
	height: <?php echo esc_html( $kft_breadcrumbs_height ); ?>;
}
@media (max-width: 767px) {
	.kft-breadcrumb {
	height: <?php echo esc_html( $kft_breadcrumbs_mobile_height ); ?>;
	}
}
.kft-breadcrumb .breadcrumb-title-inner h1 {
	font-size: <?php echo esc_html( $kft_page_title_fontsize ); ?>;
}
.logo-wrap .logo img {
	max-width: <?php echo esc_html( mipro_get_opt('kft_logo_img_width') ) . 'px'; ?>;
}