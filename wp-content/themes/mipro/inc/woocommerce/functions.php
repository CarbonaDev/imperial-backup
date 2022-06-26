<?php

/* * * Mini account ** */
if ( ! function_exists('mipro_mini_account') ) {
    function mipro_mini_account() {
        if ( mipro_is_woocommerce_activated() ) {
            $account_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
        } else {
            $account_link = wp_login_url();
        }

        $login_canvas = mipro_get_opt('kft_login_style') == 'canvas';

       $logout_url = wp_logout_url(get_permalink());

        ob_start();
        ?>

        <div class="kft-account <?php echo esc_attr( ( $login_canvas ) ? 'login-canvas' : '' ); ?>">
            <div class="login-btn">
                <?php if ( ! is_user_logged_in() ) : ?>
                    <a class="login" href="<?php echo esc_url( $account_link ); ?>"><span><?php echo esc_html_e( 'Login / Register', 'mipro' ); ?></span></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( $logout_url ); ?>"><?php esc_html_e('Logout','mipro')  ?></a>
                    <?php endif; ?>
                </div>
                <?php if ( ! is_user_logged_in() && ! is_account_page() && ! $login_canvas ) : ?>
                <div class="has-dropdown">
                    <h3 class="login-title"><?php esc_html_e( 'Sign in', 'mipro' ); ?></h3>
                    <?php mipro_login_form(); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        return ob_get_clean();
    }
}

/* Login Sidebar */
if ( ! function_exists('mipro_login_form_sidebar') ) {
    function mipro_login_form_sidebar() {

        if ( mipro_is_woocommerce_activated() ) {
            $account_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
        } else {
            $account_link = wp_login_url();
        }
        $login_canvas = mipro_get_opt('kft_login_style') == 'canvas';

        if ( ! $login_canvas || is_user_logged_in() || ( function_exists('is_account_page') && is_account_page() ) ) {
            return;
        } 
        ?>

        <div class="login-form-off-canvas">
            <div class="login-canvas-title">
                <h3 class="login-title"><?php esc_html_e( 'Sign in', 'mipro' ); ?></h3>
                <a href="#" class="login-close"><?php esc_html_e( 'Close', 'mipro' ); ?></a>
            </div>

            <div class="login-form">
                <?php mipro_login_form(); ?>
                <div class="register-question">
                    <span class="create-account"><?php esc_html_e( 'No account yet?', 'mipro' ); ?></span>
                    <a class="register-link" href="<?php echo esc_url( $account_link ); ?>"><?php esc_html_e( 'Create an Account', 'mipro' ); ?></a>
                </div>
            </div>
        </div>

        <?php
    }
    add_action( 'mipro_after_body_open', 'mipro_login_form_sidebar', 20 );
}

if ( ! function_exists('mipro_login_form') ) {
    function mipro_login_form() {
        global $wp;
        ?>

        <?php if ( mipro_is_woocommerce_activated() ) : ?>
            <form class="form-login woocommerce-form woocommerce-form-login" action="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" method="post">

                <?php do_action( 'woocommerce_login_form_start' ); ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row-username">
                    <label for="username"><?php esc_html_e( 'Username or email address', 'mipro' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php echo esc_attr( ! empty( $_POST['username'] ) ) ? wp_unslash( $_POST['username'] ) : ''; ?>" />
                </p>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row-password">
                    <label for="password"><?php esc_html_e( 'Password', 'mipro' ); ?>&nbsp;<span class="required">*</span></label>
                   <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password">
                </p>

                <?php do_action( 'woocommerce_login_form' ); ?>

                <div class="alura-login-footer">
                    <p>
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Lembrar login', 'mipro' ); ?></span>
                        </label>
                    </p>

                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="lost-password"><?php esc_html_e( 'Esqueceu a senha?', 'mipro' ); ?></a>
                </div>

                <p class="login-submit">
                    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'mipro' ); ?>"><?php esc_html_e( 'Logar', 'mipro' ); ?></button>
                </p>

                <?php do_action( 'woocommerce_login_form_end' ); ?>
            </form>

        <?php else : ?>

        <form name="form-login" class="form-login" action="<?php echo esc_url( wp_login_url() ); ?>" method="post">
            <p class="username">
                <label><?php esc_html_e( 'Username', 'mipro' ); ?></label>
                <input type="text" name="log" class="input" value="">
            </p>
            <p class="password">
                <label><?php esc_html_e( 'Password', 'mipro' ); ?></label>
                <input type="password" name="pwd" class="input" value="">
            </p>
            <p class="submit">
                <input type="submit" name="wp-submit" class="button-secondary button" value="<?php esc_html_e( 'Login', 'mipro' ); ?>">
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url( add_query_arg( array(), $wp->request ) ) ); ?>">
            </p>
            <p class="rememberme">
                <label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php esc_html_e( 'Remember Me', 'mipro' ); ?></label>
            </p>
            <p class="forgot-password"><a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Forgot Your Password?', 'mipro' ); ?>"><?php esc_html_e( 'Forgot Your Password?', 'mipro' ); ?></a></p>
        </form>  

        <?php endif; ?>

        <?php
    }
}

/* * * Mini Cart ** */
if ( ! function_exists('mipro_mini_cart') ) {
    function mipro_mini_cart() {

        if ( ! mipro_is_woocommerce_activated() ) {
            return;
        }
        $cart_canvas = mipro_get_opt('kft_tiny_cart_style') == 'canvas';

        ob_start();
        ?>
        
        <div class="kft-shoppping-cart <?php echo esc_attr( ($cart_canvas) ? 'cart-canvas' : '' ); ?>">
            <a class="kft_cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                <?php mipro_cart_subtotal(); ?>
            </a>

            <?php if ( ! $cart_canvas ) : ?>
                <div class="shopping-cart-dropdown has-dropdown">
                    <div class="woocommerce widget_shopping_cart">
                        <div class="widget_shopping_cart_content">
                            <?php echo woocommerce_mini_cart(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php
        return ob_get_clean();
    }
}

if ( ! function_exists( 'mipro_cart_subtotal' ) ) {
    function mipro_cart_subtotal() {
        ?>
        <span class="cart-number"> <?php echo WC()->cart->get_cart_contents_count(); ?>
            
            <span class="total-full"> <?php echo WC()->cart->get_cart_subtotal(); ?></span>
        </span>
        
        <?php
    }
}

add_filter( 'woocommerce_add_to_cart_fragments', 'mipro_mini_cart_filter' );
function mipro_mini_cart_filter( $fragments ) {
    ob_start();
    mipro_cart_subtotal();
    $subtotal = ob_get_clean();
    $fragments['span.cart-number'] = $subtotal;

    return $fragments;
}

/* Mini cart sidebar */
if( ! function_exists('mipro_mini_cart_sidebar') ) {
    function mipro_mini_cart_sidebar() {
        if ( ! mipro_is_woocommerce_activated() ) {
            return;
        } 

        if ( mipro_get_opt('kft_enable_tiny_shopping_cart') ) { 
            if ( mipro_get_opt('kft_tiny_cart_style') == 'canvas' ) {
                ?>
                <div class="cart-popup">
                    <div class="cart-popup-title">
                        <h3 class="title-cart"><?php esc_html_e( 'Shopping cart', 'mipro' ); ?></h3>
                        <a href="#" class="close-cart"><?php esc_html_e( 'Close', 'mipro' ); ?></a>
                    </div>
                    <div class="woocommerce widget_shopping_cart">
                        <div class="widget_shopping_cart_content">
                            <?php echo woocommerce_mini_cart(); ?>
                        </div>
                    </div>
                </div>
                <?php
            }  
        } 
    }
    add_action( 'mipro_after_body_open', 'mipro_mini_cart_sidebar', 30 );
}

/* Tini Check out */
function mipro_tini_checkout() {
    if ( ! mipro_is_woocommerce_activated() ) {
        return;
    }

    ob_start();
    ?>
    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="kft-checkout-menu"><?php esc_html_e( 'Checkout', 'mipro' ); ?></a>

    <?php
    $tini_checkout = ob_get_clean();
    return $tini_checkout;
}

/** Mini wishlist * */
function mipro_mini_wishlist() {
    if ( ! ( mipro_is_woocommerce_activated() && class_exists('YITH_WCWL') ) ) {
        return;
    }

    ob_start();

    $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
    if ( function_exists('wpml_object_id_filter') ) {
        $wishlist_page_id = wpml_object_id_filter( $wishlist_page_id, 'page', true );
    }
    $wishlist_page = get_permalink( $wishlist_page_id );

    $count = yith_wcwl_count_products();
    ?>

    <a title="<?php esc_attr_e( 'Wishlist', 'mipro' ); ?>" href="<?php echo esc_url( $wishlist_page ); ?>" class="tini-wishlist">
        <?php esc_html_e( 'Wishlist', 'mipro' ); ?>
        <span><?php echo esc_attr( $count ); ?></span>
    </a>

    <?php
    $tini_wishlist = ob_get_clean();
    return $tini_wishlist;
}

function mipro_update_tini_wishlist() {
    die( mipro_mini_wishlist() );
}

add_action('wp_ajax_update_tini_wishlist', 'mipro_update_tini_wishlist');
add_action('wp_ajax_nopriv_update_tini_wishlist', 'mipro_update_tini_wishlist');

if( ! function_exists('mipro_woocommerce_multilingual_currency_switcher') ) {
    function mipro_woocommerce_multilingual_currency_switcher() {
        if ( class_exists('woocommerce_wpml') && class_exists('WooCommerce') && class_exists('SitePress') ){
            global $sitepress, $woocommerce_wpml;
            
            if( ! isset($woocommerce_wpml->multi_currency) ) {
                return;
            }
            
            $settings = $woocommerce_wpml->get_settings();
            
            $format = isset( $settings['wcml_curr_template']) && $settings['wcml_curr_template'] != '' ? $settings['wcml_curr_template'] : '%code%';
            $wc_currencies = get_woocommerce_currencies();
            if ( ! isset( $settings['currencies_order'] ) ) {
                $currencies = $woocommerce_wpml->multi_currency->get_currency_codes();
            } else {
                $currencies = $settings['currencies_order'];
            }
            
            $selected_html = '';
            foreach ( $currencies as $currency ) {
                if ( $woocommerce_wpml->settings['currency_options'][$currency]['languages'][$sitepress->get_current_language()] == 1 ) {
                    $currency_format = preg_replace( array('#%name%#', '#%symbol%#', '#%code%#'),
                        array( $wc_currencies[$currency], get_woocommerce_currency_symbol( $currency ), $currency), $format );
                    
                    if ( $currency == $woocommerce_wpml->multi_currency->get_client_currency() ) {
                        $selected_html = '<a href="javascript: void(0)" class="wcml_selected_currency">' . $currency_format . '</a>';
                        break;
                    }
                }
            }
            
            echo '<div class="wcml_currency_switcher">';
            echo wp_kses_post($selected_html);
            echo '<ul>';
            
            foreach ( $currencies as $currency ) {
                if ( $woocommerce_wpml->settings['currency_options'][$currency]['languages'][$sitepress->get_current_language()] == 1 ) {
                    $currency_format = preg_replace( array('#%name%#', '#%symbol%#', '#%code%#'),
                        array( $wc_currencies[$currency], get_woocommerce_currency_symbol( $currency ), $currency), $format );
                    echo '<li rel="' . $currency . '" >' . $currency_format . '</li>';
                }
            }
            
            echo '</ul>';
            echo '</div>';
        }
        else if ( class_exists('WOOCS') && class_exists('WooCommerce') ) { /* Support WooCommerce Currency Switcher */
            global $WOOCS;
            $currencies = $WOOCS->get_currencies();
            if ( ! is_array($currencies) ) {
                return;
            }
            ?>
            <div class="wcml_currency_switcher">
                <a href="javascript: void(0)" class="wcml_selected_currency"><?php echo esc_html( $WOOCS->current_currency ); ?></a>
                <ul>
                    <?php 
                    foreach ( $currencies as $key => $currency ) {
                        $link = add_query_arg( 'currency', $currency['name'] );
                        echo '<li rel="' . $currency['name'] . '"><a href="' . esc_url( $link ) . '">' . esc_html( $currency['name'] ) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <?php
        } else {  /* Demo html */
            ?>
            <div class="wcml_currency_switcher">
                <a href="javascript: void(0)" class="wcml_selected_currency">USD</a>
                <ul>
                    <li rel="USD">USD</li>
                    <li rel="EUR">EUR</li>
                    <li rel="AUD">AUD</li>
                </ul>
            </div>
            <?php
        }
    }
}

if( ! function_exists('mipro_wpml_language_selector') ) {
    function mipro_wpml_language_selector() {
        if ( function_exists('icl_get_languages') ) {
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if ( ! empty( $languages ) ) {
                $active_lang = '';
                $other_langs = '';
                foreach ( $languages as $lang ) {
                    if ( ! $lang['active'] ) {
                        $other_langs .= '<li><a href="' . esc_url( $lang['url'] ) . '">';
                    }
                    if ( $lang['country_flag_url'] ) {
                        if ( $lang['active'] ) {
                            $active_lang .= '<img src="' . esc_url( $lang['country_flag_url'] ) . '" height="12" alt="' . esc_attr( $lang['language_code'] ) . '" width="18" />';
                        } else {
                            $other_langs .= '<img src="' . esc_url( $lang['country_flag_url'] ) . '" height="12" alt="' . esc_attr($lang['language_code']) . '" width="18" />';
                        }
                    }
                    if ( $lang['active'] ) {
                        $active_lang .= mipro_icl_language( $lang['native_name'], $lang['translated_name'] );
                    } else {
                        $other_langs .= mipro_icl_language( $lang['native_name'], $lang['translated_name'] );
                    }
                    if ( ! $lang['active'] ) {
                        $other_langs .= '</a></li>';
                    }
                }
                ?>
                <div id="lang_sel_click" class="lang_sel_click">
                    <ul>
                        <li>
                            <a href="#" class="lang_sel_sel icl-en"><?php echo wp_kses_post( $active_lang ); ?></a>
                            <?php if ( $other_langs ) : ?>
                                <ul class="lang-dropdown">
                                    <?php echo wp_kses_post($other_langs); ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <?php
            }
        }
        else { /* Demo html */
            ?>
            <div id="lang_sel_click" class="lang_sel_click">
                <ul>
                    <li>
                        <a href="#" class="lang_sel_sel icl-en">English</a>
                        <ul class="lang-dropdown">
                            <li class="icl-fr"><a href="#"><span class="icl_lang_sel_native">French</span></a></li>
                            <li class="icl-de"><a href="#"><span class="icl_lang_sel_native">German</span></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}

function mipro_icl_language( $native_name, $translated_name = false, $lang_native_hidden = false, $lang_translated_hidden = false ) {
    if ( function_exists('icl_disp_language') ) {
        return icl_disp_language( $native_name, $translated_name, $lang_native_hidden, $lang_translated_hidden );
    }
    $ret = '';

    if ( ! $native_name && ! $translated_name ) {
        $ret = '';
    } elseif ( $native_name && $translated_name ) {
        $hidden1 = $hidden2 = $hidden3 = '';
        if ( $lang_native_hidden ) {
            $hidden1 = 'style="display:none;"';
        }
        if ( $lang_translated_hidden ) {
            $hidden2 = 'style="display:none;"';
        }
        if ( $lang_native_hidden && $lang_translated_hidden ) {
            $hidden3 = 'style="display:none;"';
        }

        if ( $native_name != $translated_name ) {
            $ret =
            '<span ' .
            $hidden1 .
            ' class="icl_lang_sel_native">' .
            $native_name .
            '</span> <span ' .
            $hidden2 .
            ' class="icl_lang_sel_translated"><span ' .
            $hidden1 .
            ' class="icl_lang_sel_native">(</span>' .
            $translated_name .
            '<span ' .
            $hidden1 .
            ' class="icl_lang_sel_native">)</span></span>';
        } else {
            $ret = '<span ' . $hidden3 . ' class="icl_lang_sel_current">' . $native_name . '</span>';
        }
    } elseif ( $native_name ) {
        $ret = $native_name;
    } elseif ( $translated_name ) {
        $ret = $translated_name;
    }

    return $ret;
}
