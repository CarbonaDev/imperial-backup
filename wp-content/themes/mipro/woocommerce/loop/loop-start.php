<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */
?>

<?php
$data_attr = array();
if ( mipro_get_opt( 'kft_ajax_shop') ) {
	if ( isset( $_GET['min_price'] ) ) {
		$data_attr[] = 'data-min_price=' . esc_attr( $_GET['min_price'] );
	}
	if ( isset( $_GET['max_price'] ) ) {
		$data_attr[] = 'data-max_price=' .  esc_attr( $_GET['max_price'] );
	}
}
?>
<div class="products" <?php echo esc_attr( implode(' ', $data_attr) ); ?>>