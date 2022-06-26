<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Loja5_Shipping_Braspress_Legacy extends WC_Shipping_Method {

	private $request;
	private $boxes;
	private $units;
	private $method_errors;

	function __construct() {
		global $woocommerce;
		$this->id = 'braspress-api-loja5';
		$this->method_title = 'Transportadora Braspress [Loja5]';
        $this->init_settings();
		$this->init_form_fields();
        
        // Method variables.
        $this->enabled            = $this->get_option( 'enabled' );
		$this->availability       = 'specific';
		$this->countries          = array( 'BR' );
        
		add_action('woocommerce_update_options_shipping_'.$this->id,array($this,'process_admin_options'));
	}

	public function init_form_fields() {
		//especifico por versao
		if(version_compare(PHP_VERSION, '5.5.0', '<')) {
			include_once(LOJA5_WOO_BRASPRESS_DIR.'/include/php54/loja5.php' );
			include(LOJA5_WOO_BRASPRESS_DIR.'/include/php54/config.php' );
		}elseif(version_compare(PHP_VERSION, '5.6.0', '<')){
			include_once(LOJA5_WOO_BRASPRESS_DIR.'/include/php55/loja5.php' );
			include(LOJA5_WOO_BRASPRESS_DIR.'/include/php55/config.php' );
		}elseif(version_compare(PHP_VERSION, '7.1.0', '<')){
			include_once(LOJA5_WOO_BRASPRESS_DIR.'/include/php56/loja5.php' );
			include(LOJA5_WOO_BRASPRESS_DIR.'/include/php56/config.php' );
		}elseif(version_compare(PHP_VERSION, '7.2.0', '<')){
			include_once(LOJA5_WOO_BRASPRESS_DIR.'/include/php71/loja5.php' );
			include(LOJA5_WOO_BRASPRESS_DIR.'/include/php71/config.php' );
		}else{
			include_once(LOJA5_WOO_BRASPRESS_DIR.'/include/php72/loja5.php' );
			include(LOJA5_WOO_BRASPRESS_DIR.'/include/php72/config.php' );
		}
		$this->form_fields = $form;
	}

	public function admin_options() {
		global $woocommerce;
		?>
		<h3><?php echo $this->method_title;?></h3>
		<p><?php echo $this->method_description;?></p>
		<table class="form-table">
			<?php
			$this->generate_settings_html();
			?>
		</table>
		<?php
	}
}

abstract class Loja5_Shipping_Braspress extends WC_Shipping_Method {

	protected $code = '';
    protected $log = null;
    public $serial = '';

	public function __construct( $instance_id = 0 ) {
		$this->instance_id        = absint( $instance_id );
		$this->method_description = sprintf( __( '%s é um metodo transportadora Braspress', 'loja5-woo-braspress' ), $this->method_title );
		$this->supports           = array(
			'shipping-zones',
			'instance-settings',
		);

		$this->init_settings();
		$this->init_form_fields();

		$this->shipping_class_id  = (int) $this->get_option( 'shipping_class_id', '-1' );
        $this->title              = $this->get_option( 'title' );
        $this->pagar              = $this->get_option( 'pagar' );
		$this->peso_minimo        = $this->get_option( 'peso_minimo' );
		$this->prazo              = $this->get_option( 'prazo' );
		$this->tipo_taxa          = $this->get_option( 'tipo_taxa' );
        $this->taxa               = $this->get_option( 'taxa' );
        $this->debug              = $this->get_option( 'debug' );
        
        $this->log = new WC_Logger();

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}

	protected function get_log_link() {
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.2', '>=' ) ) {
			return ' <a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs&log_file=' . esc_attr( $this->id ) . '-' . sanitize_file_name( wp_hash( $this->id ) ) . '.log' ) ) . '">' . __( 'Ver logs.', 'loja5-woo-braspress' ) . '</a>';
		}
	}
    
	public function init_form_fields() {
        $this->instance_form_fields = array(
			'imagem' => array(
				'title' => "",
				'type' 			=> 'hidden',
				'description' => "<img src='".plugins_url()."/loja5-woo-braspress/banner.png'>",
				'default' => ''
			),
		    'title' => array(
				'title'       => __( 'Titulo', 'loja5-woo-braspress' ),
				'type'        => 'text',
				'description' => __( 'Nome a exibir do meio de entrega.', 'loja5-woo-braspress' ),
				'default'     => $this->method_title,
			),
			'behavior_options' => array(
				'title'   => __( 'Configura&ccedil;&otilde;es '.$this->method_title.'', 'loja5-woo-braspress' ),
				'type'    => 'title',
				'default' => '',
			),
		    'prazo' => array(
				'title' => "Prazo Extra",
				'type' => 'text',
				'description' => "Prazo extra em dias a somar no prazo real.",
				'default' => '1'
		    ),
			'tipo_taxa'  => array(
				'title'           => "Tipo de Taxa",
				'type'            => 'select',
				'default'         => 'R',
				'options'         => array(
					'R' => 'Valor Fixo (R$)',
					'P' => 'Valor Variavel (%)'
				),
				'description' => __( 'Tipo de taxa extra caso venha a cobrar.', 'loja5-woo-braspress' ),
			),
			'taxa' => array(
				'title' => "Taxa Extra",
				'type' => 'text',
				'description' => "Valor (0.00) em R$ ou % (selecione acima o tipo) de uma Taxa extra caso queira cobrar.",
				'default' => '0.00'
		    ),
            'peso_minimo' => array(
				'title'       => __( 'Peso Minimo KG', 'loja5-woo-braspress' ),
				'type'        => 'text',
				'description' => __( 'Peso minimo de um pedido para uso do modulo.', 'loja5-woo-braspress' ),
				'placeholder' => '0.00',
				'default'     => '0.00',
			),
			'shipping_class_id' => array(
				'title'       => __( 'Classe de Entrega', 'loja5-woo-braspress' ),
				'type'        => 'select',
				'description' => __( 'Caso precise usar classes de entrega.', 'loja5-woo-braspress' ),
				'default'     => '',
				'class'       => 'wc-enhanced-select',
				'options'     => $this->get_shipping_classes_options(),
			),
            'testing' => array(
				'title'   => __( 'Debug', 'loja5-woo-braspress' ),
				'type'    => 'title',
				'default' => '',
			),
			'debug' => array(
				'title'       => __( 'Log', 'loja5-woo-braspress' ),
				'type'        => 'checkbox',
				'label'       => __( 'Ativar log', 'loja5-woo-braspress' ),
				'default'     => 'no',
				'description' => sprintf( __( 'Logs e eventos de %s.', 'loja5-woo-braspress' ), $this->method_title ) . $this->get_log_link(),
			),
		);
	}
	
	protected function get_shipping_classes_options() {
		$shipping_classes = WC()->shipping->get_shipping_classes();
		$options          = array(
			'-1' => __( 'Qualquer Classe', 'loja5-woo-braspress' ),
			'0'  => __( 'Nenhuma', 'loja5-woo-braspress' ),
		);
		if ( ! empty( $shipping_classes ) ) {
			$options += wp_list_pluck( $shipping_classes, 'name', 'term_id' );
		}
		return $options;
	}
	
	protected function has_only_selected_shipping_class( $package ) {
		$only_selected = true;
		if ( -1 === $this->shipping_class_id ) {
			return $only_selected;
		}
		foreach ( $package['contents'] as $item_id => $values ) {
			$product = $values['data'];
			$qty     = $values['quantity'];

			if ( $qty > 0 && $product->needs_shipping() ) {
				if ( $this->shipping_class_id !== $product->get_shipping_class_id() ) {
					$only_selected = false;
					break;
				}
			}
		}
		return $only_selected;
	}

	public function admin_options() 
    {
		global $woocommerce;
		?>
		<h3><?php echo $this->method_title;?></h3>
		<p><?php echo $this->method_description;?></p>
		<table class="form-table">
			<?php
			echo $this->get_admin_options_html();
			?>
		</table>
		<?php
	}
    
    public function is_available( $package ) {
		return true;
	}

	protected function get_cart_total() {
		if ( ! WC()->cart->prices_include_tax ) {
			return WC()->cart->cart_contents_total;
		}
		return WC()->cart->cart_contents_total + WC()->cart->tax_total;
	}
    
    private function calcular_pesos($package) {
        $config = new Loja5_Shipping_Braspress_Legacy();
		$peso_real = $volume = 0;
    	foreach ( $package['contents'] as $item_id => $values ) {
    		if( !$values['data']->needs_shipping() ){
    			continue;
    		}
            $volume++;
			if($config->settings['peso_tipo']=='k'){
				$peso_real += $values['data']->get_weight()*$values['quantity'];
			}else{
				$peso_real += ($values['data']->get_weight()/1000)*$values['quantity'];
			}
    	}
        return array('real'=>round($peso_real, 2),'volume'=>$volume);
    }

	public function calculate_shipping( $package = array() ) {
		$config = new Loja5_Shipping_Braspress_Legacy();
		
        if ( 'yes' !== $this->enabled ) {
            return;
        }
        
        if ( '' === $package['destination']['postcode'] || 'BR' !== $package['destination']['country'] ) {
			return;
		}
		
		if ( ! $this->has_only_selected_shipping_class( $package ) ) {
			return;
		}

        //pega o peso para uso e volumes
		$pesos  = $this->calcular_pesos($package);
        $peso   = $pesos['real'];
		$volume = $pesos['volume'];
		if($peso == 0){
			$peso = 0.1;
		}
        
        //regra peso minimo
        if($peso < $this->peso_minimo){
            return;
        }
        
        //calcula 
        $calculo = $this->calcular_frete($package,$peso,$volume);
        if(isset($calculo['totalFrete']) && $calculo['totalFrete'] > 0){
            $calculo_total = (float)$calculo['totalFrete'];
			$calculo_total = number_format($calculo_total, 2, '.', '');
            if(isset($calculo['prazo'])){
				$dias_prazo = ((int)$this->prazo+$calculo['prazo']);
                $prazo = 'em at&eacute; '.$dias_prazo.' dia(s)';
            }else{
				$dias_prazo = 15;
				$prazo = '';
			}				
            if($calculo_total > 0){
				if($this->tipo_taxa=='R'){
					$calculo_total += (float)$this->taxa;
				}else{
					$porcentagem = (float)$this->taxa;
					if($porcentagem > 0){
						$calculo_total += ($calculo['totalFrete']/100)*$porcentagem;
					}
				}
				if($config->settings['exibir_prazo']=='titulo'){
					$this->add_rate(array(
						'code'	=> 'braspress-api-loja5',
						'id' 	=> $this->id,
						'label' => $this->title.' '.$prazo.'',
						'cost' 	=> $calculo_total
					));
				}else{
					$this->add_rate(array(
						'code'	=> 'braspress-api-loja5',
						'id' 	=> $this->id,
						'label' => $this->title,
						'meta_data' => array('prazo' => $dias_prazo),
						'cost' 	=> $calculo_total
					));
				}
            }else{
                return;
            }
        }else{
            return;
        }
	}
	
	public function calcular_frete($pack,$peso,$volumes){
	    global $woocommerce;
        
        $config = new Loja5_Shipping_Braspress_Legacy();
		
		//pega o fiscal do cliente
		$fiscal = '';
		$customer_id = get_current_user_id();
		$cnpj = get_user_meta( $customer_id, 'billing_cnpj', true );
		$cpf  = get_user_meta( $customer_id, 'billing_cpf', true );
		if($cpf && !empty($cpf)){
			$fiscal = $cpf;
		}elseif($cnpj && !empty($cnpj)){
			$fiscal = $cnpj;
		}else{
			if(isset($_REQUEST['post_data']) && !empty($_REQUEST['post_data'])){
				parse_str(trim($_REQUEST['post_data']), $output);
				if(isset($output['billing_cpf']) && !empty($output['billing_cpf'])){
					$fiscal = preg_replace('/\D/', '',$output['billing_cpf']);
				}elseif(isset($output['billing_cnpj']) && !empty($output['billing_cnpj'])){
					$fiscal = preg_replace('/\D/', '',$output['billing_cnpj']);
				}
			}
		}
		if(empty($fiscal)){
			$fiscal = '11111111111111';
		}
        
        $request = array();
		$request['cnpjRemetente'] = preg_replace('/\D/', '', $config->settings['cnpj']);
		$request['cnpjDestinatario'] = preg_replace('/\D/', '', $fiscal);
		$request['modal'] = $this->code;
		$request['tipoFrete'] = (int)$config->settings['frete_tipo'];
		$request['cepOrigem'] = preg_replace('/\D/', '', $config->settings['cep']);
		$request['cepDestino'] = preg_replace('/\D/', '', $pack['destination']['postcode']);
		$request['vlrMercadoria'] = number_format($pack['contents_cost'], 2, '.', '');
		$request['peso'] = number_format($peso, 2, '.', '');
		$volume = 0;
        foreach ( $pack['contents'] as $item_id => $values ) {
    		if( !$values['data']->needs_shipping() ){
    			continue;
    		}
			$volume += $values['quantity'];
            $alt = $values['data']->get_height()/100;
            $com = $values['data']->get_length()/100;
            $lar = $values['data']->get_width()/100;
			$request['cubagem'][] = array('largura'=>number_format($lar, 2, '.', ''),'altura'=>number_format($alt, 2, '.', ''),'comprimento'=>number_format($com, 2, '.', ''),'volumes'=>$values['quantity']);
    	}
		$request['volumes'] = (int)$volume;
		
		if($config->settings['ambiente']=='1'){
			$ambiente = 'https://hml-api.braspress.com/v1/cotacao/calcular/json';
		}else{
			$ambiente = 'https://api.braspress.com/v1/cotacao/calcular/json';
		}
		
		$headers = array(
			'Content-Type: application/json',
			'Authorization: Basic '.base64_encode(trim(html_entity_decode($config->settings['login'])).':'.trim(html_entity_decode($config->settings['senha']))).''
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$ambiente);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		$or = curl_exec($ch);
		$server_output = json_decode($or,true);
		$server_output = array_merge($server_output,array('ambiente'=>$ambiente));
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

        if ( 'yes' === $this->debug ) {
            $this->log->add( $this->id, 'Braspress '.$this->title.' envio: ' . print_r($request,true) );
			$this->log->add( $this->id, 'Braspress '.$this->title.' resposta '.$httpcode.': ' . print_r($or,true) );
        }
		
		if($httpcode==200 && isset($server_output['totalFrete'])){
			return $server_output;
		}else{
			$this->log->add( $this->id, 'Braspress '.$this->title.' erro: ' . print_r($server_output,true) );
			return false;
		}
	}
}