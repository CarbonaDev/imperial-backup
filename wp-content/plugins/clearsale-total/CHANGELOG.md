2.5.1 - 11/04/22
- Colocado método Asaas - crédito, boleto e Pix, sem pegar dadod de cartão.

2.5.0 - 14/03/22
- Agora perguntando qual status vamos colocar quando o pedido for aprovado pela ClearSale.
- Colocado método juno-pix e o wc_pagarme_pix_payment.

2.4.6 - 22/02/22
- Em determinadas situações não pegava número da rua, tanto em shipping quanto em billing. Se tem Brazilian extra fields salvamos o DOB e bairro do billing.

2.4.5 - 19/01/22
- Colocado método Rede de MarcosAlexandre - V2.1.1 e iPag Payment Gateway for WooCommerce. Versão 2.1.4 | Por iPag Pagamentos Digitais. Ambos pegando dados de cartão.

2.4.4 - 16/12/21
- Tirado o JS do mapper, sem uso, não precisava ficar ativo.

2.4.3 - 10/11/21
- Em algumas situações os Correios retorna NULL no bairro quando não encontra o CEP, método Busca_Bairro_ws.

2.4.2 - 10/09/21
- Colocado métodos do Mercado Pago paymentes V 5.2.1. Pix e boleto.

2.4.1 - 25/08/21
- No caso de internacionalização vamos olhar o país apenas no billing, podendo no shipping não tem conteúdo no campo país.
  Colocado o novo método PIX da Piggly - V 1.3.15
  Adicionado log remoto de instalação e desintalação, salvando apenas url, versão e datetime destes eventos.
  Adicionada versão do plugin no topo da tela de configurações.

2.4.0 - 23/07/21
- Adicionado novo método do e.Rede, de nome "erede" apenas para crédito.
  Version 1.0 | By e.rede - Tipo_pagamento: tipo=erede

2.3.1 - 19/07/21
- Desligado o required do wordpress para o campo cs_field_doc da classe extrafields.

2.3.0 - 08/07/21
- Verificado o país do cliente (billing e shipping), se não for Brasil, não consistimos o Cpf/Cnpj e não
  integramos o pedido na ClearSale, o nosso campo de documento aparece "Válido no Brasil", se usar o plugin
  woo_extra_fields_bra (Brazilian Market on WooCommerce) e o país não for BR não cosistimos o documento digitado.
  Repassado método checkVersion para pegar erro quando não tem SOAP. Os erros não são traduzidos, pois o plugin não é ativado quando dá erro.

2.2.2 - 21/06/21
- Inserido mais um método de pagamento:
  bp_boleto_santander - Boleto Santander - Versão 1.3.1 | Por Rodrigo Max / Agência BluePause

2.2.1 - 16/06/21
- Inserido os novos métodos de pagamentos:
  Pix - loja5 - loja5_woo_pix_estatico - Integração aos Pagamentos Pix Estático - V 1.0
  Boleto - loja5 - Banco do Brasil - Boleto - Integração aos Pagamentos Banco do Brasil Ecommerce. - V 1.0
  Boleto - Juno - Boleto - Juno para WooCommerce - Versão 2.3.3

2.2.0 - 25/03/21
- Tirado da coluna de status e dentro do pedido tb. o "Esperando aprovação do Pagamento".
- Colocado na coluna de status, no lugar das siglas (APA,RPM) o nome curto, a descrição completa só dentro do pedido.
- Quando tem um cancelamento pela Clear, pelos status FRD, RPA, RPP, RPM, SUS e CAN recolocamos estes status mesmos e NÃO o CAN apenas.
- Perdia a session do carrinho ao gravar pedido (apartir da 2.0) agora salvamos a session do carrinho para enviar qdo integra o pedido, assim o FP fica correto.
- Em public/status.php retornava 404 em caso de acesso inválido, mudado para 400 Bad Request.

2.1.1 - 09/03/21
- Pegando e-mail do billing quando compra é por visitante. Não tem o customer e o email vai ser o do cadastro do billing.

2.1.0 - 10/2/21
- Agora contempla método de pagamento Payzen Payment for WooCommerce. Versão 1.0.27 | Por iPag.

2.0.0 - 18/11/20
- Agora enviando pedidos para ClearSale na mudança de status (qdo pedido foi pago) não mais no fechamento do pedido.
- Alterado sintaxe na rotina de validar CPF e CNPJ, para não dar erro de deprecated.
- Quando for reembolso não mandar chargeback para ClearSale.
- WooCommerce pagamento na entrega - V 1.3.2 - Carlos Ramos - dinheiro=woo_payment_on_delivery - 14/12/20.
- Cielo API 3.0 - Loja 5 - Plugin V 3.0 - débito = loja5_woo_cielo_webservice_debito crédito=loja5_woo_cielo_webservice
  boleto=loja5_woo_cielo_webservice_boleto.
- Após aprovação muda status do pedido do Woo para processing!

1.3.2 - 13/11/20
- Voltamos a pegar pedidos pelo hook checkout_order_processed também, junto com thankyou.

1.3.1 - 26/08/20
- Incluído mensagem dos hooks acionados no checkout.
- Testa a existência de tonocheckout na rotina que vai no footer.
- Alterado o tipo de pgto de 14 para 11, quando for transferência e pgto em dinheiro.
- Ao buscar um bairro, usando os Correios, em caso de falha, retornar o bairro com BRANCOS e não nulo.

1.3.0 - 21/08/20
- Mensagem de responsabilidade qdo os pedidos NÃO são cancelados em caso de reprovação.

1.2.1 - 27/07/20
- Consistência de PF e PJ não estava funcionando, colocava sempre PJ.

1.2.0 - 20/07/20
- Inserido opção para lojista cancelar pedido se não foi aprovado pela ClearSale
- No log, quando pegar as chaves, aparece a versão do plugin.
- Para pegar dados do pedido, no fechamento, usamos agora o hook woocommerce_thankyou
- Pegando método do PagSeguro - Claudio Sanches

1.1.6 - 10/07/20
- Pegando o método do e.Rede API - Versão 1.0 - Cartão de Crédito - loja5.

1.1.5 - 11/02/20
- Alterado timeout e exception no soap com os correios, na rotina que pega o bairro dado o CEP.

1.1.4 - 28/01/20
- Pegando o método de pgto Cielo Webservice API 3.0 - Jrossetto.
- No checkout o metodo $order->get_meta('cs_doc') não pegava o # do doc, no caso de falha usado o get_post_meta($order_id, 'cs_doc', true)
 
1.1.3 - 22/10/19
- Pegando o método de pgto PagHiper (apenas boleto), mais informação de log no authenticate.

1.1.2 - 07/10/19
- Pegando o método de pgto boleto e crédito da pagar.me.

1.1.1 - 02/10/19
- Diferenciado o Cielo-Checkout de débito|crédito|boleto.
- Diferenciado o débito e crédito do Cielo-webservices.
- Logando tipo de pagamento, colocando correto o tipo quando for Rede e Cielo Checkout.

1.1.0 - 15/09/2019
- Colocado compatibilidade com woocommerce-extra-checkout-fields-for-brazil.

1.0.0 - 02/07/2019
- Versão inicial. Integração com APIs da ClearSale e integração total com PagSeguro oficial do UOL.
