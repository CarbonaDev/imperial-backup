<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

function wcsp_get_available_styles() {
  return array(
    'default'     => __( 'Padrão - Ícone Boleto', 'wc-simulador-parcelas' ),
    'default_pix' => __( 'Padrão - Ícone Pix', 'wc-simulador-parcelas' ),
    'none'        => __( 'Não carregar CSS', 'wc-simulador-parcelas' ),
  );
}

