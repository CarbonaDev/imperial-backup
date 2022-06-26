<?php
function mipro_child_enqueue_styles() {
    wp_enqueue_style( 'mipro-style' , get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'mipro-child-style', get_stylesheet_directory_uri() . '/style.css', array( 'mipro-style' ) );
}
add_action(  'wp_enqueue_scripts', 'mipro_child_enqueue_styles' );

////////////////Remove a aba "Informações Adicionais/////////////////////////

add_filter( 'woocommerce_product_tabs', 'bbloomer_remove_product_tabs', 98 );
 
function bbloomer_remove_product_tabs( $tabs ) {
unset( $tabs['additional_information'] );
return $tabs;
}

///////////////Email de pedido recebido//////////////////////////////////////

// New order notification only for "Pending" Order status
/*
add_action( 'woocommerce_checkout_order_processed', 'pending_new_order_notification', 20, 1 );
function pending_new_order_notification( $order_id ) {
    // Get an instance of the WC_Order object
    $order = wc_get_order( $order_id );

    // Only for "pending" order status
    if( ! $order->has_status( 'pending' ) ) return;

    // Get an instance of the WC_Email_New_Order object
    $wc_email = WC()->mailer()->get_emails()['WC_Email_New_Order'];

    ## -- Customizing Heading, subject (and optionally add recipients)  -- ##
    // Change Subject
    $wc_email->settings['subject'] = __('{site_title} - Novo Pedido Pendente ({order_number}) - {order_date}');
    // Change Heading
    $wc_email->settings['heading'] = __('Novo Pedido Pendente'); 
    // $wc_email->settings['recipient'] .= 'contato@imperialtapeteseinteriores.com.br'; // Add email recipients (coma separated)

    // Send "New Email" notification (to admin)
    $wc_email->trigger( $order_id );

} 
*/

////////////////////// Esvaziar carrinho após checkout ////////////////////////
add_action( 'woocommerce_thankyou', 'order_received_empty_cart_action', 10, 1 );
function order_received_empty_cart_action( $order_id ){
    WC()->cart->empty_cart();
}

    
/////////*Trocar texto do botão showmore por comprar *///////////////
    
    // To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Comprar', 'woocommerce' ); 
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Comprar', 'woocommerce' );
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_quickview_text', 'woocommerce_custom_product_quickview_text' );
function woocommerce_custom_product_quickview_text() {
    return __( 'Comprar', 'woocommerce' );
}

add_filter ('Update cart', 'woocommerce');
function woocommerce_custom_update_text(){
	return __( 'Atualizando', 'woocommerce' );
}
/////////////// remove força da senha /////////////////////
function wc_ninja_remove_password_strength() {
    if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
        wp_dequeue_script( 'wc-password-strength-meter' );
    }
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );

/////STATUS EM CONFECÇÃO//////////////////////
// Register new status
function register_custom_order_statuses() {
    register_post_status('wc-em-confeccao', array(
        'label' => 'Em Confecção',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Em confecção <span class="count">(%s)</span>', 'Em Confecção <span class="count">(%s)</span>')
    ));

    register_post_status('wc-em-separacao', array(
        'label' => 'Em Separação',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Em separacao <span class="count">(%s)</span>', 'Em Separação <span class="count">(%s)</span>')
    ));

    register_post_status('wc-pedido-entregue', array(
        'label' => 'Pedido Entregue',
        'public' => true,
        'exclude_from_search' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Pedido Entregue <span class="count">(%s)</span>', 'Pedido Entregue <span class="count">(%s)</span>')
    ));
}
add_action('init', 'register_custom_order_statuses');


// Add to list of WC Order statuses
function add_custom_order_statuses($order_statuses) {
    $new_order_statuses = array();

    // add new order status after processing
    foreach ($order_statuses as $key => $status) {
        $new_order_statuses[$key] = $status;
        if ('wc-processing' === $key) {
            $new_order_statuses['wc-em-confeccao'] = 'Em confecção';
            $new_order_statuses['wc-em-separacao'] = 'Em Separação';
            $new_order_statuses['wc-pedido-entregue'] = 'Pedido Entregue';
        }
    }
    return $new_order_statuses;
}
add_filter('wc_order_statuses', 'add_custom_order_statuses');


// Admin reports for custom order status
function wc_reports_get_order_custom_report_data_args( $args ) {
    $args['order_status'] = array( 'completed', 'processing', 'on-hold', 'em-confeccao', 'em-separacao', 'pedido-entregue' );
    return $args;
};
add_filter( 'woocommerce_reports_get_order_report_data_args', 'wc_reports_get_order_custom_report_data_args');

///Adiciona menu acompanhmento no View Order
//add_action( 'woocommerce_thankyou', 'misha_view_order_and_thankyou_page', 20 );
//add_action( 'woocommerce_view_order', 'misha_view_order_and_thankyou_page', 20 );
add_action( 'woocommerce_order_details_before_order_table', 'misha_view_order_and_thankyou_page', 20 );

function misha_view_order_and_thankyou_page( $order_id ){  
$order = wc_get_order( $order_id );
$order_status = $order->get_status();
?>
 
		 <?php 
		switch ($order_status){
				case "cancelled": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 " id="stepInactive">Aguardando</li>
			<li class="step2 " id="stepInactive">Pagamento Confirmado</li>
			<li class="step3 " id="stepInactive">Em confecção</li>
			<li class="step4 " id="stepInactive">Em separação</li>
			<li class="step5" id="stepInactive">Pedido Enviado</li>
			<li class="step6" id="stepInactive">Pedido Entregue</li>
      </ul>
				<?php
 					break;

			case "on-hold":
			case "pending": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 active" id="stepActive">Aguardando</li>
			<li class="step2 " id="stepInactive">Pagamento Confirmado</li>
			<li class="step3 " id="stepInactive">Em confecção</li>
			<li class="step4 " id="stepInactive">Em separação</li>
			<li class="step5" id="stepInactive">Pedido Enviado</li>
			<li class="step6" id="stepInactive">Pedido Entregue</li>
      </ul>
				<?php
 					break; 
		case "processing": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 active" id="stepActive">Aguardando</li>
			<li class="step2 active" id="stepActive">Pagamento Confirmado</li>
			<li class="step3 " id="stepInactive">Em confecção</li>
			<li class="step4 " id="stepInactive">Em separação</li>
			<li class="step5" id="stepInactive">Pedido Enviado</li>
			<li class="step6" id="stepInactive">Pedido Entregue</li>
      </ul>
				<?php
 					break;
			
				case "em-confeccao": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 active" id="stepActive">Aguardando</li>
			<li class="step2 active" id="stepActive">Pagamento Confirmado</li>
			<li class="step3 active" id="stepActive">Em confecção</li>
			<li class="step4 " id="stepInactive">Em separação</li>
			<li class="step5" id="stepInactive">Pedido Enviado</li>
			<li class="step6" id="stepInactive">Pedido Entregue</li>
      </ul>
				<?php
 					break;
				
			case "em-separacao": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 active" id="stepActive">Aguardando</li>
			<li class="step2 active" id="stepActive">Pagamento Confirmado</li>
			<li class="step3 active" id="stepActive">Em confecção</li>
			<li class="step4 active" id="stepActive">Em separação</li>
			<li class="step5" id="stepInactive">Pedido Enviado</li>
			<li class="step6" id="stepInactive">Pedido Entregue</li>
      </ul>
				<?php
 					break;
				
			case "completed": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 active" id="stepActive">Aguardando</li>
			<li class="step2 active" id="stepActive">Pagamento Confirmado</li>
			<li class="step3 active" id="stepActive">Em confecção</li>
			<li class="step4 active" id="stepActive">Em separação</li>
			<li class="step5 active" id="stepActive">Pedido Enviado</li>
			<li class="step6" id="stepInactive">Pedido Entregue</li>
      </ul>
				<?php
 					break;	
			case "pedido-entregue": 
		?>
		<ul id="progressbar">
			<li class="step0 active" id="stepActive">Pedido Cancelado</li>
			<li class="step1 active" id="stepActive">Aguardando</li>
			<li class="step2 active" id="stepActive">Pagamento Confirmado</li>
			<li class="step3 active" id="stepActive">Em confecção</li>
			<li class="step4 active" id="stepActive">Em separação</li>
			<li class="step5 active" id="stepActive">Pedido Enviado</li>
			<li class="step6 active" id="stepActive">Pedido Entregue</li>
      </ul>
				<?php
 					break;
		}
		?>

<?php }

/// CHATPRO TESTE

add_action( 'woocommerce_order_status_changed', 'notification_chatpro',99, 3);

function notification_chatpro ( $order_id, $old_status, $new_status ) {
    		$order = wc_get_order( $order_id );
        	$number = $order->get_billing_phone();
			
			switch ($new_status){
				case "pending":
					$mensagem = "Olá *" . $order->get_billing_first_name() . "*, 🤗 Obrigado por comprar na Imperial - Tapetes e Interiores!\\n \\n Nós recebemos o seu pedido *#" . $order_id . "* e agora estamos aguardando a confirmação do pagamento, se o meio de pagamento escolhido foi boleto, pode levar até 48h após o pagamento. \\n \\n Mas nem se preocupe que vou avisando aqui ☺ \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "on-hold":
					$mensagem = "Olá *" . $order->get_billing_first_name() . "* 🤗, Obrigado por comprar na Imperial - Tapetes e Interiores!\\n \\n Nós recebemos o seu pedido *#" . $order_id . "* e agora estamos aguardando a confirmação do pagamento, se o meio de pagamento escolhido foi boleto, pode levar até 48h após o pagamento. \\n \\n Mas nem se preocupe que vou avisando aqui ☺ \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "failed":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*, \\n\\n Não foi possível confirmar o pagamento do seu pedido *#". $order_id . "* ❌ \\n \\n Qualquer dúvida estamos a disposição. \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "processing":
					$mensagem = "Olá *" . $order->get_billing_first_name() . "!* 🤗, Obrigado por comprar na *Imperial - Tapetes e Interiores!* \\n \\n Nós recebemos o seu pedido *#" . $order_id . "* e o pagamento já foi aprovado. ✅ \\n \\n Em breve voltarei aqui, para avisar sobre o andamento. ☺ \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "completed":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*, temos ótimas notícias!  ☺ \\n \\n O seu pedido *#". $order_id . "* já está com a transportadora. 🚚 Para acompanhar a entrega, através do link abaixo acesse a sua Conta e vá em Pedidos. \\n \\n https://imperialtapeteseinteriores.com.br/minha-conta/ \\n \\n Qualquer dúvida estamos à disposição. ☺ \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "cancelled":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*, o seu pedido *#". $order_id . "* foi cancelado. ❌ \\n\\n  Para mais informações entre em contato. \\n \\n  Qualquer dúvida estamos a disposição. \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "refunded":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*, o seu pedido *#". $order_id . "* foi reembolsado. \\n \\n Qualquer dúvida estamos a disposição.\\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "em-confeccao":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*, o seu pedido *#". $order_id . "* acabou de ser enviado para confecção. ✂🧵 \\n \\n  O tempo médio para ser confeccionado é de 20 a 30 dias úteis, assim que estiver pronto, será enviado imediatamente. Você poderá rastrear seu pedido diretamente em nosso site, acessando sua Conta e Pedidos. \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "em-separacao":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*, o seu pedido *#". $order_id . "* já está sendo separado, e embalado. 📦 \\n \\n Assim que tivermos o número de rastreamento do seu pedido, volto aqui para te informar. Você poderá rastrear seu pedido diretamente em nosso site, acessando sua Conta e Pedidos. \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
				case "pedido-entregue":
					$mensagem = "Olá *". $order->get_billing_first_name() . "*.\\n\\n Vimos aqui, que o seu pedido *#". $order_id . "* já foi entregue! 🤩 \\n \\n Espero que sua experiência de compra com a Imperial tenha sido incrível! \\n \\n E que tal compartilhar com a gente?🥰\\n É só postar no seu perfil ou stories do Instagram e marcar @imperialtapeteseinteriores\\n\\n Ou, você pode enviar uma foto do produto compondo sua decoração, a gente vai *AMAR* ver como ficou 🥰 \\n \\n Até a próxima! \\n \\n *Mensagem automática do nosso sistema, para falar com um de nossos consultores, acesse o link abaixo* 👇🏻\\n \\n https://api.whatsapp.com/send?phone=5553999214307";
					send_chatpro ($mensagem, $number);
 					break;
					
			}
			
}

function send_chatpro ($mensagem, $number) {
	
      // Using str_replace() function 
      // to replace the word 
      $numberClean = str_replace( array( '(', ')',
      '-'), '', $number);
  
			/*$ch = curl_init();

			$endpoint = "v4.chatpro.com.br/chatpro-5f6402196b";
			$token = "1cbe5439d865b38a05c42d7ff693458f";

			curl_setopt($ch, CURLOPT_URL, "https://v4.chatpro.com.br/chatpro-5f6402196b/api/v1/send_message");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"message\": \"${mensagem}\", \"number\": \"${number}\"}");
			curl_setopt($ch, CURLOPT_POST, true);

			$headers = array();
			$headers[] = 'Accept: application/json';
			$headers[] = "Authorization: 1cbe5439d865b38a05c42d7ff693458f";
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			} else {
				echo 'Envio concluido com sucesso';
			}

			curl_close($ch);     */
	
	
	//código dos caras da chatpro
	$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://v4.chatpro.com.br/chatpro-5f6402196b/api/v1/send_message",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n\t\"number\":\"${numberClean}\",\n\t\"message\":\"${mensagem}\"\n}",
	
  CURLOPT_HTTPHEADER => [
    "Authorization: 1cbe5439d865b38a05c42d7ff693458f",
    "Content-Type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
	
	
	
}
///manda sem estoque pro fim
add_filter('posts_clauses', 'order_by_stock_status');
function order_by_stock_status($posts_clauses) {
    global $wpdb;
    // only change query on WooCommerce loops
    if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
        $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
        $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
        $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
    }
    return $posts_clauses;
}

/////CAMPO PERSONALIZADO DE LINK NO CHECKOUT - TRANSFORMAR EM BOTÃO DEPOIS
add_action( 'woocommerce_checkout_create_order', 'add_custom_field_on_placed_order', 10, 2 );
function add_custom_field_on_placed_order( $order, $data ){
    $order->update_meta_data( 'linkderastreio', ' ' );

/////Remove "opcional" dos campos do checkout
add_filter( 'woocommerce_form_field' , 'elex_remove_checkout_optional_text', 10, 4 );
function elex_remove_checkout_optional_text( $field, $key, $args, $value ) {
if( is_checkout() && ! is_wc_endpoint_url() ) {
$optional = '<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
$field = str_replace( $optional, '', $field );
}
return $field;
} 

}

/**
 * Change number of related products output - RETIRA OS SEM ESTOQUE DOS RELACIONADOS
 */ 

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );

function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 12; // 4 related products
	$args['columns'] = 2; // arranged in 2 columns
			
	return $args;
}


// IMPEDE O ESTOQUE NEGATIVO DE ACONTECER - má pratica
add_filter( 'woocommerce_update_product_stock_query', 'disable_negative_stock_quantity', 10, 4 );
function disable_negative_stock_quantity( $sql, $product_id_with_stock, $new_stock, $operation ) {

    global $wpdb;
	//se o produto é sob encomenda
	$product = wc_get_product( $product_id_with_stock );
	if($product->backorders_require_notification() || $product->is_on_backorder() ){
		if ( $new_stock <=0 ) {
        $new_stock = 0;
    }
	if ( $new_stock > 0 ) {
        $new_stock = 0;
    }

	}
	
		/*if ( ($_product->managing_stock() == false && $_product->is_on_backorder( 1 )) || ($_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) ) {
	

    // if the new stock quantity is negative, it sets zero
    if ( $new_stock < 1 ) {
        $new_stock = 0;
    }*/

    // generates SQL with the stock quantity at zero
    $sql = $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = %f WHERE post_id = %d AND meta_key='_stock'", wc_stock_amount( $new_stock ), $product_id_with_stock );
    
    return $sql;

}

/////
/**
 * Redirecionar o cliente não conectado para minha conta e de volta para a página de checkout.*/

function redirect_before_checkout() {
	if ( is_user_logged_in() && is_account_page() ) {
		if ( isset( $_GET['return-to-checkout'] ) ) {
			wp_safe_redirect( get_permalink( get_option( 'woocommerce_checkout_page_id' ) ) );
			exit;
		}
	}
	
	if ( ! is_user_logged_in() && is_checkout() && ! is_wc_endpoint_url() ) { // adicionei o end point agora não trava, mas ainda não redireciona para minha-conta no click em pedidos
		$url = add_query_arg( 'return-to-checkout', 'true', get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) );
		wp_safe_redirect( $url );
		exit;
	}	
}
add_action( 'template_redirect', 'redirect_before_checkout' ); 


//////////////////////////////////////
//

//////////////////
add_filter('login_errors','login_error_message');

function login_error_message($error){
    //check if that's the error you are looking for
    $pos = strpos($error, 'incorrect');
    if (is_int($pos)) {
        //its the right error so you can overwrite it
        $error = '<b>ERRO:</b> O nome de usuário ou senha que você digitou está incorreto. <a href="https://imperialtapeteseinteriores.com.br/minha-conta/lost-password/">Perdeu sua senha?</a>';
    }
    return $error;
}


///REMOVER PRODUTOS OUT OF STOCK'S DA PAGINA INICIAL
add_filter( 'woocommerce_product_query_meta_query', 'filter_product_query_meta_query', 10, 2 );
function filter_product_query_meta_query( $meta_query, $query ) {
// On woocommerce home page only
if( is_front_page() ){
// Exclude products "out of stock"
$meta_query[] = array(
'key' => '_stock_status',
'value' => 'outofstock',
'compare' => '!=',
);
}
return $meta_query;
}

//REFRESH NO CARRINHO QUANDO UPDATED
function ss_cart_updated( $item_id ) {

};

// add the action
add_action( 'woocommerce_cart_item_removed', 'sample', 1);


//adiciona a div de FALTA PARA FRETE GRÁTIS no carrinho
add_action('woocommerce_before_cart', 'sample', 1);
$desenhado01 = false;
function sample() {

$categorias_excluir = array('banquetas', 'banquetas-puufs','peles-de-ovelha','almofadas');
    $number_of_items = sizeof( WC()->cart->get_cart() );
    $found  = false; // Initializing
    $notice = ''; // Initializing

    if ( $number_of_items > 0 ) {

        // Loop through cart items
        foreach ( WC()->cart->get_cart() as $cart_item ) {
            $product = $cart_item['data'];
            $product_id = $cart_item['product_id'];

            // Detecting if the defined category is in cart
            if ( has_term( $categorias_excluir, 'product_cat', $product_id ) ) {
                $found = true;
                break; // Stop the loop
           		} 
        	} 
        }
	
$limite = 490.00;
$valorCarrinho = floatval(WC()->cart->subtotal);
     if( $valorCarrinho < $limite && $found == false ) {  ?>

<div class="aviso01" style="width:100%;height:125px;background-color:#e83946;color:white; text-align: center; border-radius:13px;" >
<br><div style="width:100%;text-align:center; font-size: 32px;"><i class="fas fa-truck" style="color:white;"></i> </div><br>
<div style="font-weight:bold; "> Olá, faltam apenas R$<?php echo number_format((float)$limite - $valorCarrinho, 2, ',', ''); ?> para você ganhar FRETE GRÁTIS</div>
</div>
<?php } else if( $valorCarrinho > $limite && $found == false ) { ?>

<div class="aviso01" style="width:100%;height:125px;background-color:#00a550;color:white; text-align: center; border-radius:13px;">
<br><div style="width:100%;text-align:center; font-size: 32px;"><i class="fas fa-truck" style="color:white;"></i> </div><br>
<div style="font-weight:bold; "> Oba! Sua compra ganhou FRETE GRÁTIS </div>
</div>
<?php }
	
}
//////HOOK LIMPEZA DE CACHE SEMANAL
add_action( 'limpacachesemanal', 'my_function' );

function my_function() {
    w3tc_flush_all();
}

///////////////////////////////////////////////////////////////

// Scheduled Action Hook 
 
function w3_flush_cache( ) { 
	$w3_plugin_totalcache->flush_all(); 
} 
 
// Schedule Cron Job Event 
 
function w3tc_cache_flush() { 
	if ( ! wp_next_scheduled( 'w3_flush_cache' ) ) { 
		wp_schedule_event( current_time( 'timestamp' ), 'daily', 'w3_flush_cache' ); 
	} 
} 
 
add_action( 'wp', 'w3tc_cache_flush' ); 

//////////////////////////////////////////////
//Editar mensagem de X em estoque na page de produto
/*
add_filter( 'woocommerce_get_availability', 'custom_get_availability', 1, 2);

function custom_get_availability( $availability, $_product ) {
  global $product;
  $stock = $product->get_stock_quantity();
	
	if( $product->is_on_backorder( ) ){
		
		$availability['availability'] = __('Disponível so b encomenda', 'woocommerce');
	
	} else {
		switch (true) {
				case ($stock > "1"):
				$availability['availability'] = __('Restam apenas ' . $stock . ' unidades. Aproveite!', 'woocommerce');	
				break;
				case ($stock == "1"):
				$availability['availability'] = __('Resta apenas ' . $stock . ' unidade. Aproveite!', 'woocommerce');
				break;
				default: 
				$availability['availability'] = __('Fora de Estoque', 'woocommerce');
				break;
		};
		
	}
	
	//Varias unidades
  if ( $_product->is_in_stock() && $stock > 1 ) $availability['availability'] = __('Restam apenas ' . $stock . ' unidades. Aproveite!', 'woocommerce');
	//1 unidade só
	if ( $_product->is_in_stock() && $stock == 1 ) $availability['availability'] = __('Resta apenas ' . $stock . ' unidade. Aproveite!', 'woocommerce');
	//sem estoque
  if ( !$_product->is_in_stock() && !$_product->is_on_backorder()  ) $availability['availability'] = __('Fora de Estoque', 'woocommerce');
	
	//sem estoque MAS Sob Encomenda  
if ( $product->managing_stock() && $product->is_on_backorder( 1 ) ) $availability['availability'] = __('Disponível sob encomenda', 'woocommerce');
	
  return $availability;
} 
*/

/**
* Change the test for "In Stock / Quantity Left / Out of Stock".
*/

//Aumenta treshold da variação com foto para tirar estoque
	function iconic_wc_ajax_variation_threshold( $qty, $product ) {
		if($product->get_id() == '20682')
			return 80;
    
	}
add_filter( 'woocommerce_ajax_variation_threshold', 'iconic_wc_ajax_variation_threshold', 10, 2 );

/*//desabilitar varia��o sem estoque em produto espec�fico
add_filter( 'woocommerce_variation_is_active', 'grey_out_variations_when_out_of_stock', 10, 2 );
function grey_out_variations_when_out_of_stock( $grey_out, $variation ){
$product = wc_get_product( $variation->get_parent_id() );
if ( $product->get_id() == '20682' && !$variation->is_in_stock()){
  return false; //desabilita varia��o
 }else{
  return true; //mostra lista de espera
 }
}*/

add_filter( 'woocommerce_variation_is_visible', 'hide_specific_product_variation', 10, 4 );
function hide_specific_product_variation( $is_visible, $variation_id, $variable_product, $variation ) {
    // Here define the variation(s) ID(s) to hide

	$product = wc_get_product( $variation->get_parent_id() );

	if ( $product->get_id() == '20682'){

	   if(!$variation->is_in_stock()){
	   			$variations_ids_to_hide = array(strval( $variation_id ));
	   }
    
    // For unlogged user, hide defined variations
    if( in_array($variation_id, $variations_ids_to_hide ) ) {
        return false;
    }
    return $is_visible;
	}
	return $is_visible;
}


///////////////////////////////////////////////////////////////////////


add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
		
	
    // 1 unidade
    if ( $_product->is_in_stock() && $_product->get_stock_quantity() < 2 && ! $_product->is_on_backorder() ) {
        $availability['availability'] = sprintf( __('Resta apenas %s unidade. Aproveite!', 'woocommerce'), $_product->get_stock_quantity());
		return $availability;
    }
	
	// multiplas unidades
	if ( $_product->is_in_stock() && $_product->get_stock_quantity() > 1 && ! $_product->is_on_backorder() ) {
			$availability['availability'] = sprintf( __('Restam apenas %s unidades. Aproveite!', 'woocommerce'), $_product->get_stock_quantity());
			return $availability;
		}

    // Sem estoque
    if ( ! $_product->is_in_stock() && ! $_product->is_on_backorder() ) {
        $availability['availability'] = __('Fora de Estoque', 'woocommerce');
		return $availability;
    }
	//sob encomenda
	if ($_product->is_on_backorder() ) {
        $availability['availability'] = __('Disponível sob encomenda', 'woocommerce');
		return $availability;
    }
	
	/*
    if ( ! $_product->is_in_stock() ! $_product->is_on_backorder() ) {
        $availability['availability'] = __('Custom Messsage', 'woocommerce');
    }

    return $availability;
		*/
}

/*ENVIAR PUT AO ALTERAR STATUS DE ENVIO

add_action('woocommerce_order_status_changed','action_woocommerce_order_status_changed',10, 2 );
function action_woocommerce_order_status_changed( $order_id, $data ) { 
   	$order_id = #18979;
	$order = wc_get_order( $order_id );
    $order->update_meta_data( 'linkderastreio', 'teste' );
}

//add_action('woocommerce_order_status_changed', 'add_category_to_order_items_on_competed_status', 10, 1);
*/
function add_category_to_order_items_on_competed_status( $order_id ) {
	/*$order_id = '18979';
	$order = wc_get_order( $order_id );
    $order->update_meta_data( 'linkderastreio', 'teste' );
	
	$url = 'https://bling.com.br/Api/v2/pedido/'.$order_id.'/json';
	$xml = '<?xml version="1.0" encoding="UTF-8"?><pedido><idSituacao>37990</idSituacao></pedido>';
	
	$body = array(
			'apikey' => '1c83ebcc4eedd7677aff65ded4a874876f1dd15da5585059a702491607ba333106956f93',
			'xml' => rawurlencode($xml)
	);
	$args = array(
		'headers' => array(
		'Content-Type'   => 'application/json',
		),
		'body'      => json_encode($body),
		'method'    => 'PUT'
	);

	$result =  wp_remote_request( "https://bling.com.br/Api/v2/pedido/'.$order_id.'/json", $args );

	///////original//////
    $order = wc_get_order( $order_id );
	
    if ( $order->get_status() == 'wc-em-confeccao') {
	dd("mudou status");*/
	
      /*  $urlSituacoes = 'https://bling.com.br/Api/v2/situacao/Vendas/json?apikey=1c83ebcc4eedd7677aff65ded4a874876f1dd15da5585059a702491607ba333106956f93';
		$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $urlSituacoes);
			curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
			$responseSituacoes = curl_exec($curl_handle);
			curl_close($curl_handle);
			$situacoes = $responseSituacoes;
		*/

		/*$url = 'https://bling.com.br/Api/v2/pedido/'.$order_id.'/json';
		$xml = '<?xml version="1.0" encoding="UTF-8"?><pedido><idSituacao>37990</idSituacao></pedido>';
		$posts = array (
			'apikey' => '1c83ebcc4eedd7677aff65ded4a874876f1dd15da5585059a702491607ba333106956f93',
			'xml' => rawurlencode($xml)
		);
		//$retorno = executeUpdateOrder($url, $posts);
		$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $url);
			curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($curl_handle, CURLOPT_POST, count($posts));
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $posts);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($curl_handle);
			curl_close($curl_handle);
			echo $response;
				
	}*/
}

/*ESCONDE PRODUTOS FORA DE ESTOQUE DO PRODUTOS RELACIONADOS*/
add_filter( 'woocommerce_related_products', 'exclude_oos_related_products', 10, 3 );

function exclude_oos_related_products( $related_posts, $product_id, $args ){
    $out_of_stock_product_ids = (array) wc_get_products( array(
          'status'       => 'publish',
          'limit'        => -1,
          'stock_status' => 'outofstock',
          'return'       => 'ids',
      ) );

    $exclude_ids = $out_of_stock_product_ids;

    return array_diff( $related_posts, $exclude_ids );
}

/*DIMINIUR 1 NO STATUS MALSUCEDIDO PRA AUMENTAR 1 NO CANCELADO*/

add_action( 'woocommerce_order_status_changed', 'aumentaestoque',99, 3);

function aumentaestoque ( $order_id, $old_status, $new_status ) {
    		$order = wc_get_order( $order_id );
        	if($new_status=='failed'){
			$order_item = $order->get_items(); //pega itens do pedido
				
    		foreach( $order_item as $item_id => $item ) {
			
				/*$product = $item->get_product();
				$quantidade = $item->get_quantity();
				wc_update_product_stock( $product, $quantidade, 'decrease', '' );*/
    }
				
			}
}

//////verificar pedidos feito por pix a mais de uma hora e troca o status para mal sucedido
add_action('updatepedidopix','updatepedidopixfunc');

function updatepedidopixfunc(){
	
	$processing_orders = (array) wc_get_orders( array(
        'limit'        => -1,
        'status'       => ['wc-on-hold'],
    	'date_created' => '<' . ( time() - HOUR_IN_SECONDS )
    ) );
	
	 if ( sizeof($processing_orders) > 0 ) {
		 
		  foreach ( $processing_orders as $order ) {
				if( $order->get_meta('pix_qr')){

				$order->update_status('failed', '');	
				}
			  
		  }
		 
	 }
}

/////Disable functions.php edit 
define('DISALLOW_FILE_EDIT',true);

