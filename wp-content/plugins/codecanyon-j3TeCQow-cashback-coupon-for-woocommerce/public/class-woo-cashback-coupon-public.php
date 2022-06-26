<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wcc_Cashback_Coupon
 * @subpackage Wcc_Cashback_Coupon/public
 * @author     WPCodelibrary <wpcodelibrary@gmail.com>
 */
class Wcc_Cashback_Coupon_Public {
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		
	}
	
	
	
	/**
	 * delete after purchase
	 */
	public function delete_coupon_after_use() {
		
		$coupons = WC()->cart->get_coupons();
		if ( $coupons ) {
			foreach ( $coupons as $code => $coupon ) {
				if ( ( 'wcc_cashback' === $coupon->type ) ) {
				
			
			$limit = (!empty($coupon->usage_limit) ) ? intval($coupon->usage_limit) : null;
			$cnt = (int) $coupon->usage_count;
			$usage_left = $limit - $cnt;
					$wcc_delete_after_use = get_option( 'wcc_delete_after_use', true );
					if ( 'yes' === $wcc_delete_after_use && $usage_left <= 0) {
						wp_delete_post( $coupon->get_id() );
					}
				}
			}
		}
	}
	
	/**
	 * Function is used to get coupon amount.
	 *
	 * @return mixed
	 */
	public function wcc_coupon_get_discount_amount( $discount, $discounting_amount, $cart_item, $single, $coupon ) {

		if ( ( 'wcc_cashback' === $coupon->type ) && ! is_null( $cart_item ) ) {
			$discount_percent = 0;
			if ( WC()->cart->subtotal_ex_tax ) {
				$discount_percent = ( wc_get_price_excluding_tax(	$cart_item['data']) * $cart_item['quantity'] ) / WC()->cart->subtotal_ex_tax;
			}
			$discount = min( ( $coupon->amount * $discount_percent ) / $cart_item['quantity'], $discounting_amount );
		} elseif ( ( 'wcc_cashback' === $coupon->type ) ) {
			$discount = min( $coupon->amount, $discounting_amount );
		}
		
		return $discount;
	}
	
	/**
	 * Function is used to validate coupon.
	 * @return bool
	 */
	public function wcc_coupon_is_valid( $valid, $coupon ) {
		if ( $coupon->is_type( array( 'wcc_cashback' ) ) ) {
			return $valid = true;
		}
		
		return $valid;
	}
	
}
