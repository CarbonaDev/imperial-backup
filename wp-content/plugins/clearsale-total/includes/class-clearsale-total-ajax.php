<?php

/**
 * Register all actions for the ajax page
 */

/**
 * Register all actions for the ajax page, to add order in ClearSale via PagSeguro.
 *
 * Se o pedido já foi inserido pelo checkout, que é o fim para o woocommerce e vamos tentar inserir por aqui
 * também, vai dar erro na ClearSale, como abaixo
 * erro #400 msg={"Message":"The request is invalid.","ModelState":{"existing-orders":["171"]}}
 * No caso o teste foi com o pedido # 171
 *
 *
 * @package    Clearsale_Total
 * @subpackage Clearsale_Total/includes
 * @author     Letti Tecnologia <contato@letti.com.br>
 * @link       https://letti.com.br/wordpress
 */
class Clearsale_Total_Ajax {

    /**
	 * The ID of this plugin.
	 *
	 * @since    "1.0.0"
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
    private $version;
    
 	/**
	 * The mode of work with ClearSale.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $modo    The mode save in admin. 0=produção  1=teste
	 */
    private $modo;


    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    "1.0.0"
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

        global $wpdb;

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->wp_cs_options = get_option($this->plugin_name); //get mysql data
        $this->modo = $this->wp_cs_options['modo'];
	}

	/**
	*  Metodo que Adiciona um script para o WordPress.
	* @since    "1.0.0"
	*/
	public function clearsale_total_secure_enqueue_script()
	{
		wp_register_script( 'secure-ajax-access', esc_url( add_query_arg( array( 'js_global' => 1 ), site_url() ) ) );
		wp_enqueue_script( 'secure-ajax-access' );
	}

	/**
	* Metodo que coloca o nonce e a url para as requisições para dentro do java script.
	*
	* @since    "1.0.0"
	*/
	public function clearsale_total_javascript_variaveis()
	{
		if ( !isset( $_GET[ 'js_global' ] ) ) return;

		$nonce = wp_create_nonce('clearsale_total_ajax_nonce');

		$variaveis_javascript = array(
			'clearsale_total_ajax_nonce' => $nonce, //Esta função cria um nonce para nossa requisição.
			'xhr_url'              => admin_url('admin-ajax.php') // Forma para pegar a url.
		);

		$new_array = array();
		foreach($variaveis_javascript as $var => $value) $new_array[] = esc_js( $var ) . " : '" . esc_js( $value ) . "'";

		header("Content-type: application/x-javascript");
		printf('var %s = {%s};', 'js_global', implode( ',', $new_array ) );
		exit;
	} // end of javascript_variaveis


	//add_action('wp_ajax_nopriv_clearsale_push', 'clearsale_push');
	//add_action('wp_ajax_clearsale_push', 'clearsale_push');

	/**
	 * Metodo acionado pelo ajax.
	 * @since    "1.0.0"
	 * As variáveis foram pegas do javascript na pag de fechamento do Pagseguro v 2.0.0
     * fonte  - template/direct-payment.php
	 */
	public function clearsale_total_push()
	{
		global $woocommerce, $wpdb;

		if( ! wp_verify_nonce( $_POST['clearsale_total_ajax_nonce'], 'clearsale_total_ajax_nonce' ) ) {
			echo '401'; // é o nosso nonce enviado? senão a requisição vai retornar 401
			die();
		}
/*
		var dados_pagseg = {
			metodo: metodo,    -> ver clearsale-total-public-txt.php
			order: order_id,
			card: card,
			card_holder: card_holder,
			cpf: cpf,
			validate: validate,
			doc_boleto: document_boleto,
			doc_debito: document_debit
		};
clearsale_push=Array#012(#012    [order] => 116#012    [card] => 4012 0010 3844 3335#012    [card_holder] => joana da silva#012
  [cpf] => 050.562.788-40#012    [validate] => 06/2020#012    [holder_dob] => 20/02/1969#012)
*/
		$wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

		$pagseguro = $_POST['pagseguro'];
		$metodo = $pagseguro['metodo'];
		// se metodo != 1 no lugar de pedido teremos nonce o woocommerce-process-checkout-nonce
		// se fizer dois pedidos seguidos o nonce vai ser igual!!!?????
		// gravar dados em cs_total_dadosextras

		$pedido = $pagseguro['order'];
		// Cuidado, o # do cartão está completo aqui, mais abaixo vai ser salvo no postmeta e não pode!!
		$card = str_replace(" ", "", $pagseguro['card']);
		$card_holder = $pagseguro['card_holder'];
		$cpf = $pagseguro['cpf'];
		$validate = $pagseguro['validate'];
		$installments = "";
		if (isset($pagseguro['card_installments'])) $installments = $pagseguro['card_installments'];
		$doc_boleto = $pagseguro['doc_boleto']; // só existe se for boleto
		$doc_debito = $pagseguro['doc_debito']; // só existe se for debito

//[01-Sep-2018 18:26:31 UTC] clearsale:pedido=122 cartao=4012 0010 3714 1112 nome=alfredo letti cpf=050.562.788-40 validade=10/2020 dob=20/06/1980
//$wl->write_log("ajax: pedido=".$pedido." cartao=".$card." nome=".$card_holder." cpf=".$cpf." validade=".$validate." dob=".$holder_dob);
		if (strlen($pedido)<=0) { echo 200; exit; }

		// montar array com dados do cartao para ClearSale
		// se for boleto nao temos dados do cartao
		if ($doc_boleto) {
			$cartao = array(
				'modo'			=>  'boleto',
				'numero'		=>	'',
				'bin'			=>	'',
				'end'			=>	'',
				'validity'		=>	'',
				'installments'	=>	'',
				'owner'			=>	'',
				'document'		=>	$doc_boleto
			);
		} 
		if ($doc_debito) { // é cartão
			$cartao = array(
				'modo'			=>  'debito',
				'numero'		=>	'',
				'bin'			=>	'',
				'end'			=>	'',
				'validity'		=>	'',
				'installments'	=>	'',
				'owner'			=>	'',
				'document'		=>	$doc_debito
			);
		}
		if ($card) { // é cartão
			$tt = strlen($card) - 10;
			$card1 = substr($card, 0, 6) . substr("11111111111", 0, $tt) . substr($card, -4);
			$cartao = array(
				'modo'			=>  'credito',
				'numero'		=>	$card1,
				'bin'			=>	substr($card, 0, 6),
				'end'			=>	substr($card, -4),
				'validity'		=>	$validate,
				'installments'	=>	$installments,
				'owner'			=>	$card_holder,
				'document'		=>	$cpf
			);
		}
		if (count($cartao)<1) { // nenhuma das anteriores
			$cartao = array(
				'modo'			=>  '',
				'numero'		=>	'',
				'bin'			=>	'',
				'end'			=>	'',
				'validity'		=>	'',
				'installments'	=>	'',
				'owner'			=>	'',
				'document'		=>	''
			);
		}

/*		$woo_sess =$woocommerce->session;
        //Neste ponto o cliente já fez o pedido e nao tem mais nada no carrinho, o woo->sess->cart está vazio
        $sess_id = (string)time(); //nunca deveria ser este
        if (isset($woo_sess)) {
            $tmp=$woo_sess->cart; $tmp1 = "";
            if (is_array($tmp)) {
                $tmp1=array_pop($tmp);
                if ($tmp1) $tmp1 = $tmp1['key'];
                if ($tmp1) $sess_id = $tmp1;
            }
        }
*/
		// neste ponto salvamos os dados de cartão para qdo mudar status do pedido saber que foi com cartão
		// Pagseguro (metodo=1) salva no postmeta, pois temos # do pedido, os outros na tabela cs_total_dadosextras.
		if ($metodo == 1) {
			update_post_meta($pedido, 'cs_cartao', $cartao);
			$wl->write_log("Clearsale_Total_Ajax: clearsale_total_push: Pedido " . $pedido . ", pago com " .$cartao['modo'] . " dados salvo para posterior inserção na ClearSale");
		} else {
			//nao usado ainda, nao conseguimos no fechamento relacionar o carrinho que está virando pedido com o pedido
			//nonce não é possível, post_id tb não!
        	$date = date('Y-m-d H:i:s');
        	//$wpdb->insert($wpdb->prefix.'cs_total_dadosextras', array('dados' => serialize($cartao), 'capturado_data' => $date));
			//$wl->write_log("Clearsale_Total_Ajax: clearsale_total_push: Metodo=" . $metodo . " Nonce " . $pedido . ", BIN " .$cartao['numero'] . " dados salvo na tabela cs_total_dadosextras para posterior inserção na ClearSale");
		}
		echo 200;
		exit;


		
		// Não salvamos mais o pedido aqui, quando ele for pago inserimos na ClearSale
		$order = wc_get_order($pedido); // pegar objeto do pedido
		$order_data = $order->get_data(); // melhor desta forma, em array

		$cs_doc = $order->get_meta('cs_doc');	// pega custom field - # documento digitado no checkout, CPF ou CNPJ
		$sess_id = $order->get_meta('cs_sess_id');

        $customer = $woocommerce->customer;
        $email = $customer->get_email();
        $itemShip = $order->get_shipping_methods();
        $courrier = array();
        foreach($itemShip as $shipping_item ) {
            $method_id = $shipping_item->get_method_id();
            $total = $shipping_item->get_total();
            $courrier[] = $method_id . "=" . $total;
        }
        //correios-pac=21.47
        //correios-pac=19.77
        //correios-sedex=21.47
        //local_pickup=0.00

		$items = $order->get_items();   // colecao de itens

		$cs_api = new Clearsale_Total_Api($this->plugin_name, $this->version);
		$pedido_json = $cs_api->Monta_pedido($sess_id, $cs_doc, $email, $order, $order_data, $courrier, $items, $cartao);
		
        $ret = $cs_api->Inclui_pedido($pedido_json);
        if (false === $ret) {
            $wl->write_log("Clearsale_Total_Ajax: clearsale_total_push: Erro no retorno de Inclui_pedido");
            return false;
        }
        //$ret = ('requestID'=>$requestID, 'code'=>$code, 'status'=>$status, 'score'=>$score)
        $requestID = $ret['requestID'];
        $pedido = $ret['code'];
		$status = $ret['status'];
		$score = $ret['score'];
        $wl->write_log("Clearsale_Total_Ajax: clearsale_total_push: Pedido " . $pedido . ", pago com " .$cartao['modo'] . " inserido com sucesso, status:" . $status . " requestID:" . $requestID);

        // gravar status no pedido
		$nome_status = Clearsale_Total_Status::Status_nome( $status ); // Cs_status é chamado pelo hook status.php, fora do contexto
		$note = __("ClearSale status: ", "clearsale");
		$note .= $status . " score: " . $score . "</br>Desc: " . $nome_status . "</br>requestID:" . $requestID;

		// Add the note
		$order->add_order_note( $note );

		// Save the data
		$order->save();
	
		// Vamos gravar o Account, foi tirado o hook do Woo de quando inclui/altera customer gravar na CS pois faltava o CPF
		// ***  Tirado, pois como não faz as outras operações não implementaremos o Profiler
        // *** email de 31/5/19 Joelson pede para tirar
        //$acc = new Clearsale_Total_Account($this->plugin_name, $this->version);
		//$acc->Account_get_into($pedido_json, $sess_id );// retorna true se tudo ok


		echo 200;
		exit;

	} // end of clearsale_total_push

} // end of class

