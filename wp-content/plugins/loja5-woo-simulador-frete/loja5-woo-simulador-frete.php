<?php
/*
  Plugin Name: Simulador de Fretes - Loja5
  Description: Simulados de fretes na pagina do produto Woocommerce.
  Version: 1.0
  Author: Loja5.com.br
  Author URI: http://www.loja5.com.br
  Copyright: © 2009-2018 Loja5.com.br.
  License: Comercial
*/

if ( ! class_exists( ' WC_Loja5_Simulador_Frete' ) ) {
    
class WC_Loja5_Simulador_Frete {
    
    protected static $instance = null;
    
    private function __construct() {
		if(extension_loaded("IonCube Loader")) {
			if( !function_exists('is_plugin_active') ) {
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			//front
			if( is_plugin_active('woocommerce/woocommerce.php') ){
				if(version_compare(PHP_VERSION, '5.4.0', '<')) {
					include_once(dirname(__FILE__).'/classes/php53/simulador.php');
				}elseif(version_compare(PHP_VERSION, '5.5.0', '<')) {
					include_once(dirname(__FILE__).'/classes/php54/simulador.php');
				}elseif(version_compare(PHP_VERSION, '5.6.0', '<')){
					include_once(dirname(__FILE__).'/classes/php55/simulador.php');
				}elseif(version_compare(PHP_VERSION, '7.1.0', '<')){
					include_once(dirname(__FILE__).'/classes/php56/simulador.php');
				}elseif(version_compare(PHP_VERSION, '7.2.0', '<')){
					include_once(dirname(__FILE__).'/classes/php71/simulador.php');
				}else{
					include_once(dirname(__FILE__).'/classes/php72/simulador.php');
				}
				$simulador = new Front_Simulador_Frete_Loja5();
				$simulador->init();
			}
			//init
			if( is_admin() && is_plugin_active('woocommerce/woocommerce.php') ) {
				if(version_compare(PHP_VERSION, '5.4.0', '<')) {
					include_once(dirname(__FILE__).'/classes/php53/class.loja5.php');
					include_once(dirname(__FILE__).'/classes/php53/admin.php');
				}elseif(version_compare(PHP_VERSION, '5.5.0', '<')) {
					include_once(dirname(__FILE__).'/classes/php54/class.loja5.php');
					include_once(dirname(__FILE__).'/classes/php54/admin.php');
				}elseif(version_compare(PHP_VERSION, '5.6.0', '<')){
					include_once(dirname(__FILE__).'/classes/php55/class.loja5.php');
					include_once(dirname(__FILE__).'/classes/php55/admin.php');
				}elseif(version_compare(PHP_VERSION, '7.1.0', '<')){
					include_once(dirname(__FILE__).'/classes/php56/class.loja5.php');
					include_once(dirname(__FILE__).'/classes/php56/admin.php');
				}elseif(version_compare(PHP_VERSION, '7.2.0', '<')){
					include_once(dirname(__FILE__).'/classes/php71/class.loja5.php');
					include_once(dirname(__FILE__).'/classes/php71/admin.php');
				}else{
					include_once(dirname(__FILE__).'/classes/php72/class.loja5.php');
					include_once(dirname(__FILE__).'/classes/php72/admin.php');
				}
				$admin = new Admin_Simulador_Frete_Loja5();
				$admin->init();
			}elseif( is_admin() && !is_plugin_active('woocommerce/woocommerce.php') ){
				add_action( 'admin_notices', array( $this, 'alerta_versao' ) );
			}
		}else{
			add_action( 'admin_notices', array( $this, 'alerta_ioncube' ) );
		}
    }
    
    public function alerta_versao(){
        echo '<div class="error">';
        echo '<p><strong>Ops:</strong> O simulador de frete requer que exista o woocommerce instalado e ativado!</p>';
        echo '</div>';
    }
	
	public function alerta_ioncube(){
        echo '<div class="error">';
        echo '<p><strong>Ops:</strong> Sua hospedagem n&atilde;o possui o Ioncube ativado, solicite a mesma ativar ou veja com o gestor de seu host!</p>';
        echo '</div>';
    }
	
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

add_action( 'plugins_loaded', array( 'WC_Loja5_Simulador_Frete', 'get_instance' ) );

}
?>