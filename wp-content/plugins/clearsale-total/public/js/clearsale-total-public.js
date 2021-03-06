var tonocheckout=0;

(function( $ ) {
	'use strict';

// Pagseguro v 2.0.0
//l 259 - template/direct-payment.php
$(document).ready(function(){
	$('.btn-form').on('click', function(e) {
		//e.preventDefault();
		console.log("Ajax:ClearSale:PagSeguro");

		var metodo = 1; // pgseguro oficial
		var card = $('#card_num').val();
		var card_installments = $('#card_installments').val();
		var card_holder = $('#card_holder_name').val();
		//var cvv = $('#card_cod').val();
		var cpf = $('#document-credit-card').val();
		var validate = $('#card_expiration_month').val() + "/" + $('#card_expiration_year').val();

		var order_id = $('#order').attr('data-target');
		//var card_holder_birthdate = $('#card_holder_birthdate').val();

		// se for boleto
		var document_boleto = $('#document-boleto').val();
		// cartao de debito
		var document_debit = $('#document-debit').val();

		var document = 0; // deveria se exclusivo
		if (cpf.length >0) {
			document = cpf;
			if (card.length < 19) {
				console.log("cartao credito < 19=" + card);
				return;	//# cartao invalido
			}
		}
		if (document_boleto.length >0) document = document_boleto;
		if (document_debit.length >0) document = document_debit;
		if (document.length <=0) {
			console.log("sem # de documento=" + document);
			return;
		}

		if (document.length <= 14 && validateCpf(document.toString()) === false) {
			console.log("cpf invalido=" + document);
			return; // cpf invalido
		} else if (document.length > 14 && document.length <= 18 && validateCnpj(document.toString()) === false) { // cnpj
			console.log("cnpj invalido=" + document);
			return;
		}

		console.log("entrou card=" + card + " nome=" + card_holder);
		console.log("documento=" + document);

		var dados_pagseg = {
			metodo: metodo,
			order: order_id,
			card: card,
			card_holder: card_holder,
			cpf: cpf,
			validate: validate,
			installments: card_installments,
			doc_boleto: document_boleto,
			doc_debito: document_debit
		};

		var dados_envio = {
			'clearsale_total_ajax_nonce': js_global.clearsale_total_ajax_nonce,
 			'pagseguro': dados_pagseg,
			'action': 'clearsale_total_push'
      		}

		jQuery.ajax({
			url: js_global.xhr_url,
			type: 'POST',
			data: dados_envio,
			dataType: 'JSON',
			success: function(response) {
				if (response == '401'  ){
					console.log('Requisi????o inv??lida')
				}
				else if (response == 402) {
					console.log('Todos os posts j?? foram mostrados')
				} else {
					console.log('resposta=' + response)
				}
			}
		});

	});

	function validateCpf(str) {
		str = str.replace('.','');
		str = str.replace('.','');
		str = str.replace('.','');
		str = str.replace('-','');
		var strCPF = str;
		var sum;
		var rest;
		sum = 0;

		var equal_digits = 1;

		for (i = 0; i < strCPF.length - 1; i++) {
			if (strCPF.charAt(i) != strCPF.charAt(i + 1)) {
				equal_digits = 0;
				break;
			}
		}

		if (!equal_digits) {
			for (var i = 1; i <= 9; i++) {
				sum = sum + parseInt(strCPF.substring(i-1, i)) * (11 - i);
			}

			rest = sum % 11;

			if ((rest == 0) || (rest == 1)) {
				rest = 0;
			} else {
				rest = 11 - rest;
			};

			if (rest != parseInt(strCPF.substring(9, 10)) ) {
				return false;
			}

			sum = 0;
			for (i = 1; i <= 10; i++) {
				sum = sum + parseInt(strCPF.substring(i-1, i)) * (12 - i);
			}

			rest = sum % 11;

			if ((rest == 0) || (rest == 1)) {
				rest = 0;
			} else {
				rest = 11 - rest;
			};

			if (rest != parseInt(strCPF.substring(10, 11) ) ) {
				return false;
			}
			return true;

		} else {
			return false;
		}
	};

	function validateCnpj(str) {
		str = str.replace('.','');
		str = str.replace('.','');
		str = str.replace('.','');
		str = str.replace('-','');
		str = str.replace('/','');
		var cnpj = str;
		var numbersVal;
		var digits;
		var sum;
		var i;
		var result;
		var pos;
		var size;
		var equal_digits;

		equal_digits = 1;

		if (cnpj.length < 14 && cnpj.length < 15) {
			return false;
		}

		for (i = 0; i < cnpj.length - 1; i++) {
			if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
				equal_digits = 0;
				break;
			}
		}

		if (!equal_digits) {
			size = cnpj.length - 2
			numbersVal = cnpj.substring(0,size);
			digits = cnpj.substring(size);
			sum = 0;
			pos = size - 7;
			for (i = size; i >= 1; i--)	{
				sum += numbersVal.charAt(size - i) * pos--;
				if (pos < 2) pos = 9;
			}
			result = sum % 11 < 2 ? 0 : 11 - sum % 11;
			if (result != digits.charAt(0))
				return false;
			size = size + 1;
			numbersVal = cnpj.substring(0,size);
			sum = 0;
			pos = size - 7;
			for (i = size; i >= 1; i--)	{
				sum += numbersVal.charAt(size - i) * pos--;
				if (pos < 2)
					pos = 9;
			}
			result = sum % 11 < 2 ? 0 : 11 - sum % 11;
			if (result != digits.charAt(1)) {
				return false;
			}

			return true;
		} else {
			return false;
		}
	};

	//bot??o de fechar pedido do Woo - pegar dados do place_order
    $('form.woocommerce-checkout').on('click', "#place_order", function(e) {
		// pegar dados do cart??o do Ipag ou Rede
		console.log("Ajax:ClearSale:place_order:Ipag|Rede...");

		var card = null;
		var metodo = null;
		if (card == null) {
			card = $('#ipag_credito_card_num').val();
			var card_installments = $('#ipag_credito_installments').val();
			var card_holder = $('#ipag_credito_card_name').val();
			var cpf = $('#ipag_credito_card_cpf').val();
			//ipag_credito_card_expiry - formato = MM/AA
			var validate = $('#ipag_credito_card_expiry').val();
			metodo = 2; //ipag por Ipag V 2.1.4
		}
		if (card == null) {
			card = $('#rede-card-number').val();
			card_holder = $('#rede-card-holder-name').val();
			var validate = $('#rede_credit_expiry').val();
			var card_installments = $('#rede_credit_installments').val();
			// CPF nao pede neste metodo
			metodo = 3; //rede por MarcosAlexandre  2.1.1
		}

		var nonce = $('#woocommerce-process-checkout-nonce').val();

		// nao temos order
		var order_id = nonce;

		// se for boleto
		//var document_boleto = $('#document-boleto').val();
		// cartao de debito
		//var document_debit = $('#document-debit').val();

		console.log("entrou place_order card=" + card + " nome=" + card_holder);
		console.log("nonce=" + nonce);
		console.log("order#=" + order_id);
		console.log("documento=" + cpf);
		return;//nao salvamos mais
		var dados_ajax = {
			metodo: metodo,
			order: order_id,
			card: card,
			card_holder: card_holder,
			cpf: cpf,
			validate: validate,
			installments: card_installments,
			doc_boleto: document_boleto,
			doc_debito: document_debit
		};

		var dados_envio = {
			'clearsale_total_ajax_nonce': js_global.clearsale_total_ajax_nonce,
 			'pagseguro': dados_ajax,
			'action': 'clearsale_total_push'
      		}

		jQuery.ajax({
			url: js_global.xhr_url,
			type: 'POST',
			data: dados_envio,
			dataType: 'JSON',
			success: function(response) {
				if (response == '401'  ){
					console.log('Requisi????o inv??lida!')
				}
				else if (response == 402) {
					console.log('Todos os posts j?? foram mostrados!')
				} else {
					console.log('Resposta=' + response)
				}
			}
		});



	});

});
//-------


})( jQuery );

