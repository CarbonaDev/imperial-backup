<?php
/**
 * The public class status
*/
/**
 * The public class status
 *
 * Define método para pegar pedido com mudança de status.
 * A uri dom.com.br/wp-content/plugins/clearsale-total/public/status.php é o hook que recebe alterações
 * de status de pedidos, esta, sendo acionada, chama o método abaixo de nome Cs_status.
 *
 * @package    Clearsale_Total
 * @subpackage Clearsale_Total/public
 * @author     Letti Tecnologia <contato@letti.com.br>
 * @since      "1.0.0"
 * @date       20/07/2018
 */
class Clearsale_Total_Status
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
     * Pointer of log class
     * @access	private
     * @var		class
     */
    private $wl;
    
    /**
     * Options of plugin
     * @access	private
     * @var		array
     */
    private $wp_cs_options;

    /**
     * Cancela pedido?
     * @access	private
     * @var		boolean
     */
    private $cancel_order;

    /**
     * Initialize the class and set its properties.
     *
     * @since	"1.0.0"
     * @param	string		$plugin_name       The name of the plugin.
     * @param	string		$version    The version of this plugin.
     */
    public function __construct($plugin_name="", $version="")
    {
        global $woocommerce;

        if ($plugin_name) {
            $this->plugin_name = $plugin_name;
        }
        if ($version) {
            $this->version = $version;
        }

        $this->wp_cs_options = get_option($this->plugin_name);
        $this->wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

        //$this->cancel_order = $this->wp_cs_options['cancel_order'];
        //$this->wl->write_log1("Clearsale_Total_Status:construct entrou: cancel_order=" . $this->cancel_order);
    }

    /**
     * Método para alterar o status de um pedido do woocommerce na ClearSale.
     * Agora, na versão 2.0, vamos incluir os pedidos quando o status for "PAGO"
     *
     * @since    "1.0.0"
     * @var		string		$order_id		Número do pedido
     * @var		string		$status_from	Status anterior
     * @var		string		$status_to		Status agora
     * @var		object		$inst			instância $this
     */
    public function Cs_total_atualiza_status($order_id, $status_from, $status_to, $inst)
    {
        global $woocommerce;
        $wl = new Clearsale_Total_Log($this->plugin_name, $this->version);

        //"processing, on-hold, cancelled, completed, pending, failed, refunded"
        //do pag-seguro ps-pagamento, ps-paga, ps-devolvida, ps-cancelada, ps-em-contestacao
        //status from:completed to:refunded refunded=85

        if (empty($order_id)) {
            $wl->write_log("Clearsale_Total_Status:Cs_atualiza_status: entrou mas # pedido vazio!!");
            return;
        }
        $order = new WC_Order($order_id);

        $b_country = $order->get_billing_country();
        $s_country = $order->get_shipping_country();
        $wl->write_log("Clearsale_Total_Status:Cs_atualiza_status: dados do pedido: billing_country=" . $b_country . " shipping_country=" . $s_country);
        if ($b_country != "BR") { // || $s_country != "BR") {
            $wl->write_log("Clearsale_Total_Status:Cs_atualiza_status: Compras fora do Brasil não integramos na CS.");
            return;
        }

        $refunded = $order->get_total_refunded(); // valor de devolução
        $post_id = get_post($order_id)->ID;
		$ultimoStatus = $this->getStatusOnNotes($post_id);

        $wl->write_log("Clearsale_Total_Status:Cs_atualiza_status: pedido=" . $order_id . ' status antes:' . $status_from . ' agora:' . $status_to);
		$wl->write_log("Clearsale_Total_Status:Cs_atualiza_status: post_id=" . $post_id . " último status salvo:" . $ultimoStatus);
        $cs_api = new Clearsale_Total_Api($this->plugin_name, $this->version);
        
        switch ($status_to) {

            case 'refunded':
                    // NAO é chargeback
                    //$ret = $cs_api->Chargeback( $order_id, "Chargeback valor devolvido=" . $refunded);
                    ////array('requestID'=>$requestID, 'code'=>$code, 'status'=>$status);
                    //$wl->write_log('Clearsale_Total_Status:Cs_atualiza_status: retorno: requestID=' . $ret['requestID'] . ' pedido:' . $ret['code'] . ' status=' . $ret['status']);
                break;
            
            case 'completed': // CONFIRMAR !! colocando PGA qdo foi entregue
                    // Parece que PagSeguro usa a do woocommerce, não tem um específico
                    $ret = $cs_api->Atualiza_status($order_id, 'PGA');	// PGA = Pgto Aprovado
                    //array('requestID'=>$requestID, 'status'=>$status, 'message'=>$message);
                    $wl->write_log('Clearsale_Total_Status:Cs_atualiza_status: colocando PGA retorno: requestID=' . $ret['requestID'] . ' status=' . $ret['status'] . ' msg=' . $ret['message']);
                break;

            case 'processing':
            case 'ps-paga':
                    // Aqui gravamos o pedido na Clear, vou colocar ele como PGA na entrega.
                    $cst = new Clearsale_Total_Checkout($this->plugin_name, $this->version);
                    $nada = null;
                    if (false === $cst->Cs_total_checkout($order_id, $nada, $order)) {
                        $wl->write_log("Clearsale_Total_Status:Cs_atualiza_status: Erro ao gravar pedido na ClearSale!!");
                        return;
                    }
                    // Vamos colocar o status do pedido no Woo como "Analise de Risco ClearSale"
                    if (!empty($order)) {
                        $order->update_status('wc-cs-inanalisis');
                    }
                    //$ret = $cs_api->Atualiza_status( $order_id, 'PGA');	// PGA = Pgto Aprovado
                    ////array('requestID'=>$requestID, 'status'=>$status, 'message'=>$message);
                    //$wl->write_log('Clearsale_Total_Status:Cs_atualiza_status: colocando PGA retorno: requestID=' . $ret['requestID'] . ' status=' . $ret['status'] . ' msg=' . $ret['message']);
                break;

            case 'cancelled':
            case 'ps-cancelada':
                    // quando o Woo cancela pedido ele entra aqui, seja pelo método de pgto que cancelou, ou por nós, quando temos um
                    // status da Clear de reprovação e o flag está para cancelar, ele vai entrar aqui também! Como saber qual é qual?

					// fizemos o método getStatusOnNotes para pegar o último status da ClearSale salvo em notas, se ele for da lista de reprovação
					// então este CAN VAI ser colocado em notas, outros não!
                    if ($ultimoStatus == 'FRD' || $ultimoStatus == 'RPA' || $ultimoStatus == 'RPP' || $ultimoStatus == 'RPM' || $ultimoStatus == 'SUS' || $ultimoStatus == 'CAN') {
						$ret = $cs_api->Atualiza_status($order_id, 'PGR');	// PGR = Pgto Reprovado
						$wl->write_log('Clearsale_Total_Status:Cs_atualiza_status: Colocado status ' . $ultimoStatus . ' no pedido e PGR: retorno: requestID=' . $ret['requestID'] . ' status=' . $ret['status'] . ' msg=' . $ret['message']);
						// Vamos colocar no pedido o status da ClearSale de "Cancelado" 
						$note = __("ClearSale status: ", "clearsale");
						//$note .= "CAN: Cancelado"; // antes era assim,
						// se ficar com CAN vai sumir o último status que provocou o cancelamento, então voltamos o status que gerou o cancelamento
						$note .= $ultimoStatus . ": Cancelado";
						// Add the note
						$order->add_order_note($note);
						// Save the data
						$order->save();
					} else {
                        $ret = $cs_api->Atualiza_status($order_id, 'PGR');	// PGR = Pgto Reprovado
                        $wl->write_log('Clearsale_Total_Status:Cs_atualiza_status: colocando PGR retorno: requestID=' . $ret['requestID'] . ' status=' . $ret['status'] . ' msg=' . $ret['message']);
                    }
                break;
        } // end of switch
    } // end of Cs_atualiza_status

    /**
     * Método para pegar o último status nas notas de um pedido.
     *
     * @since	"2.0.0"
     * @var		string      $post_id		post_id do pedido
     * @return	string      XXX - status da Clearsale com 3 bytes
     */
    public function getStatusOnNotes($post_id)
    {
		global $woocommerce;

		$wl = new Clearsale_Total_Log($this->plugin_name, $this->version);
		$wl->write_log("Clearsale_Total_Status:getStatusOnNotes:  entrou post_id=" . $post_id);

        $args = array(
            //'status' => 'hold',
            //'number' => '1', se for só a última ele deixa em branco se não for a da ClearSale
            'post_id' => $post_id, // use post_id, not post_ID
            'approved' => 'approve',
            'type' => ''
        );

		remove_filter('comments_clauses', array('WC_Comments', 'exclude_order_comments'));
        $comments = get_comments($args); // ele lista em ordem descendente de data, achando a 1ra da CS paramos, pois será a última.
		add_filter('comments_clauses', array( 'WC_Comments', 'exclude_order_comments'));

        foreach ($comments as $comment) {
            //echo($comment->comment_author);
            //Status da ClearSale: FRD - pegar apenas FRD  Ou assim-> ClearSale status: FRD score: 99.99
			//$wl->write_log("Clearsale_Total_Status:getStatusOnNotes:  comment=" . print_r($comment,true));
            $apt = stristr($comment->comment_content, "clearsale:");
            $status = substr($apt, 11, 3);
            if ($status) {
                return($status);
            } else { // vazio
                $apt = stristr($comment->comment_content, "status:");
                $status = substr($apt, 8, 3);
                if ($status) return($status);
            }
        }
		$wl->write_log("Clearsale_Total_Status:getStatusOnNotes:  saindo sem achar nada...");
        return('');
    } // end of getStatusOnNotes

    /**
     * Método estático para consultar status de um pedido na ClearSale.
     * Chamado pelo status.php
     *
     * @since    "1.0.0"
     * @var      string    $pedido    Número do pedido
     */
    public static function Cs_status($pedido)
    {
        require_once '../../../../wp-load.php';
        //require_once( ABSPATH . 'wp-load.php' );

        $wl = new Clearsale_Total_Log("clearsale-total", "2.5.1");
        $wl->write_log("Clearsale_Total_Status:Cs_status: hook da CS de status para pedido=" . $pedido);

        if (strlen($pedido) <= 0 || $pedido == "") {
            return;
        }

        $order = wc_get_order($pedido);
        if (!$order) {
            $wl->write_log("Clearsale_Total_Status:Cs_status: Pedido " . $pedido . " não encontrado!!!");
            return;
        }
        $order_data = $order->get_data();

        $metodo = $order_data['payment_method'];
        $wl->write_log("Clearsale_Total_Status:Cs_status: método do pedido acima:" . $metodo);

        $cs_api = new Clearsale_Total_Api("clearsale-total", "2.4.3");
        // Para teste unitário de status, comentar a linha abaixo e descomentar a outra.
        $ret = $cs_api->Consulta_status($pedido); //array('requestID'=>$requestID, 'code'=>$code, 'status'=>$status, 'score'=>$score)
        //$ret = array('requestID'=>'12J6-11B3-11A7-93C0', 'code'=>'721', 'status'=>'APA', 'score'=>'99.99');

        if (false === $ret) {
            $wl->write_log("Clearsale_Total_Status:Cs_status: Erro ao consultar status do pedido na ClearSale!");
            return;
        }
        $requestID = $ret['requestID'];
        $code = $ret['code'];
        $status = $ret['status'];	//APA, APM, RPM
        $score = $ret['score'];

        // gravar status no pedido
        $nome_status = Clearsale_Total_Status::Status_nome($status); // Cs_status é chamado pelo hook status.php, fora do contexto
        $note = __("ClearSale status: ", "clearsale");
        $note .= $status . " score: " . $score . "</br>Desc: " . $nome_status;

        $wl->write_log("Clearsale_Total_Status:Cs_status: retorno da consulta: status=" . $status . " score=" . $score);
        $wl->write_log("nota=" . $note);

        // Add the note
        $order->add_order_note($note);

        // Save the data
        $order->save();

        //if( $order->has_status( 'processing' ) ) {
        //$order->update_status( 'completed' );
        //}
            
        // Se status da Clear for aprovado temos que alterar o status do Woo para processing, mas usando o metodo normal ele gera um hook
        // no woo que vai chamar a inclusao de pedido na clearsale e o pedido jé foi incluído!!
        if ($status == "APA" || $status == "APM" || $status == "APP") {
            $wp_cs_options = get_option('clearsale-total');
            if (!isset($wp_cs_options['status_of_aproved'])) $status_of_aproved = "wc-processing";
            else $status_of_aproved = $wp_cs_options['status_of_aproved']; // o status que vamos colocar qdo o pedido for aprovado

            $wl->write_log("Clearsale_Total_Status:Cs_status: Pedido APROVADO(" .$pedido . ", status=" . $status . "), mudando status do Woo para " . $status_of_aproved . "!");
            if (!empty($order)) {
                //$order->update_status('processing'); ativa hook e vai inserir pedido já inserido!!!
                // este status fica na tabela posts (não é na postmeta) campo post_status
                //$order->status = 'processing';	//nao funcionou
                //$order->save();
                $my_post = array(
                    'ID'           => $pedido,
                    'post_status'  => $status_of_aproved, //'wc-processing',
                );
                // Update the post into the database!  Não gera hook de alteração de status!!
                $err_wp = wp_update_post($my_post);
                if ($err_wp != $pedido) {
                    $wl->write_log("Clearsale_Total_Status:Cs_status: Não foi possível alterar status do pedido erro=" . $err_wp);
                }
            }
            return;
        }

        // Se parâmetro de cancelar pedido estiver ON temos que cancelar pedido quando status da ClearSale for:
        // FRD, RPA, RPP e RPM
        $wp_cs_options = get_option('clearsale-total');
        $cancel_order = $wp_cs_options['cancel_order'];
        if ($cancel_order && ($status == 'FRD' || $status == 'RPA' || $status == 'RPP' || $status == 'RPM' || $status == 'SUS' || $status == 'CAN')) {
            $wl->write_log("Clearsale_Total_Status:Cs_status: Configurado para cancelar pedido(" .$pedido . ", status=" . $status . "), vamos cancelar!");
            if (!empty($order)) {
                $order->update_status('cancelled');
            }
            return;
        }

        if ($status == 'FRD' || $status == 'RPA' || $status == 'RPP' || $status == 'RPM' || $status == 'SUS' || $status == 'CAN') {
            $wl->write_log("Clearsale_Total_Status:Cs_status: Pedido REPROVADO(" .$pedido . ", status=" . $status . "), mudando status do Woo para failed!");
            if (!empty($order)) {
                $order->update_status('failed');
            }
        }
    } // end of Cs_status

    /**
     * Método para dar a descrição curta de um status retornado de uma análise.
     *
     * @since	"1.0.0"
     * @var		string	$status    Código do status
     * @return	string	Descrição curta do status
     */
    public static function statusShortNames($status)
    {
		//$wl = new Clearsale_Total_Log("clearsale-total", "2.1.1");
        $tmp = Clearsale_Total_Status::Status_nome($status);
        // (Cancelado pelo Cliente) â<80><93> Cancelado por solicitaÃ§Ã£o do cliente ou duplicidade do pedido
        // Não retorna uma string boa, peguei pelo )
		//$wl->write_log("Clearsale_Total_Status: statusShortNames: status=" . $status . " nome completo=" . $tmp);		
        $tmp1 = strstr($tmp, ')', true);
        $tirar = array("(", ")");
        $ret = str_replace($tirar, "", $tmp1);
        return($ret);
    } // end of statusShortNames

    /**
     * Método para dar a descrição completa de um status retornado de uma análise.
     *
     * @since	"1.0.0"
     * @var		string	$status    Código do status
     * @return	string	Descrição do código do status
     */
    public static function Status_nome($status)
    {
        $plugin_name = "clearsale-total";

        switch ($status) {

            case "APA":
                    return __("(Automatic Approval) - Request was approved automatically according to parameters defined in the automatic approval rule", $plugin_name);

            case "APM":
                    return __("(Manual Approval) - Order approved manually by decision of an analyst", $plugin_name);

            case "RPM":
                    return __("(Disapproved Without Suspicion) - Request Disapproved without Suspicion for lack	contact within the agreed period and / or policies restrictive of CPF (Irregular, SUS or Canceled)", $plugin_name);

            case "AMA":
                    return __("(Manual analysis) - Request is queued for analysis", $plugin_name);

            case "NVO":
                    return __("(New) - Order imported and not sorted Score by analyzer", $plugin_name);

            case "SUS":
                    return __("(Manual Suspension) - Suspended Suspension Suspected Fraud based on contact with the 'customer' or on the ClearSale database", $plugin_name);

            case "CAN":
                    return __("(Canceled by Customer) - Canceled upon client's request or order duplication", $plugin_name);

            case "FRD":
                    return __("(Fraud Confirmed) - Request imputed as Fraud Confirmed by contact with the card administrator and / or contact with the card or CPF that are unaware of the purchase", $plugin_name);

            case "RPA":
                    return __("(Automatic Deprecation) - Request Failed Automatically by some kind of Business Rule that needs to be applied (Note: usual and not recommended)", $plugin_name);

            case "RPP":
                    return __("(Policy Disapproval) - Request disapproved automatically by policy established by the customer or ClearSale", $plugin_name);

            case "APP":
                    return __("(Policy Approval) - Request approved automatically by policy established by the customer or ClearSale", $plugin_name);

        }// end of switch
    /*
        APA (Aprovação Automática) – Pedido foi aprovado automaticamente
        segundo parâmetros definidos na regra de aprovação automática

        APM (Aprovação Manual) – Pedido aprovado manualmente por tomada de
        decisão de um analista

        RPM (Reprovado Sem Suspeita) – Pedido Reprovado sem Suspeita por falta
        de contato com o cliente dentro do período acordado e/ou políticas
        restritivas de CPF (Irregular, SUS ou Cancelados)

        AMA (Análise manual) – Pedido está em fila para análise

        NVO (Novo) – Pedido importado e não classificado Score pela analisadora

        SUS (Suspensão Manual) – Pedido Suspenso por suspeita de fraude
        baseado no contato com o “cliente” ou ainda na base ClearSale

        CAN (Cancelado pelo Cliente) – Cancelado por solicitação do cliente ou
        duplicidade do pedido

        FRD (Fraude Confirmada) – Pedido imputado como Fraude Confirmada por
        contato com a administradora de cartão e/ou contato com titular do
        cartão ou CPF do cadastro que desconhecem a compra

        RPA (Reprovação Automática) – Pedido Reprovado Automaticamente por
        algum tipo de Regra de Negócio que necessite aplicá-la (Obs: não
        usual e não recomendado)

        RPP (Reprovação Por Política) – Pedido reprovado automaticamente por
        política estabelecida pelo cliente ou ClearSale

        APP (Aprovação Por Política) – Pedido aprovado automaticamente por
        política estabelecida pelo cliente ou ClearSale
    */
    } // end of status_nome

    /**
     * Create specific order statuses.
     *
     * Create a specific order statuses using register_post_status.
     *
     * @since    1.0.0
     */
    public static function register_my_new_order_statuses()
    {
        register_post_status('wc-cs-inanalisis', array(
            'label'                     => 'Análise de Risco ClearSale',
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Analise de Risco CearSale <span class="count">(%s)</span>', 'Analise de Risco CearSale<span class="count">(%s)</span>')
        ));
    }

    public static function add_new_order_status($order_statuses)
    {
        $order_statuses['wc-cs-inanalisis'] = _x('Análise de Risco ClearSale', 'Woocommerce Order Status', 'text_domain');
        return $order_statuses;
    }
} // end of class
