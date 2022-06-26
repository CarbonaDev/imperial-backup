<?php
/*
  Plugin Name: Transportadora Braspress API - Loja5
  Description: Integração a transportadora Braspress
  Version: 1.0
  Author: Loja5.com.br
  Author URI: http://www.loja5.com.br
  Copyright: © 2009-2020 Loja5.com.br.
  License: Comercial
*/

//dir do plugin 
define('LOJA5_WOO_BRASPRESS_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ));

if ( ! class_exists( ' WC_Loja5_Braspress' ) ) {
    
class WC_Loja5_Braspress {
    
    protected static $instance = null;
    
    private function __construct() {
        $this->init();
        add_filter( 'woocommerce_shipping_methods', array( $this, 'include_methods' ) );
		add_filter('woocommerce_after_shipping_rate', array($this,'prazo_de_entrega_carrinho'), 100);
		add_filter('woocommerce_order_shipping_method', array($this,'prazo_de_entrega_pedido_key'), 100, 2);
		add_action( 'woocommerce_view_order', array( $this, 'rastreamento_cliente' ), 20 );
		if(is_admin()){
			add_action('add_meta_boxes', function(){
				add_meta_box(
					'wc_loja5_braspress',
					'Rastreamento Braspress',
					array( $this, 'metabox' ),
					'shop_order',
					'side',
					'default'
				);
			});
			add_action( 'save_post', array( $this, 'salvar_nfe' ) );
		}
    }
	
	public function rastreamento_cliente($order_id) {
		$order = wc_get_order( $order_id );
		if($order){
			$config = new Loja5_Shipping_Braspress_Legacy();
			$notas = get_post_meta($order->get_id(),'_braspress_nota_fiscal',true);
			if(!empty($notas)){
				$lista_notas = explode(',',$notas);
				$links_notas = array();
				foreach($lista_notas as $nota){
					$links_notas[] = '<a href="https://blue.braspress.com/site/w/tracking/search?cnpj='.preg_replace('/\D/', '', $config->settings['cnpj']).'&documentType=NOTAFISCAL&numero='.$nota.'" target="_blank">'.$nota.'</a>';
				}
				include_once(dirname(__FILE__).'/classes/rastreamento_nfe.php');
			}
		}
	}
	
	public function metabox($post){
		if(isset($post->post_type) && $post->post_type=='shop_order'){
			$order = wc_get_order( $post->ID );
			$metodos_braspress = 0;
			foreach ( $order->get_shipping_methods() as $shipping_method ) {
				if($shipping_method->get_method_id()=='braspress-r' || $shipping_method->get_method_id()=='braspress-a'){
					$metodos_braspress++;
				}
			}
			if($metodos_braspress > 0){
				$notas = get_post_meta($order->get_id(),'_braspress_nota_fiscal',true);
				$email = (bool)get_post_meta($order->get_id(),'_braspress_email_enviado',true);
				include_once(dirname(__FILE__).'/classes/form_nfe.php');
			}
		}
	}
	
	public function conteudo_email($dados) {
		return wc_get_template_html(
			'/emails/dados-nfe.php', 
			$dados, 
			'', 
			LOJA5_WOO_BRASPRESS_DIR
		);
	}
	
	public function enviar_email($mensagem,$titulo,$cabecalho,$para,$cliente,$order){
		$mailer = WC()->mailer();
		$dados = array();
		$dados['email'] = $mailer;
		$dados['mensagem'] = $mensagem;
		$dados['order'] = $order;
		$dados['email_heading'] = $cabecalho;
		$dados['nome'] = $cliente;
		$conteudo = $this->conteudo_email($dados);
		$headers = "Content-Type: text/html\r\n";
		$mailer->send($para,$titulo,$conteudo,$headers);	
	}
	
	public function salvar_nfe($post){
		if(isset($_POST['post_type']) && isset($_POST['ID']) && isset($_POST['braspress_nota_fiscal']) && $_POST['post_type']=='shop_order'){
			//salva a nfe no meta do pedido
			update_post_meta((int)$_POST['ID'],'_braspress_nota_fiscal', trim($_POST['braspress_nota_fiscal']));
			//faz o envio do e-mail 
			$order = wc_get_order((int)$_POST['ID']);
			$notas = get_post_meta((int)$_POST['ID'],'_braspress_nota_fiscal',true);
			if($order && !empty($notas)){
				//config do braspress 
				$config = new Loja5_Shipping_Braspress_Legacy();
				//monta os links das notas
				$lista_notas = explode(',',$notas);
				$links_notas = array();
				foreach($lista_notas as $nota){
					$links_notas[] = '<a href="https://blue.braspress.com/site/w/tracking/search?cnpj='.preg_replace('/\D/', '', $config->settings['cnpj']).'&documentType=NOTAFISCAL&numero='.$nota.'" target="_blank">'.$nota.'</a>';
				}
				//dados do e-mail
				$cliente = $order->get_billing_first_name();
				$email = $order->get_billing_email();
				$titulo = '['.wp_specialchars_decode(get_option('blogname'), ENT_QUOTES).'] Seu pedido foi Enviado!';
				$mensagem = 'Seu pedido foi postado junto a transportadora Braspress, o mesmo poderá ser rastreado abaixo clicando na NFe correspondente.<br>Envios: '.implode(', ',$links_notas).'<br><br>Qualquer duvida ou informação sobre o envio poderá consultar o atendimento da loja.';
				$this->enviar_email($mensagem,$titulo,'NFe Braspress - Enviado',$email,$cliente,$order);
				//salva um meta como email enviado
				update_post_meta((int)$_POST['ID'],'_braspress_email_enviado', true);
			}
		}
	}
	
	public function init() {
		if(extension_loaded("IonCube Loader")) {
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
				include_once(dirname(__FILE__).'/classes/abstract-braspress.php');
				include_once(dirname(__FILE__).'/classes/metodos-braspress.php');
			}else{
				add_action( 'admin_notices', array( $this, 'alerta_versao' ) );
			}
		}else{
			add_action( 'admin_notices', array( $this, 'alerta_ioncube' ) );
		}
	}
	
	public function prazo_de_entrega_carrinho( $metodo ) {
		$metas = $metodo->get_meta_data();
		$label = '';
		if(isset($metas['prazo']) && !empty($metas['prazo'])){
			$label .= '<br /><small>';
			$label .= sprintf( __( 'Entrega em até %s dia(s) úteis.', 'loja5-woo-braspress' ), $metas['prazo'] );
			$label .= '</small>';
		}
		echo $label;
	}
	
	public function prazo_de_entrega_pedido_key( $display_key, $meta ) {
		if($meta->key=='prazo'){
			return __( 'Prazo (dias)', 'loja5-woo-braspress' );
		}else{
			return $display_key;
		}
	}
	
	public function prazo_de_entrega_pedido( $name, $order ) {
		$names = array();
		foreach ( $order->get_shipping_methods() as $shipping_method ) {
			$prazo = (int) $shipping_method->get_meta( 'prazo' );
			if ( $prazo ) {
				$names[] = sprintf( __( '%s (entrega em até %s dia(s) úteis)', 'loja5-woo-braspress' ), $shipping_method->get_name(), $prazo );
			} else {
				$names[] = $shipping_method->get_name();
			}
		}
		return implode( ', ', $names );
	}
    
    public function alerta_versao(){
        echo '<div class="error">';
        echo '<p><strong>Transportadora Braspress [Loja5]:</strong> Requer vers&atilde;o Woo 3.x ou superior, atualize seu Woo para vers&atilde;o compativel!</p>';
        echo '</div>';
    }
	
	public function alerta_ioncube(){
        echo '<div class="error">';
        echo '<p><strong>Transportadora Braspress [Loja5]:</strong> Sua hospedagem n&atilde;o possui o Ioncube ativado, solicite a mesma ativar ou veja com o gestor de seu host!</p>';
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
            $methods['braspress-legacy'] = 'Loja5_Shipping_Braspress_Legacy';
            $methods['braspress-r'] = 'Loja5_Shipping_Braspress_R';
            $methods['braspress-a'] = 'Loja5_Shipping_Braspress_A';
        }
		return $methods;
	}
}

add_action( 'plugins_loaded', array( 'WC_Loja5_Braspress', 'get_instance' ) );
}
?>