<?php

/**
 * Register all actions for the checkout page
 */

/**
 * Register all actions for the checkout page, to add status "Esperando aprovação do Pagamento", the order is inserted when status changed.
 *
 *
 * @package    Clearsale_Total
 * @subpackage Clearsale_Total/includes
 * @author     Letti Tecnologia <contato@letti.com.br>
 * @link       https://letti.com.br/wordpress
 * @since      "1.0.0"
 
 */
class Clearsale_Total_Checkout
{

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
	 * @since    "1.0.0"
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
    private $version;

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

        //$this->modo = $this->wp_cs_options['modo'];
	}

    /**
     * Metodo chamado pelo hook do tankyou
     * 
     * $this->loader->add_action('woocommerce_thankyou', $plugin_checkout, 'Cs_realtime_thankyou', 10, 1);
     * linha 80 do fonte woocommerce/templates/checkout/thankyou.php
     * 
     * @param   string  $order_id
     * 
     */

    public function Cs_total_payment_complete ($order_id)
    {
        $wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

        $wl->write_log("Cs_total_checkout: hook woocommerce_payment_complete: order id=" . $order_id);
    }

    public function Cs_total_before_thankyou($order_id)
    {
        $wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

        $wl->write_log("Cs_total_checkout: hook woocommerce_before_thankyou: order id=" . $order_id);
    }

    // neste ponto nao temos mais a session
    public function Cs_total_thankyou($order_id)
    {

        $wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

        $wl->write_log("Cs_total_checkout: hook woocommerce_thankyou: order id=" . $order_id);
        if ($order_id == null || strlen($order_id) <=0) return;

        $enviado = get_post_meta($order_id, 'cs_pedido_enviado', true);
        if ($enviado == "SIM"){
            $wl->write_log("Cs_total_checkout: hook woocommerce_thankyou: Pedido já enviado!");
            return;
        }
        $wl->write_log("Cs_total_checkout: hook woocommerce_thankyou: Pedido não enviado ainda!");
        $sess_id = get_post_meta($order_id, 'cs_sess_id', true); // Pegamos o sess_id do post_meta, já salvo qdo tinha session
        $order = wc_get_order($order_id);
        $nada = null;
        $order_data = $order->get_data(); // melhor desta forma
        $forma_pgto = $order_data['payment_method'];
        $cartao = array();
        $cartao = get_post_meta($order_id, 'cs_cartao', true); // vamos pegar dados do cartão salvo no ajax.
        if ($cartao == null) $cartao = array();
        $cs_doc = get_post_meta($order_id, 'cs_doc', true);
        $ret = $this->outrosMetodos($forma_pgto, $order_id, $cs_doc, $cartao, $wl, "Cs_total_thankyou");
        if ($ret < 0) {// -2, -3 ... o número se refere ao documento clearsale-total-public-txt.php
            //nao tem post_meta aqui, vamos sair e ver no proximo hook??!! não tem proximo....
            $wl->write_log("Cs_total_thankyou:(" . $enviado . ") Pedido " . $order_id . " método de cartão com post_meta, mas não chegou ainda, saindo...");
            return;
        }
        if ($ret == null) {
            //nao tem post_meta aqui, $cartão é NULO pode ser boleto...
            $wl->write_log("Cs_total_thankyou:(" . $enviado . ") Pedido " . $order_id . " não é cartão saindo...");
            return;
        }
        $this->Cs_total_checkout($order_id, $nada, $order);


        $wl->write_log("Cs_total_checkout: hook woocommerce_thankyou: order id=" . $order_id . " cartão owner=" . 
            $ret['owner'] . " bin=" . $ret['bin'] . " end=" . $ret['end']);
        //$this->Cs_total_checkout( $order_id, $nada, $order );
    } // end of Cs_total_thankyou

    /**
     * Metodo chamado pelo hook do woocommerce_checkout_order_processed
     * 
     * @param   string  $order_id
     * @param   array   $posted_data
     * @param   class   $order
     */
    public function Cs_total_checkout_order_processed($order_id, $posted_data, $order)
    {
        global $woocommerce;
        $wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

        $wl->write_log("Cs_total_checkout: hook woocommerce_checkout_order_processed: order id=" . $order_id);
        if ($order_id == null || strlen($order_id) <=0) return;

        $b_country = $s_country = "";
        if (isset($_POST['billing_country'])) $b_country = $_POST['billing_country'];
        if (isset($_POST['shipping_country'])) $s_country = $_POST['shipping_country'];
        $wl->write_log("Clearsale_Total_Checkout: checkout_order_processed: billing_country=" . $b_country . " shipping_country=" . $s_country);
        if ($b_country != "BR") { // || $s_country != "BR") {
            $wl->write_log("Clearsale_Total_Checkout: checkout_order_processed: Compras fora do Brasil não integramos na CS.");
            return;
        }
        $wl->write_log("Clearsale_Total_Checkout: checkout_order_processed: Compras no BR integramos na CS.");

        $woo_sess =$woocommerce->session;
        //Neste ponto o cliente já se logou e temos o $key da sessão do carrinho do woocommerce,
        //objetos da sessão como $woo_sess->_cookie e $woo_sess->_customer_id são objetos protegidos
        $sess_id = (string)time(); //nunca deveria ser este
        if (isset($woo_sess)) {
            $tmp=$woo_sess->cart;
            $tmp1 = "";
            if (is_array($tmp)) {
                $tmp1=array_pop($tmp);
                if ($tmp1) {
                    $tmp1 = $tmp1['key'];
                }
                if ($tmp1) {
                    $sess_id = $tmp1;
                }
            }
        }
        // salvamos em banco a session do woocomerce. no callback nao temos esta session
        update_post_meta($order_id, 'cs_sess_id', sanitize_text_field($sess_id));
        $wl->write_log("Cs_total_checkout_order_processed: session =" . $sess_id);

        /*
        $order_notes = get_private_order_notes($order_id); // pegar todas as notas deste pedido
        foreach($order_notes as $note1) {
            //$note_id = $note1['note_id'];
            //$note_date = $note1['note_date'];
            //$note_author = $note1['note_author'];
            $note_content = $note1['note_content'];
            if (stristr($note_content, "EAP: Esperando"))
            return; // já foi gravado o status EAP
        }
        */
        // Vamos colocar no pedido o status "Esperando aprovação do Pagamento"
        $note = __("ClearSale status: ", "clearsale");
        $note .= "EAP: Esperando Aprovação do Pagamento";

        // pelo email de 24/3/21 18:35 tiramos esta status, vai ficar em branco, mas vamos logar
        $wl->write_log("Cs_total_checkout: hook woocommerce_checkout_order_processed: order id=" . $order_id . " - EAP: Esperando Aprovação do Pagamento");
        // Add the note
        //$order->add_order_note($note);
        // Save the data
        //$order->save();

    } // end of Cs_total_checkout_order_processed

	/**
	* Metodo que vai receber os pedidos na finalizacao do pedido do woocommerce, independente
	* do plugin do pagseguro.
	*
    *do_action( 'woocommerce_checkout_order_processed', $order_id, $posted_data, $order );
    *
    * @param    string  $order_id
    * @param    array   $posted_data
    * @param    object  $order
	*/
    public function Cs_total_checkout($order_id, $posted_data, $order)
    {
        global $woocommerce;

        $wl = new Clearsale_Total_Log($this->plugin_name, $this->version);
        //$b_country = $s_country = "";
        $b_country = $order->get_billing_country();
        $s_country = $order->get_shipping_country();
        $wl->write_log("Clearsale_Total_Checkout: Cs_total_checkout: dados do pedido: billing_country=" . $b_country . " shipping_country=" . $s_country);
        if ($b_country != "BR") { // || $s_country != "BR") {
            $wl->write_log("Clearsale_Total_Checkout: Cs_total_checkout: Compras fora do Brasil não integramos na CS.");
            return;
        }
        $wl->write_log("Clearsale_Total_Checkout: Cs_total_checkout: Compras no BR integramos na CS.");
        $cs_doc = $order->get_meta('cs_doc'); // # documento digitado no checkout, CPF ou CNPJ
        if (!$cs_doc) { // ops, de outra forma entao...
            $tmp_data = get_post_meta($order_id, 'cs_doc', true);
            //$wl->write_log("Cs_total_checkout: Pegando # doc: Pedido #=" . $order_id . " doc=" . $cs_doc);
            $wl->write_log("Cs_total_checkout: Pegando # doc de outra forma=" . print_r($tmp_data,true));
            $cs_doc = $tmp_data;
        }

        //https://docs.woocommerce.com/document/managing-orders/
        //https://docs.woocommerce.com/wc-apidocs/class-WC_Order.html

		// $posted_data abaixo como comentario
        $wl->write_log("Cs_total_checkout: Entrou: Pedido #=" . $order_id . " doc=" . $cs_doc);
        //$wl->write_log("posted_data=" . print_r($posted_data,true)); // se vem do thankyou nao temos este array

        /* Antes pegávamos o sess_id aqui pois este método era chamado no fechamento, agora que ela é chamada qdo muda
           status não temos a session do carrinho, então o sess_id foi salvo no hook Cs_total_checkout_order_processed acima.
           Aqui antes salvava como postmeta mas não precisa já foi salvo acima.

        // salvamos em banco a session do woocomerce. no callback nao temos esta session
        update_post_meta($order_id, 'cs_sess_id', sanitize_text_field($sess_id));
        */
        $sess_id = get_post_meta($order_id, 'cs_sess_id', true); // Pegamos o sess_id do post_meta, já salvo qdo tinha session

        //https://stackoverflow.com/questions/39401393/how-to-get-woocommerce-order-details
        $order_data = $order->get_data(); // melhor desta forma
        $forma_pgto = $order_data['payment_method']; //qdo pelo modulo de PagSeguro vem = "pagseguro"
        // só que outros plugins NÃO o oficial, também vem com este nome, teremos que ver se o plugin oficial está instalado.
        // Quando implementar o jquery/ajax de outros plugins para cartão, temos que colocar aqui.
        $pagseguro_oficial = 0;
        if ( is_plugin_active( 'woocommerce-pagseguro-oficial/woocommerce-pagseguro-oficial.php' ) ) {
        	$pagseguro_oficial = 1; // está instalado o plugin do UOL
        }
        $cartao = array();
        $cartao = get_post_meta($order_id, 'cs_cartao', true); // vamos pegar dados do cartão salvo no ajax.
        if ($cartao == null) $cartao = array();
        // Na V 2.0 não salvamos mais o pedido no ajax, apenas os dados de cartão (não completo) e aqui resgatamos se tiver!
        //$wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout: cartao array=" . print_r($cartao,true));
        // se foi pagseguro está no postmeta senão esta em tabela, cs_total_dadosextras
        // temos que pegar o nonce e acessar a tabela, << deprecated!!

        //aqui verificamos os métodos e seus post metas para pegar dados de cartão!!
        //em alguns casos não tem post meta nesta hook "woocommerce_checkout_order_processed" vai aparecer no Cs_total_thankyou
        $ret = $this->outrosMetodos($forma_pgto, $order_id, $cs_doc, $cartao, $wl, "Cs_total_checkout");
        if ($ret < 0) {// -2, -3 ... o número se refere ao documento clearsale-total-public-txt.php
            //nao tem post_meta aqui, vamos sair e ver no proximo hook o thankyou
            $cont = get_post_meta($order_id, 'cs_pedido_enviado', true);
            // Ou não tem nada, ou tem um numero que incremetamos e salvamos ou tem SIM
            $temp = $cont;
            if ($cont != "SIM") {
                $temp = (int)$cont;
                $temp++;
                update_post_meta($order_id, 'cs_pedido_enviado', $temp);
            }
            $wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout:(" . $temp . ") Pedido " . $order_id .
             " método de cartão com post_meta, mas não chegou ainda, saindo...");
            return;
        } else $cartao = $ret;


        if ($forma_pgto == "pagseguro" && $pagseguro_oficial) {
            $wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout: Pedido " . $order_id . " feito pelo PagSeguro-UOL com " . $cartao['modo']);
        }

        /* Agora inserindo pedido pela mudança de status não saimos mais por aqui.
        if ($forma_pgto == "pagseguro" && $pagseguro_oficial) {
            // ver com staf!!?? em tese sair aqui e nao fazer nada, pois temos os dados já com cartão no ajax
            $wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout: Pedido " . $order_id . " feito pelo PagSeguro-UOL, vai ser salvo pelo ajax!");
            return;
        }
        */
/*
        $tmp1 = $order->get_meta("_wc_pagseguro_payment_data"); 
        $tmp2 = get_post_meta($order_id, '_wc_pagseguro_payment_data', true);
        $tmp3 = get_post_meta($order_id, '_wc_pagseguro_payment_data', false);
        $tmp4 = "";//get_metadata( 'post', $order_id );
        $wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout: tmp1=" . print_r($tmp1,true) . " tmp2=" . print_r($tmp2,true));
        $wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout: tmp3=" . print_r($tmp3,true) . " tmp2=" . print_r($tmp4,true));
*/
        //https://docs.woocommerce.com/wc-apidocs/class-WC_Customer.html
        //$customer = new WC_Customer( $order_id );  noop
        //$customer = $woocommerce->customer; 
        //$email = $customer->get_email();
        //Agora estamos sendo chamados na mudança de status do pedido e não achou customer no objeto woocommerce
        $a = get_userdata($order->get_user_id()); //$order_customer_id = $order_data['customer_id'];
        $email = $a->user_email;
        // $email pode ser vazio, se a compra for por visitante, vamos ter apenas no billing um email
        if (strlen($email)< 3) {
            $email = $order_data['billing']['email']; //ver dentro de Clearsale_Total_Api::Monta_pedido
            $wl->write_log("Cs_total_checkout: Pedido sem customer, é visitante, pegar e-mail de billing=" . $email);
        }

        $itemShip = $order->get_shipping_methods();
        $courrier = array();
        foreach($itemShip as $shipping_item) {
            $method_id = $shipping_item->get_method_id();
            $total = $shipping_item->get_total();
            $courrier[] = $method_id . "=" . $total;
        }
        //correios-pac=21.47
        //correios-pac=19.77
        //correios-sedex=21.47
        //local_pickup=0.00
        //$wl->write_log(" courrier=" . print_r($shipping_item,true));

        $items = $order->get_items();   // colecao de itens

        $cs_api = new Clearsale_Total_Api($this->plugin_name, $this->version);

        $pedido_json = $cs_api->Monta_pedido($sess_id, $cs_doc, $email, $order, $order_data, $courrier, $items, $cartao);

        $ret = $cs_api->Inclui_pedido($pedido_json);
        if (false === $ret) {
            // neste ponto não alteramos o status ClearSale do pedido, vai ficar com "Aguardando Pgto".
            $wl->write_log("Cs_total_checkout: Erro no retorno de Inclui_pedido");
            return false;
        }
        //$ret = ('requestID'=>$requestID, 'code'=>$code, 'status'=>$status, 'score'=>$score)
        $requestID = $ret['requestID'];
        $pedido = $ret['code'];
        $status = $ret['status'];
        $score = $ret['score'];
        // se chegou até aqui é por depósito ou outro método
        $wl->write_log("Clearsale_Total_Checkout:Cs_total_checkout: Pedido " . $pedido . " inserido com sucesso, status:" . $status . " requestID:" . $requestID);

        // gravar status no pedido
		$nome_status = Clearsale_Total_Status::Status_nome($status); // Cs_status é chamado pelo hook status.php, fora do contexto
		$note = __("ClearSale status: ", "clearsale");
		$note .= $status . " score: " . $score . "</br>Desc: " . $nome_status . "</br>requestID:" . $requestID;

		// Add the note
		$order->add_order_note($note);

		// Save the data
		$order->save();

        update_post_meta($order_id, 'cs_pedido_enviado', "SIM");

        // Vamos gravar o Account, foi tirado o hook do Woo de quando inclui/altera customer gravar na CS pois faltava o CPF
        // ***  Tirado, pois como não faz as outras operações não implementaremos o Profiler
        // *** email de 31/5/19 Joelson pede para tirar
        //$acc = new Clearsale_Total_Account($this->plugin_name, $this->version);
        //$acc->Account_get_into($pedido_json, $sess_id ); // retorna true se tudo ok

    } // end of Cs_total_checkout
/*
 Array   posted_data
(
    [terms] => 0
    [createaccount] => 0
    [payment_method] => pagseguro
    [shipping_method] => Array
        (
            [0] => local_pickup:3
        )

    [ship_to_different_address] =>
    [woocommerce_checkout_update_totals] =>
    [billing_first_name] => alfredo
    [billing_last_name] => letti
    [billing_company] =>
    [billing_country] => BR
    [billing_address_1] => Rua calixto da Mota, 75
    [billing_address_2] => casa
    [billing_city] => São Paulo
    [billing_state] => SP
    [billing_postcode] => 04117-100
    [billing_phone] => 1135893244
    [billing_email] => alfredo@letti.com.br
    [order_comments] =>
    [shipping_first_name] => alfredo
    [shipping_last_name] => letti
    [shipping_company] =>
    [shipping_country] => BR
    [shipping_address_1] => Rua calixto da Mota, 75
    [shipping_address_2] => casa
    [shipping_city] => São Paulo
    [shipping_state] => SP
    [shipping_postcode] => 04117-100
)
            order_data
       //$order_id = $order_data['id'];  //já temos ele, # do pedido
        $order_parent_id = $order_data['parent_id'];
        $order_status = $order_data['status'];
        $order_currency = $order_data['currency'];
        $order_version = $order_data['version'];
        $order_payment_method = $order_data['payment_method'];
        $order_payment_method_title = $order_data['payment_method_title'];
        $order_customer_ip = $order_data['customer_ip_address'];
        
        // Creation and modified WC_DateTime Object date string
        
        // Using a formated date ( with php date() function as method)
        $order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
        $order_date_modified = $order_data['date_modified']->date('Y-m-d H:i:s');

        // Using a timestamp ( with php getTimestamp() function as method)
        $order_timestamp_created = $order_data['date_created']->getTimestamp();
        $order_timestamp_modified = $order_data['date_modified']->getTimestamp();
        
        
        $order_discount_total = $order_data['discount_total'];
        $order_discount_tax = $order_data['discount_tax'];
        $order_shipping_total = $order_data['shipping_total'];
        $order_shipping_tax = $order_data['shipping_tax'];
        $order_total = $order_data['total'];
        $order_total_tax = $order_data['total_tax'];
        $order_customer_id = $order_data['customer_id']; // ... and so on
        
        // BILLING INFORMATION:
        
        $order_billing_first_name = $order_data['billing']['first_name'];
        $order_billing_last_name = $order_data['billing']['last_name'];
        $order_billing_company = $order_data['billing']['company'];
        $order_billing_address_1 = $order_data['billing']['address_1'];
        $order_billing_address_2 = $order_data['billing']['address_2'];
        $order_billing_city = $order_data['billing']['city'];
        $order_billing_state = $order_data['billing']['state'];
        $order_billing_postcode = $order_data['billing']['postcode'];
        $order_billing_country = $order_data['billing']['country'];
        $order_billing_email = $order_data['billing']['email'];
        $order_billing_phone = $order_data['billing']['phone'];
        
        // SHIPPING INFORMATION:
        
        $order_shipping_first_name = $order_data['shipping']['first_name'];
        $order_shipping_last_name = $order_data['shipping']['last_name'];
        $order_shipping_company = $order_data['shipping']['company'];
        $order_shipping_address_1 = $order_data['shipping']['address_1'];
        $order_shipping_address_2 = $order_data['shipping']['address_2'];
        $order_shipping_city = $order_data['shipping']['city'];
        $order_shipping_state = $order_data['shipping']['state'];
        $order_shipping_postcode = $order_data['shipping']['postcode'];
        $order_shipping_country = $order_data['shipping']['country'];

*/

	/**
	* Metodo que vai identificar um plugin que grave post_meta com os dados de cartão, só o pagseguro fecha pedido e
    * monta tela pedindo dados do cartão então temos o # do pedido para relacionar, os outros (ipag Rede) pedem ao fechar
    * então no ajax nao consigo saber qual pedido são os dados.
	* O PagSeguro da pagseguro não é visto aqui
    *
    * @param    string  $forma_pgto
    * @param    string  $order_id
    * @param    string  $cs_doc
    * @param    array   $cartao
    * @param    object  $wl
    * @param    string  $onde   - quem chamou
	*/
    public function outrosMetodos($forma_pgto, $order_id, $cs_doc, $cartao, $wl, $onde)
    {
        //$wl->write_log("Clearsale_Total_Checkout:outrosMetodos: teste cartao=" . print_r($cartao,true));
        $wl->write_log("Clearsale_Total_Checkout:outrosMetodos:" . $onde . " verificando post_meta de métodos...");

        if (count($cartao) <= 1) {
            if ($forma_pgto == "rede_credit") { //3 = rede por MarcosAlexandre  2.1.1 (ver clearsale-total-public-txt.php)
                $c_bin = get_post_meta($order_id, '_wc_rede_transaction_bin', true); // 4 primeiros digitos
                if ($c_bin == null) {
                    $wl->write_log("Clearsale_Total_Checkout:outrosMetodos: Pedido " . $order_id .
                    " feito pelo Rede por MarcosAlexandre, sem post_meta... ");
                    return(-3);
                }
                $c_exp = get_post_meta($order_id, '_wc_rede_transaction_expiration', true); // 01/2028
                $c_name = get_post_meta($order_id, '_wc_rede_transaction_holder', true);
                $c_instal = (int)get_post_meta($order_id, '_wc_rede_transaction_installments', true); // 1 ou 2 ...
                $c_last4 = get_post_meta($order_id, '_wc_rede_transaction_last4', true);
                $star = "000000"; //"******";
                $wl->write_log("Clearsale_Total_Checkout:outrosMetodos: Pedido " . $order_id . " feito pelo MarcosAlexandre com "
                . $c_bin . "******" . $c_last4 . " nome:" . $c_name);
                $cartao = array(
                    'modo'			=>  'credito',
                    'numero'		=>	$c_bin . $star . $c_last4,
                    'bin'			=>	$c_bin,
                    'end'			=>	$c_last4,
                    'validity'		=>	$c_exp,
                    'installments'	=>	$c_instal,
                    'owner'			=>	$c_name,
                    'document'		=>	$cs_doc
                );
            } // end of rede_credit

            if ($forma_pgto == "ipag-gateway") { // 2 = ipag por Ipag V 2.1.4
                /*  _card_bin
                    _card_cpf
                    _card_end    4 ultimos digitos
                    _card_exp_month   01
                    _card_exp_year    28
                    _card_name
                    _card_type   = 2 e digitei um mastercard
                    _installment_number    = 1x - Total: R$ 23.00
                    _payment_method   = ipag-gateway
                    _payment_method_title    =  iPag - Cartão de crédito
                */
                $c_bin = get_post_meta($order_id, '_card_bin', true); //    4 primeiros digitos
                if ($c_bin == null) {
                    $wl->write_log("Clearsale_Total_Checkout:outrosMetodos: Pedido " . $order_id .
                    " feito pelo Ipag por Ipag, sem post_meta... ");
                    return(-2);
                }
                $c_expm = get_post_meta($order_id, '_card_exp_month', true); // 01
                $c_expy = get_post_meta($order_id, '_card_exp_year', true);  // 28
                if (strlen($c_expy)<4) $c_expy = "20" . $c_expy; // em 80 anos temos um erro!!
                $c_exp = $c_expm . "/" . $c_expy;
                $c_name = get_post_meta($order_id, '_card_name', true);
                $c_instal = (int) substr(get_post_meta($order_id, '_installment_number', true),0,1);
                $c_last4 = get_post_meta($order_id, '_card_end', true);
                $star = "000000"; //"******";
                $wl->write_log("Clearsale_Total_Checkout:outrosMetodos: Pedido " . $order_id . " feito pelo Ipag por Ipag com "
                . $c_bin . "******" . $c_last4 . " nome:" . $c_name);
                $cartao = array(
                    'modo'			=>  'credito',
                    'numero'		=>	$c_bin . $star . $c_last4,
                    'bin'			=>	$c_bin,
                    'end'			=>	$c_last4,
                    'validity'		=>	$c_exp,
                    'installments'	=>	$c_instal,
                    'owner'			=>	$c_name,
                    'document'		=>	$cs_doc
                );

            } // end of ipag



        } // end of $cartao vazio
        return($cartao);
    } // end of outrosMetodos


    //Cs_finalizar_checkout
	/**
	* Metodo que vai ser chamado quando clicado no botão finalizar. Vamos colocar um pequeno javascript,
	* na verdade um declaração de variável para testar na rotina de FingerPrint a existência.
    *
	*/
    public function Cs_finalizar_checkout()
    {
        //echo "<script type='text/javascript'> var tonocheckout=1;  </script>";
        echo "<script type='text/javascript'>tonocheckout=1;  </script>";

    } // end of Cs_finalizar_checkout

} // end of class
