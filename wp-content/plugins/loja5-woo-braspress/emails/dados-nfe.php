<?php
do_action( 'woocommerce_email_header', $email_heading, $email ); 
?>

<p><?php printf( esc_html__( 'Ola %s,', 'loja5-woo-braspress' ), esc_html( $nome ) ); ?></p>

<p><?php echo $mensagem;?></p>

<?php 
if($order){
	do_action( 'woocommerce_email_order_details', $order, false, false, $email );
	do_action( 'woocommerce_email_order_meta', $order, false, false, $email );
}
?>

<?php
do_action( 'woocommerce_email_footer', $email );
?>