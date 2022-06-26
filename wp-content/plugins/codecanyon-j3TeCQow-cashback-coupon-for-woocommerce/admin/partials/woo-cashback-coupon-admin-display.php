<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.wpcodelibrary.com
 * @since      1.0.0
 *
 * @package    Wcc_Cashback_Coupon
 * @subpackage Wcc_Cashback_Coupon/admin/partials
 */
class Wcc_Admin_Display {
	
	/**
	 * Hook in methods
	 *
	 * @since    1.0.0
	 * @access   static
	 */
	public static function init() {
		
		add_action( 'admin_menu', array( __CLASS__, 'wcc_settings_page' ) );
	}
	
	/**
	 * Create Estimated Date settings page.
	 *
	 * @since 1.0.0
	 */
	
	public static function wcc_settings_page() {
		add_submenu_page( 'woocommerce', 'Cashback Coupon Setting', 'Cashback Coupon Setting', 'manage_options', 'wcc-page', array( __CLASS__, 'wcc_general_setting_fields'
		) );
	}
	
	/**
	 * Generate Estimated Date settings fields array.
	 *
	 * @return array
	 */
	
	public static function wccw_general_setting_fields() {
		
		$fields[] = array(
			'title' => esc_attr__( 'Cashback Coupons Settings', 'woo-cashback-coupon' ),
			'type'  => 'title',
		);
		$fields[] = array(
			'title'    => esc_attr__( 'Enable Cashback', 'woo-cashback-coupon' ),
			'id'       => 'wcc_enable',
			'type'     => 'checkbox',
			'default'  => '',
			'desc'     => esc_attr__( 'Check this option to enable cashback coupons', 'woo-cashback-coupon' ),
			'class'    => '',
			'desc_tip' => '',
		);

		$fields[] = array(
			'title'   => esc_attr__( 'Discount Type ', 'woo-cashback-coupon' ),
			'id'      => 'wcc_discount_type',
			'type'    => 'select',
			'default' => 'fixed',
			'class'   => '',
			'desc'    => esc_attr__( 'Select discount type either fixed or percentage.', 'woo-cashback-coupon' ),
			'options' => array( 'wcc_fixed' => 'Fixed', 'wcc_percentage' => 'Percentage' ),
		);
		
		$fields[] = array(
			'title'   => esc_attr__( 'Cashback Amount', 'woo-cashback-coupon' ),
			'id'      => 'wcc_amount_text',
			'type'    => 'text',
			'default' => '0',
			'desc'    => esc_attr__( 'Enter amount which you want to send customers as cashback.', 'woo-cashback-coupon' ),
			'class'   => 'regular-text',
		);
		$fields[] = array(
			'title'   => esc_attr__( 'Limit Usage', 'woo-cashback-coupon' ),
			'id'      => 'wcc_limit_text',
			'type'    => 'number',
			'default' => '1',
			'desc'    => esc_attr__( 'How many times coupon can be used before it void.', 'woo-cashback-coupon' ),
			'class'   => 'regular-text',
		);
		$fields[] = array(
			'title'    => esc_attr__( 'Individual use only', 'woo-cashback-coupon' ),
			'id'       => 'wcc_individual_use',
			'type'     => 'checkbox',
			'default'  => 'no',
			'class'    => '',
			'desc'     => esc_attr__( 'Check this box if the coupon cannot be used in conjunction with other coupons.', 'woo-cashback-coupon'),
			'desc_tip' => '',
		);
		$fields[] = array(
			'title'    => esc_attr__( 'Apply before tax', 'woo-cashback-coupon' ),
			'id'       => 'wcc_before_tax',
			'type'     => 'checkbox',
			'default'  => 'no',
			'class'    => '',
			'desc'     => esc_attr__( 'Cashback coupons applied before tax.', 'woo-cashback-coupon'),
			'desc_tip' => '',
		);
		$fields[] = array(
			'title'    => esc_attr__( 'Delete coupon after use', 'woo-cashback-coupon' ),
			'id'       => 'wcc_delete_after_use',
			'type'     => 'checkbox',
			'default'  => 'yes',
			'class'    => '',
			'desc'     => esc_attr__( 'When the cashback is used up, delete the coupon.', 'woo-cashback-coupon' ),
			'desc_tip' => '',
		);

		$fields[] = array(
			'title'   => esc_attr__( 'Email Subject', 'woo-cashback-coupon' ),
			'id'      => 'wcc_email_subject',
			'type'    => 'text',
			'default' => 'Cashback',
			'desc'    => esc_attr__( 'Change email subject here, Default is "Cashback" ', 'woo-cashback-coupon' ),
			'class'   => 'regular-text',
		);
		
		$fields[] = array( 'type' => 'sectionend', 'id' => 'wcc_general_options_setting' );
		
		return $fields;
	}
	
	/**
	 * Create settings html.
	 *
	 * @since 1.0.0
	 */
	public static function wcc_general_setting_fields() {
		
		$genral_setting_fields = self::wccw_general_setting_fields();
		$Html_output           = new Wcc_Html_output();
		$Html_output->save_fields( $genral_setting_fields );

		
		?>

		<div class="div_general_settings">
		<div class="div_wcc_settings">
		<?php if ( isset( $_POST['wcc_intigration'] ) ): // WPCS: CSRF ok.
				if (isset($_POST['wcc_email_body']) && !empty($_POST['wcc_email_body'])) {
					update_option('wcc_email_body', wp_kses_post($_POST['wcc_email_body']));
				}else {
					$body_cnt = '';
			$blogname      = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
			$body_cnt .='<p>'. wp_kses_post(sprintf( esc_attr__( "To get your cashback use the following code during checkout:", 'woo-cashback-coupon' ), $blogname )).'</p>';
			$body_cnt .='<strong>{coupon_code}</strong>';
					update_option('wcc_email_body', wp_kses_post($body_cnt));
				}
			?>
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><?php echo wp_kses_post('<strong>' . esc_attr__( 'Settings were saved successfully.', 'woo-cashback-coupon' ) . '</strong>'); ?></p></div>
		
		<?php
		endif;
		?>
		<form id="wcc_integration_form_general" enctype="multipart/form-data" action="" method="post">
			<?php $Html_output->init( $genral_setting_fields ); ?>
			<lable style="font-size:15px;font-weight:bold;"><?php echo esc_html__( 'Email Body.', 'woo-cashback-coupon' );?></lable>
			<?php 
			$settings = array( 'textarea_name' => 'wcc_email_body',
			 'media_buttons' => false );
			 $body_cnt = '';
			$blogname      = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
			$body_cnt .='<p>'. wp_kses_post(sprintf( esc_attr__( "To get your cashback use the following code during checkout:", 'woo-cashback-coupon' ), $blogname )).'</p>';
			$body_cnt .='<strong>{coupon_code}</strong>';
			$get_cnt = get_option('wcc_email_body');
			$content_body = !empty($get_cnt ) ? $get_cnt : $body_cnt;
			wp_editor( $content_body, "wcc_email_body", $settings ); 
			
			?>
			<br/><br/>
			<div style="font-size:15px;line-height:1.5em">
				<strong>{coupon_code} - Generated coupon code.</strong><br/>
				<strong>{amount} - Use this variable to include amount in email.</strong><br/>
				<strong>{order_id} - Use this variable to include order id in email.</strong>
			</div>
			<p class="submit">
				<input type="submit" name="wcc_intigration" class="button-primary" value="Save Settings">
			</p>
		</form>
		</div><?php
	}
	
}

Wcc_Admin_Display::init();