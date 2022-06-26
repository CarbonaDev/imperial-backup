<?php

/**
* Plugin Name: Carbona - Metodo de Envio Personalizado
* Plugin URI: https://carbonadev.com
* Description: 
* Version: 1.0.0
* Author: Pedro Roque, Gabriel Bittencourt
* 
s
*/

if ( ! defined( 'WPINC' ) ) {

die;

}
/*
* Check if WooCommerce is active
*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

function Carbona_Metodo_Envio() {

if ( ! class_exists( 'Carbona_Metodo_Envio' ) ) {

class Carbona_Metodo_Envio extends WC_Shipping_Method {

/**

* Constructor for your shipping class

*

* @access public

* @return void

*/

public function __construct() {

$this->id                 = 'carbonaenvio';

$this->method_title       = __( 'Carbona - Envio Gratis', 'carbonaenvio' );

$this->method_description = __( 'Envio gratis personalizavel!', 'carbonaenvio' );

$this->init();

$this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';

$this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Carbona Envio', 'carbonaenvio' );

$this->method_description = __( 'Custom Shipping Method for NjengahPlus', 'njengahplus' );

// Availability & Countries

$this->availability = 'including';

$this->countries = array(

'BR', // Brasil

);

$this->init();


}

/**
* Init your settings
*
* @access public

* @return void

*/

function init() {

// Load the settings API

$this->init_form_fields();

$this->init_settings();

// Save settings in admin if you have any defined

add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );

}


/**

* Define settings field for this shipping

* @return void

*/

function init_form_fields() {

$this->form_fields = array(

'enabled' => array(
'title' => __( 'Enable', 'njengahplus' ),
'type' => 'checkbox',
'description' => __( 'Habilitar este metodo.', 'carbonaenvio' ),
'default' => 'yes'

),


'title' => array(
'title' => __( 'Title', 'carbonaenvio' ),
'type' => 'text',
'description' => __( 'Titulo a ser mostrado no site.', 'carbonaenvio' ),
'default' => __( 'Envio Carbona', 'carbonaenvio' )

),

'preco' => array(
'title' => __( 'Pre&ccedil;o m&iacute;nimo para desconto: ', 'carbonaenvio' ),
'type' => 'number'

),

'categoria' => array(
'title' => __( 'Categorias : ', 'carbonaenvio' ),
'type' => 'number'

),

);


}

/**
* This function is used to calculate the shipping cost. Within this function, we can check for weights, dimensions, and other parameters.
*
* @access public
* @param mixed $package
 @return void
*/

public function calculate_shipping( $package ) {

$weight = 0;

$cost = 0;

$country = $package["destination"]["country"];

foreach ( $package['contents'] as $item_id => $values )
{

$_product = $values['data'];
$weight = $weight + $_product->get_weight() * $values['quantity'];

}

$weight = wc_get_weight( $weight, 'kg' );

if( $weight <= 10 ) {
$cost = 0;
} elseif( $weight <= 30 ) {
$cost = 5;
} elseif( $weight <= 50 ) {
$cost = 10;
} else {
$cost = 20;
}

$countryZones = array(

'BR' => 0
);


$zonePrices = array(
0 => 10,
1 => 30,
);


$zoneFromCountry = $countryZones[ $country ];

$priceFromZone = $zonePrices[ $zoneFromCountry ];

$cost += $priceFromZone;

$rate = array(

'id' => $this->id,
'label' => $this->title,
'cost' => $cost
);

$this->add_rate( $rate );

}

}

}

}


add_action( 'woocommerce_shipping_init', 'Carbona_Metodo_Envio' );

function add_Carbona_Metodo_Envio( $methods ) {

$methods[] = 'Carbona_Metodo_Envio';
return $methods;
}

add_filter( 'woocommerce_shipping_methods', 'add_Carbona_Metodo_Envio' );

}