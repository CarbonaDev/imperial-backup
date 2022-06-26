<?php
/**
 *  Header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <?php global $mipro_page_options; ?>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>

<script>
    window.addEventListener('DOMContentLoaded',function(){
        if(window.location.href.includes('order-received')){
            var siteItems = document.querySelectorAll('tbody tr')
            var googleItems = [];

            siteItems.forEach(function(item){
                googleItems.push({ 
                    name:item.querySelector('td:first-child a').innerText,
                    quantity: Number(item.querySelector('td:first-child strong').innerText.replace('×','')),
                    price: Number(item.querySelector('td:last-child').innerText.replace('R$','').replace('.','').replace(',','.'))
                })
            })

           gtag('event', 'purchase', {
                "transaction_id": Number(document.querySelector('.order strong').innerText),
               "affiliation":"imperialtapeteseinteriores",
                "value": Number(document.querySelectorAll('.amount bdi')[2].innerText.replace('R$','').replace('.','').replace(',','.')),
                "items":googleItems
            })
        }
    })

</script>

</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php do_action( 'mipro_after_body_open' ); ?>

    <div id="wrapper">
        <?php if ( ! is_page_template( 'blank.php' ) ) : ?>
            <?php if ( is_page() ) : ?>
                <?php if ( $mipro_page_options['kft_page_slider'] && $mipro_page_options['kft_page_slider_position'] == 'before_header' ) : ?>
                    <div class="page-slider-wrap">
                        <div class="show-slider">
                            <?php mipro_show_page_slider();?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ( mipro_get_opt('kft_enable_sticky_header') ) : ?>
                <div class="sticky-header header-mobile-<?php echo mipro_get_opt('kft_header_mobile_layout'); ?>">
                    <div class="container">
                        <div class="header-wrapper">
                            <div class="header-left-wrapper">
                                <?php echo mipro_header_mobile_button(); ?>
                            </div>

                            <div class="logo-wrap">
                                <?php echo mipro_logo(); ?>
                            </div>

                            <div class="navigation-wrapper">
                                <?php if ( has_nav_menu('primary') ) : ?>
                                    <?php get_template_part( 'template-parts/navigation/navigation', 'primary' ); ?>
                                <?php endif; ?>
                            </div>

                            <?php if ( mipro_get_opt('kft_enable_search_sticky') ) : ?>
                                <div class="kft-header-search">
                                    <div class="header-search-button">
                                        <a href="#"></a>
                                        <?php mipro_search_by_category( false ); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( mipro_get_opt('kft_enable_tiny_shopping_cart') ) : ?>
                                <div class="kft-header-cart">
                                    <?php echo mipro_mini_cart(); ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="progress-bar-page-container">
                        <div class="progress-bar-page"></div>
                    </div>
                </div>

            <?php endif; ?>

            <header id="header" class="site-header header-mobile-<?php echo mipro_get_opt('kft_header_mobile_layout'); ?>">
                <?php echo mipro_get_header_template(); ?>
            </header><!-- #header -->
        <?php endif; ?>

        <main id="main" class="site-main">