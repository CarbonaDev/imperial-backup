<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'YITH_WCWL' ) ) {
	$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-my-account-navigation">
	<div class="account-user">
		<span class="account-image">
			<?php echo get_avatar( $user_id, 70 ); ?>
		</span>
		<span class="account-name">
			<?php echo esc_html( $current_user->display_name ); ?>
			<em class="account-id"><?php echo '#' . $user_id; ?></em>
		</span>
	</div>
	<ul class="my-account-nav">
		<?php if ( function_exists( 'wc_get_account_menu_items' ) ) : ?>
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				</li>
			<?php endforeach; ?>

			<?php if ( class_exists( 'YITH_WCWL' ) && $wishlist_page_id ) : ?>
				<li class="wishlist-account-element">
					<a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>"><?php echo esc_html( get_the_title( $wishlist_page_id ) ); ?></a>
				</li>
			<?php endif; ?>

			<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'customer-logout' ) ); ?>"><?php echo esc_html__( 'Logout', 'mipro' ); ?></a>
			</li>
		<?php endif; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
