<?php
/**
 * Header layout4 file.
 *
 */
?>

<div class="header-kft header-<?php echo esc_attr( mipro_get_opt('kft_header_layout') ); ?>">
    <?php if ( mipro_get_opt('kft_header_top_bar') ) : ?>
        <div class="top-bar">
            <div class="container">
                <div class="top-bar-left">
                    <?php if ( mipro_get_opt('kft_header_contact_information') ) : ?>
                        <?php echo do_shortcode(mipro_get_opt('kft_header_contact_information')); ?>
                    <?php endif; ?>
                </div>

                <div class="top-bar-right">
                    <?php if ( mipro_get_opt('kft_enable_tiny_account') ) : ?>
                        <div class="header-account"><?php echo mipro_mini_account(); ?></div>
                    <?php endif; ?>        
                    
                    <?php if ( mipro_get_opt('kft_header_currency') ) : ?>
                        <div class="header-currency"><?php mipro_woocommerce_multilingual_currency_switcher(); ?></div>
                    <?php endif; ?>

                    <?php if ( mipro_get_opt('kft_header_language') ) : ?>
                        <div class="header-language"><?php mipro_wpml_language_selector(); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="header-content">
        <div class="container-fuild">
            <div class="header-left-wrapper">
                <?php echo mipro_header_mobile_button();  ?>
            </div>

            <div class="navigation-wrapper">
                <?php if ( has_nav_menu( 'primary' ) ) {
                    get_template_part( 'template-parts/navigation/navigation', 'primary' );
                } ?>
            </div>

            <div class="logo-wrap"><?php echo mipro_logo(); ?></div>

            <div class="header-right">
               <?php if ( mipro_get_opt('kft_enable_search') ) : ?>
                    <div class="kft-header-search">
                        <div class="header-search-button">
                            <a href="#"></a>
                            <?php mipro_search_by_category(false); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( class_exists('YITH_WCWL') && mipro_get_opt('kft_enable_tiny_wishlist') ) : ?>
                    <div class="header-wishlist"><?php echo mipro_mini_wishlist(); ?></div>
                <?php endif; ?>   

                <?php if ( mipro_get_opt('kft_enable_tiny_shopping_cart') ) : ?>
                    <div class="kft-header-cart">
                        <?php echo mipro_mini_cart(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

