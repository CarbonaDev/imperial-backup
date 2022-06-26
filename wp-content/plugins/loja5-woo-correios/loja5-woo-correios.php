<?php
/*
  Plugin Name: Correios Online e Offline - Loja5
  Description: Integração aos Correios do Brasil
  Version: 1.0
  Author: Loja5.com.br
  Author URI: http://www.loja5.com.br
  Copyright: © 2009-2021 Loja5.com.br.
  License: Comercial
*/

define('LOJA5_WOO_CORREIOS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ));
define('LOJA5_WOO_CORREIOS_REG_PG', 20);
define('LOJA5_WOO_CORREIOS_WEBSERVICE_TIMEOUT', 10);
define('LOJA5_WOO_CORREIOS_VAL_MIN_DEC', 22.50);
define('LOJA5_WOO_CORREIOS_WEBSERVICE', 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?');
define('LOJA5_WOO_CORREIOS_OFFLINE_PURO', true);
define('LOJA5_WOO_CORREIOS_OFFLINE_ALERTAS', true);

if ( ! class_exists( ' WC_Loja5_Correios' ) ) {
	
//atalhos
function plugin_action_links_loja5_woo_correios( $links ) {
    $plugin_links = array();
    $plugin_links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=shipping&section=correios-online-offline' ) ) . '">' . __( 'Configurar', 'loja5-woo-correios' ) . '</a>';
    return array_merge( $plugin_links, $links );
}
if(is_admin()) {
    add_filter('plugin_action_links_'.plugin_basename( __FILE__ ),'plugin_action_links_loja5_woo_correios');
}

//custom 
function tratar_frete_loja5_woo_correios($valor,$servico='',$instance=0){
	return $valor;
}

//banco de dados 
function install_woo_loja5_correios(){
	global $wpdb;
	//cria as tabelas
	$wpdb->query("CREATE TABLE IF NOT EXISTS `correios_offline5_base` (
		`id` INT(15) NOT NULL AUTO_INCREMENT,
		`uf` VARCHAR(2) NOT NULL,
		`detalhes` VARCHAR(60) NOT NULL,
		`inicio` INT(5) NOT NULL,
		`fim` INT(5) NOT NULL,
		`base_cep` INT(8) NOT NULL,
		`custom` INT(1) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)
	)
	COLLATE='latin1_swedish_ci'
	ENGINE=InnoDB
	AUTO_INCREMENT=1;");
	$wpdb->query("CREATE TABLE IF NOT EXISTS `correios_offline5_cotacoes` (
		`id` INT(15) NOT NULL AUTO_INCREMENT,
		`id_servico` INT(5) NULL DEFAULT NULL,
		`erro` CHAR(50) NULL DEFAULT NULL,
		`valor` FLOAT(10,2) NOT NULL DEFAULT '0.00',
		`peso` FLOAT(10,2) NOT NULL DEFAULT '0.00',
		`prazo` INT(15) NOT NULL DEFAULT '0',
		`cep_base` VARCHAR(9) NOT NULL,
		`cep_inicio` VARCHAR(9) NOT NULL,
		`cep_fim` VARCHAR(9) NOT NULL,
		`atualizado` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
		`custom` INT(1) NOT NULL DEFAULT '0',
		`cliente` INT(1) NOT NULL DEFAULT '0',
		PRIMARY KEY (`id`)
	)
	COLLATE='latin1_swedish_ci'
	ENGINE=InnoDB
	AUTO_INCREMENT=1;");
	$wpdb->query("CREATE TABLE IF NOT EXISTS `correios_offline5_tabelas` (
		`id` INT(15) NOT NULL AUTO_INCREMENT,
		`id_servico` INT(5) NULL DEFAULT NULL,
		`titulo` CHAR(50) NULL DEFAULT NULL,
		`atualizado` TIMESTAMP NULL DEFAULT NULL,
		PRIMARY KEY (`id`)
	)
	COLLATE='latin1_swedish_ci'
	ENGINE=InnoDB
	AUTO_INCREMENT=1;");
	//cria os registros iniciais
	$wpdb->query("INSERT INTO `correios_offline5_base` (`id`, `uf`, `detalhes`, `inicio`, `fim`, `base_cep`, `custom`) VALUES
	(1, 'SP', 'SÃO PAULO - CAPITAL 1', 1000, 5999, 5999999, 0),
	(3, 'SP', 'SÃO PAULO - REGIÃO METROPOLITANA 1', 8500, 9999, 9999999, 0),
	(4, 'SP', 'SÃO PAULO - LITORAL', 10000, 11999, 11999999, 0),
	(5, 'SP', 'SÃO PAULO - INTERIOR 1', 12000, 12999, 12999999, 0),
	(6, 'RJ', 'RIO DE JANEIRO - CAPITAL', 20000, 23799, 23799999, 0),
	(7, 'RJ', 'RIO DE JANEIRO - REGIÃO METROPOLITANA', 23800, 26600, 26600999, 0),
	(8, 'RJ', 'RIO DE JANEIRO - INTERIOR 1', 26601, 27999, 27999999, 0),
	(9, 'ES', 'ESPIRITO SANTO - CAPITAL', 29000, 29099, 29099999, 0),
	(10, 'ES', 'ESPIRITO SANTO - INTERIOR', 29100, 29999, 29999999, 0),
	(11, 'MG', 'MINAS GERAIS - CAPITAL', 30000, 31999, 31999999, 0),
	(12, 'MG', 'MINAS GERAIS - REGIÃO METROPOLITANA', 32000, 34999, 34999999, 0),
	(13, 'MG', 'MINAS GERAIS - INTERIOR 1', 35000, 35999, 35990999, 0),
	(14, 'BA', 'BAHIA - CAPITAL', 40000, 42599, 42599999, 0),
	(15, 'BA', 'BAHIA - REGIÃO METROPOLITANA', 42600, 44470, 44470999, 0),
	(16, 'BA', 'BAHIA - INTERIOR 1', 44471, 44999, 44999999, 0),
	(17, 'SE', 'SERGIPE - CAPITAL', 49000, 49099, 49098999, 0),
	(18, 'SE', 'SERGIPE - INTERIOR', 49100, 49999, 49999999, 0),
	(19, 'PE', 'PERNAMBUCO - CAPITAL', 50000, 52999, 52999999, 0),
	(20, 'PE', 'PERNAMBUCO - REGIÃO METROPOLITANA', 53000, 54999, 54999999, 0),
	(21, 'PE', 'PERNAMBUCO - INTERIOR 1', 55000, 55999, 55999999, 0),
	(22, 'AL', 'ALAGOAS - CAPITAL', 57000, 57099, 57099999, 0),
	(23, 'AL', 'ALAGOAS - INTERIOR', 57100, 57999, 57999999, 0),
	(24, 'PB', 'PARAIBA - CAPITAL', 58000, 58099, 58099999, 0),
	(25, 'PB', 'PARAIBA - INTERIOR', 58100, 58999, 58990999, 0),
	(26, 'RN', 'RIO GRANDE DO NORTE - CAPITAL', 59000, 59139, 59139999, 0),
	(27, 'RN', 'RIO GRANDE DO NORTE - INTERIOR', 59140, 59999, 59999999, 0),
	(28, 'CE', 'CEARA - CAPITAL 1', 60000, 60999, 60999999, 0),
	(29, 'CE', 'CEARA - REGIÃO METROPOLITANA', 61600, 61900, 61900999, 0),
	(30, 'CE', 'CEARA - INTERIOR 1', 61901, 61999, 61999999, 0),
	(31, 'PI', 'PIAUI - CAPITAL', 64000, 64099, 64099999, 0),
	(32, 'PI', 'PIAUI - INTERIOR', 64100, 64999, 64999999, 0),
	(33, 'MA', 'MARANHAO - CAPITAL 1', 65000, 65099, 65099999, 0),
	(34, 'MA', 'MARANHAO - INTERIOR', 65110, 65999, 65999999, 0),
	(35, 'PA', 'PARA - CAPITAL', 66000, 66999, 66999999, 0),
	(36, 'PA', 'PARA - REGIÃO METROPOLITANA', 67000, 67999, 67999999, 0),
	(37, 'PA', 'PARA - INTERIOR', 68000, 68899, 68899999, 0),
	(38, 'AP', 'AMAPA - CAPITAL 1', 68900, 68911, 68911999, 0),
	(39, 'AP', 'AMAPA - INTERIOR', 68915, 68999, 68999999, 0),
	(40, 'AM', 'AMAZONAS - CAPITAL', 69000, 69099, 69099999, 0),
	(41, 'AM', 'AMAZONAS - INTERIOR', 69100, 69299, 69299999, 0),
	(42, 'RR', 'RORAIMA - CAPITAL', 69300, 69339, 69339999, 0),
	(43, 'RR', 'RORAIMA - INTERIOR', 69340, 69399, 69399999, 0),
	(44, 'AC', 'ACRE - CAPITAL', 69900, 69924, 69924999, 0),
	(45, 'AC', 'ACRE - INTERIOR', 69925, 69999, 69999999, 0),
	(46, 'DF', 'BRASILIA 1', 70000, 72799, 72799999, 0),
	(47, 'DF', 'BRASILIA 2', 73000, 73699, 73699999, 0),
	(48, 'GO', 'GOAIS - CAPITAL', 74000, 74899, 74899999, 0),
	(49, 'GO', 'GOAIS - INTERIOR 1', 72800, 72999, 72980999, 0),
	(50, 'TO', 'TOCANTINS - CAPITAL 1', 77000, 77249, 77249999, 0),
	(51, 'TO', 'TOCANTINS - INTERIOR', 77300, 77999, 77999999, 0),
	(52, 'MT', 'MATO GROSSO - CAPITAL 1', 78000, 78099, 78099999, 0),
	(53, 'MT', 'MARO GROSSO - INTERIOR', 78110, 78899, 78899999, 0),
	(54, 'RO', 'RONDONIA - CAPITAL 1', 76800, 76834, 76834999, 0),
	(55, 'RO', 'RONDONIA - INTERIOR', 76850, 76999, 76999999, 0),
	(56, 'MS', 'MATO GROSSO DO SUL - CAPITAL 1', 79000, 79124, 79124999, 0),
	(57, 'MS', 'MATO GROSSO DO SUL - INTERIOR', 79130, 79999, 79999999, 0),
	(58, 'PR', 'PARANA - CAPITAL', 80000, 82999, 82999999, 0),
	(59, 'PR', 'PARANA - REGIAO METROPOLITANA', 83000, 83800, 83800999, 0),
	(60, 'PR', 'PARANA - INTERIOR 1', 83801, 83999, 83999999, 0),
	(61, 'SC', 'SANTA CATARINA - CAPITAL', 88000, 88099, 88099999, 0),
	(62, 'SC', 'SANTA CATARINA - REGIÃO METROPOLITANA', 88100, 88469, 88469999, 0),
	(63, 'SC', 'SANTA CATARINA - INTERIOR 1', 88470, 88999, 88999999, 0),
	(64, 'RS', 'RIO GRANDE DO SUL - CAPITAL', 90000, 91999, 91999999, 0),
	(65, 'RS', 'RIO GRANDE DO SUL - REGIÃO METROPOLITANA', 92000, 94900, 94900999, 0),
	(66, 'RS', 'RIO GRANDE DO SUL - INTERIOR 1', 94901, 94999, 94999999, 0),
	(67, 'SP', 'SÃO PAULO - CAPITAL 2', 8000, 8499, 8499999, 0),
	(68, 'SP', 'SÃO PAULO - REGIÃO METROPOLITANA 2', 6000, 7999, 7999999, 0),
	(69, 'GO', 'GOAIS - INTERIOR 2', 73700, 73999, 73999999, 0),
	(70, 'GO', 'GOIAS - INTERIOR 3', 74900, 76799, 76750999, 0),
	(71, 'CE', 'CEARA - CAPITAL 2', 61000, 61599, 61599999, 0),
	(72, 'MA', 'MARANHAO - CAPITAL 2', 65100, 65109, 65109999, 0),
	(73, 'AP', 'AMAPA - CAPITAL 2', 68912, 68914, 64914999, 0),
	(74, 'RO', 'RONDONIA - CAPITAL 2', 76835, 76849, 76849999, 0),
	(75, 'TO', 'TOCANTINS - CAPITAL 2', 77250, 77299, 77299999, 0),
	(76, 'MT', 'MATO GROSSO - CAPITAL 2', 78100, 78109, 78109999, 0),
	(77, 'MS', 'MATO GROSSO DO SUL - CAPITAL 2', 79125, 79129, 79129999, 0),
	(78, 'SP', 'SÃO PAULO - INTERIOR 2', 13000, 13999, 13999999, 0),
	(79, 'SP', 'SÃO PAULO - INTERIOR 3', 14000, 14999, 14999999, 0),
	(80, 'SP', 'SÃO PAULO - INTERIOR 4', 15000, 15999, 15999999, 0),
	(81, 'SP', 'SÃO PAULO - INTERIOR 5', 16000, 16999, 16999999, 0),
	(82, 'SP', 'SÃO PAULO - INTERIOR 6', 17000, 17999, 17999999, 0),
	(83, 'SP', 'SÃO PAULO - INTERIOR 7', 18000, 18999, 18999999, 0),
	(84, 'SP', 'SÃO PAULO - INTERIOR 8', 19000, 19999, 19999999, 0),
	(85, 'RJ', 'RIO DE JANEIRO - INTERIOR 2', 28000, 28999, 28999999, 0),
	(87, 'BA', 'BAHIA - INTERIOR 2', 45000, 45999, 45999999, 0),
	(88, 'BA', 'BAHIA - INTERIOR 3', 46000, 46999, 46999999, 0),
	(89, 'BA', 'BAHIA - INTERIOR 4', 47000, 47999, 47999999, 0),
	(90, 'BA', 'BAHIA - INTERIOR 5', 48000, 48999, 48999999, 0),
	(91, 'CE', 'CEARA - INTERIOR 2', 62000, 62999, 62999999, 0),
	(92, 'CE', 'CEARA - INTERIOR 3', 63000, 63999, 63999999, 0),
	(93, 'MG', 'MINAS GERAIS - INTERIOR 2', 36000, 36999, 36999999, 0),
	(94, 'MG', 'MINAS GERAIS - INTERIOR 3', 37000, 37999, 37999999, 0),
	(95, 'MG', 'MINAS GERAIS - INTERIOR 4', 38000, 38999, 38999999, 0),
	(96, 'MG', 'MINAS GERAIS - INTERIOR 5', 39000, 39999, 39990000, 0),
	(97, 'PE', 'PERNAMBUCO - INTERIOR 2', 56000, 56999, 56999999, 0),
	(98, 'PR', 'PARANA - INTERIOR 2', 84000, 84999, 84999999, 0),
	(99, 'PR', 'PARANA - INTERIOR 3', 85000, 85999, 85999999, 0),
	(100, 'PR', 'PARANA - INTERIOR 4', 86000, 86999, 86999999, 0),
	(101, 'PR', 'PARANA - INTERIOR 5', 87000, 87999, 87999999, 0),
	(102, 'SC', 'SANTA CATARINA - INTERIOR 2', 89000, 89999, 89999999, 0),
	(103, 'RS', 'RIO GRANDE DO SUL - INTERIOR 2', 95000, 95999, 95999999, 0),
	(104, 'RS', 'RIO GRANDE DO SUL - INTERIOR 3', 96000, 96999, 96999999, 0),
	(105, 'RS', 'RIO GRANDE DO SUL - INTERIOR 4', 97000, 97999, 97999999, 0),
	(106, 'RS', 'RIO GRANDE DO SUL - INTERIOR 5', 98000, 98999, 98999999, 0),
	(107, 'RS', 'RIO GRANDE DO SUL - INTERIOR 6', 99000, 99999, 99999999, 0);");	
	$wpdb->query("INSERT INTO `correios_offline5_tabelas` (`id`, `id_servico`, `titulo`, `atualizado`) VALUES
	(1, 4510, 'Correios - PAC 04510 (sem contrato)', '2019-02-10 14:29:37'),
	(2, 4669, 'Correios - PAC 04669 (com contrato)', '2019-02-10 11:16:13'),
	(5, 4596, 'Correios - PAC 04596 (com contrato basico)', '2019-02-10 11:16:13'),
	(3, 4014, 'Correios - Sedex 04014 (sem contrato)', '2019-02-10 16:40:22'),
	(6, 4553, 'Correios - Sedex 04553 (com contrato basico)', '2019-02-10 11:16:13'),
	(4, 4162, 'Correios - Sedex 04162 (com contrato)', '2019-02-10 11:17:02'),
	(7, 3050, 'Correios - Sedex 03050 (com contrato)', '2019-02-10 11:17:02'),
	(8, 3085, 'Correios - PAC 03085 (com contrato)', '2019-02-10 11:17:02'),
	(9, 3220, 'Correios - Sedex 03220 (com contrato)', '2019-02-10 11:17:02'),
	(10, 3298, 'Correios - PAC 03298 (com contrato)', '2019-02-10 11:17:02'),
	(11, 3140, 'Correios - Sedex 12 03140 (com contrato)', '2019-02-10 11:17:02'),
	(12, 3158, 'Correios - Sedex 10 03158 (com contrato)', '2019-02-10 11:17:02'),
	(13, 3204, 'Correios - Sedex Hoje 03204 (com contrato)', '2019-02-10 11:17:02'),
	(14, 4227, 'Correios - PAC Mini 04227', '2019-02-10 11:17:02');");	
}
	
function uninstall_woo_loja5_correios(){
	global $wpdb;
	//remove as tabelas 
	$wpdb->query("DROP TABLE IF EXISTS `correios_offline5_base`");	
	$wpdb->query("DROP TABLE IF EXISTS `correios_offline5_cotacoes`");	
	$wpdb->query("DROP TABLE IF EXISTS `correios_offline5_tabelas`");			
}
   
//class modulo   
class WC_Loja5_Correios {
    
    protected static $instance = null;
    
    private function __construct() {
        $this->init();
        add_filter('woocommerce_shipping_methods', array( $this, 'include_methods'));
		add_filter('woocommerce_after_shipping_rate', array($this,'prazo_de_entrega_carrinho'), 100);
		add_filter('woocommerce_order_shipping_method', array($this,'prazo_de_entrega_pedido'), 100, 2);
		add_filter('woocommerce_order_item_display_meta_key', array($this,'prazo_de_entrega_pedido_key'), 100, 2);
		
    }

	public function prazo_de_entrega_carrinho( $metodo ) {
		$metas = $metodo->get_meta_data();
		$label = '';
		if(isset($metas['prazo_correios']) && !empty($metas['prazo_correios'])){
			$label .= '<br /><small>';
			$label .= sprintf( __( 'Entrega em até %s dia(s) úteis.', 'loja5-woo-correios' ), $metas['prazo_correios'] );
			$label .= '</small>';
		}elseif(isset($metas['prazo']) && !empty($metas['prazo'])){
			$label .= '<br /><small>';
			$label .= sprintf( __( 'Entrega em até %s dia(s) úteis.', 'loja5-woo-correios' ), $metas['prazo'] );
			$label .= '</small>';
		}
		echo $label;
	}
	
	public function prazo_de_entrega_pedido_key( $display_key, $meta ) {
		if($meta->key=='prazo_correios'){
			return __( 'Prazo (dias)', 'loja5-woo-correios' );
		}elseif($meta->key=='offline'){
			return __( 'Offline', 'loja5-woo-correios' );
		}elseif($meta->key=='prazo'){
			return __( 'Prazo (dias)', 'loja5-woo-correios' );
		}else{
			return $display_key;
		}
	}
	
	public function prazo_de_entrega_pedido( $name, $order ) {
		$names = array();
		foreach ( $order->get_shipping_methods() as $shipping_method ) {
			if ( $shipping_method->get_meta( 'prazo_correios' ) ) {
				$names[] = sprintf( __( '%s (entrega em até %s dia(s) úteis)', 'loja5-woo-correios' ), $shipping_method->get_name(), (int)$shipping_method->get_meta( 'prazo_correios' ) );
			}elseif( $shipping_method->get_meta( 'prazo' ) ){
				$names[] = sprintf( __( '%s (entrega em até %s dia(s) úteis)', 'loja5-woo-correios' ), $shipping_method->get_name(), (int)$shipping_method->get_meta( 'prazo' ) );
			} else {
				$names[] = $shipping_method->get_name();
			}
		}
		return implode( ', ', $names );
	}
	
	public function init() {
		if(extension_loaded("IonCube Loader")) {
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
				if(version_compare(PHP_VERSION, '5.6.0', '<')){
					include_once(dirname(__FILE__).'/classes/php55/loja5.php');
					include_once(dirname(__FILE__).'/classes/php55/abstract-correios.php');
					if( is_admin() ){
						include_once(dirname(__FILE__).'/classes/php55/admin.php');
					}
				}elseif(version_compare(PHP_VERSION, '7.1.0', '<')){
					include_once(dirname(__FILE__).'/classes/php56/loja5.php');
					include_once(dirname(__FILE__).'/classes/php56/abstract-correios.php');
					if( is_admin() ){
						include_once(dirname(__FILE__).'/classes/php56/admin.php');
					}
				}elseif(version_compare(PHP_VERSION, '7.2.0', '<')){
					include_once(dirname(__FILE__).'/classes/php71/loja5.php');
					include_once(dirname(__FILE__).'/classes/php71/abstract-correios.php');
					if( is_admin() ){
						include_once(dirname(__FILE__).'/classes/php71/admin.php');
					}
				}else{
					include_once(dirname(__FILE__).'/classes/php72/loja5.php');
					include_once(dirname(__FILE__).'/classes/php72/abstract-correios.php');
					if( is_admin() ){
						include_once(dirname(__FILE__).'/classes/php72/admin.php');
					}
				}
				include_once(dirname(__FILE__).'/classes/metodos-correios.php');
			}else{
				add_action( 'admin_notices', array( $this, 'alerta_versao' ) );
			}
		}else{
			add_action( 'admin_notices', array( $this, 'alerta_ioncube' ) );
		}
	}
	
	public function alerta_ioncube(){
        echo '<div class="error">';
        echo '<p><strong>Correios Offline [Loja5]:</strong> Sua hospedagem n&atilde;o possui o Ioncube ativado, solicite a mesma ativar ou veja com o gestor de seu host!</p>';
        echo '</div>';
    }
    
    public function alerta_versao(){
        echo '<div class="error">';
        echo '<p><strong>Correios Offline [Loja5]:</strong> Requer vers&atilde;o Woo 3.x ou superior, atualize seu Woo para vers&atilde;o compativel!</p>';
        echo '</div>';
    }
	
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
	
	public function include_methods( $methods ) {        
        if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
            $methods['loja5-correios-legacy'] = 'Loja5_Shipping_Correios_Legacy';
            $methods['loja5-correios-pac-04510'] = 'Loja5_Shipping_Correios_PAC_04510';
			$methods['loja5-correios-pac-04669'] = 'Loja5_Shipping_Correios_PAC_04669';
            $methods['loja5-correios-sedex-04014'] = 'Loja5_Shipping_Correios_Sedex_04014';
            $methods['loja5-correios-sedex-04162'] = 'Loja5_Shipping_Correios_Sedex_04162';
            $methods['loja5-correios-sedex-40886'] = 'Loja5_Shipping_Correios_Sedex_10';
			$methods['loja5-correios-sedex-40169'] = 'Loja5_Shipping_Correios_Sedex_12';
			$methods['loja5-correios-sedex-40290'] = 'Loja5_Shipping_Correios_Sedex_Hoje';
			$methods['loja5-correios-pac-04596'] = 'Loja5_Shipping_Correios_PAC_04596';
            $methods['loja5-correios-sedex-04553'] = 'Loja5_Shipping_Correios_Sedex_04553';
			$methods['loja5-correios-pac-03085'] = 'Loja5_Shipping_Correios_PAC_03085';
            $methods['loja5-correios-sedex-03050'] = 'Loja5_Shipping_Correios_Sedex_03050';
			$methods['loja5-correios-sedex-03140'] = 'Loja5_Shipping_Correios_Sedex_03140';
            $methods['loja5-correios-sedex-03158'] = 'Loja5_Shipping_Correios_Sedex_03158';
			$methods['loja5-correios-sedex-03204'] = 'Loja5_Shipping_Correios_Sedex_03204';
            $methods['loja5-correios-pac-03298'] = 'Loja5_Shipping_Correios_PAC_03298';
			$methods['loja5-correios-pac-04227'] = 'Loja5_Shipping_Correios_PAC_04227';
            $methods['loja5-correios-sedex-03220'] = 'Loja5_Shipping_Correios_Sedex_03220';
        }
		return $methods;
	}
}

add_action( 'plugins_loaded', array( 'WC_Loja5_Correios', 'get_instance' ) );
register_activation_hook( __FILE__, 'install_woo_loja5_correios' );
register_deactivation_hook( __FILE__, 'uninstall_woo_loja5_correios' );

}
?>