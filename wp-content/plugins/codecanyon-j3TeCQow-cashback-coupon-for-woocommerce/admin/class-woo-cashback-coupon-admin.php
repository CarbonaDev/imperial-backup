<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wpcodelibrary.com/
 * @since      1.0.0
 *
 * @package    Wcc_Cashback_Coupon
 * @subpackage Wcc_Cashback_Coupon/admin
 */


class Wcc_Cashback_Coupon_Admin {
	
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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->load_dependencies();
		
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-cashback-coupon-admin.css', array(), $this->version, 'all' );
	}
	
	
	public static function load_dependencies() {
		/**
		 * The class responsible for defining function for display Html element
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/class-wcc-html-output.php';
		
		/**
		 * The class is responsible for display admin settings
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/woo-cashback-coupon-admin-display.php';
	}
	
	/**
	 * Function is used to send coupon to customer email address.
	 */
	
	function wcc_wpc_payment_complete( $order_id ) {
		$order        = wc_get_order( $order_id );
		$order_subtotal = $order->get_subtotal();
		$order_subtotal = number_format( $order_subtotal, 2 );
		$wcc_amount_text = get_option( 'wcc_amount_text', true );
		$wcc_discount_type = get_option( 'wcc_discount_type', true );
		if ($wcc_discount_type == 'wcc_percentage') {
			$wcc_amount_text = ($order_subtotal*$wcc_amount_text)/100;
			$wcc_amount_text1 = ($order_subtotal*$wcc_amount_text)/100;
		}
		$billingEmail = $order->billing_email;
		$code            = $this->generate_cashback_coupon( $billingEmail,$wcc_amount_text );
		$this->email_cashback_coupon( $billingEmail, $code, $wcc_amount_text,$order_id );
		
		
	}
	
	/**
	 * Generate cashback coupon
	 *
	 * @param string $email
	 * @param float  $amount
	 *
	 * @return string new coupon code
	 */
	public function generate_cashback_coupon( $email,$wcc_amount_text ) {
		$coupon_code   = uniqid( sanitize_title( $email ) );
		$new_coupon_id = wp_insert_post( array(
			'post_title'   => $coupon_code,
			'post_content' => '',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'shop_coupon',
		) );
		
		$wcc_individual_use   = get_option( 'wcc_individual_use', true );
		//$wcc_amount_text      = get_option( 'wcc_amount_text', true );
		$wcc_before_tax       = get_option( 'wcc_before_tax', true );
		$wcc_limit_text = get_option( 'wcc_limit_text', true );
		$wcc_limit_text = isset($wcc_limit_text) ? $wcc_limit_text :'';
		update_post_meta( $new_coupon_id, 'usage_limit', $wcc_limit_text );
		update_post_meta( $new_coupon_id, 'expiry_date', '' );
		update_post_meta( $new_coupon_id, 'apply_before_tax', $wcc_before_tax );
		update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
		update_post_meta( $new_coupon_id, 'discount_type', 'wcc_cashback' );
		update_post_meta( $new_coupon_id, 'coupon_amount', $wcc_amount_text );
		update_post_meta( $new_coupon_id, 'individual_use', $wcc_individual_use );
		update_post_meta( $new_coupon_id, 'product_ids', '' );
		update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
		update_post_meta( $new_coupon_id, 'customer_email', array( $email ) );
		
		return $coupon_code;
	}
	
	/**
	 * Function is used to send email.
	 *
	 * @param $email
	 * @param $coupon_code
	 * @param $amount
	 */
	
	public function email_cashback_coupon( $email, $coupon_code, $amount,$order_id ) {
		$blogname      = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$wcc_email_subject = get_option('wcc_email_subject');
		//$subject       = apply_filters( 'wcc_subject_cashback', sprintf( '[%s] %s', $blogname, esc_attr__( $wcc_email_subject, 'woo-cashback-coupon' ) ), $email, $coupon_code, $amount );
		$subject = sprintf( esc_attr__( '%s', 'woo-cashback-coupon' ), $wcc_email_subject );
		ob_start();
		do_action( 'woocommerce_email_header', $subject ); ?>
		<p><?php echo wp_kses_post(sprintf( esc_attr__( "To get your cashback use the following code during checkout:", 'woo-cashback-coupon' ), $blogname )); ?></p>
		<strong class="cls-email">
			<?php echo wp_kses_post($coupon_code); ?>
		</strong>
		
		<?php
		$message = ob_get_clean();
		$message = get_option('wcc_email_body');
		if (isset($message) && !empty($message)) {
			$vars = array(
				'{coupon_code}'       => $coupon_code,
				'{amount}'        => $amount,
				'{order_id}' => $order_id
			);
			
			$message = strtr($message, $vars);
		
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $email, $subject, $message, $headers );
		}
		
	}
	
	/**
	 * Add discount type
	 */
	public function wcc_add_discount_type( $discount_types ) {
		$discount_types['wcc_cashback'] = esc_attr__( 'WCC Cashback', 'woo-cashback-coupon' );
		return $discount_types;
	}
	
}
