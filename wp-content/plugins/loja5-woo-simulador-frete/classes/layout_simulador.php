<br>
<script>
function mascara_simulador_cep(t, mask){
	var i = t.value.length;
	var saida = mask.substring(1,0);
	var texto = mask.substring(i)
	if (texto.substring(0,1) != saida){
		t.value += texto.substring(0,1);
	}
}
</script>
<fieldset id="fild-simulador" style="border: none;">
<div style="<?php echo ($box)?'border: 1px solid #CCC; padding: 10px; border-radius: 10px;':'';?>max-width:<?php echo $largura_simulador;?> !important;" class="box-simulador">
<?php if(!empty($titulo_simulador)){ ?>
<h4 class="titulo_simulador_box"><?php echo $titulo_simulador; ?></h4>
<?php } ?>
<input onkeyup="mascara_simulador_cep(this, '#####-###')" type="text" class="input-text text" maxlength="9" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="CEP" style="width:<?php echo $largura_cep;?> !important;" name="cep_simulador" id="cep_simulador"> <button id="botao_simulador_frete" style="background-color:<?php echo $cor_botao;?> !important; color: #FFF;" class="button alt" type="button"><?php echo $titulo_botao; ?></button>
<div style="font-size: 15px; margin-top: 5px;" id="resultado-simulador-frete"></div>
</div>
<div style="font-size: 15px; margin-top: 5px; margin-bottom: 35px; "> *Frete Gr&aacute;tis, v&aacute;lido para toda a linha de tapetes de couro, nas compras acima de R$490,00.  </div>
</fieldset>
<script>
jQuery( document ).on( 'click', '#botao_simulador_frete', function() {
	var tipo_produto = '<?php echo $product->get_type();?>';
	var botao_simular = '<?php echo $titulo_botao; ?>';
	var id_produto = '<?php echo $id_produto; ?>';
	var variacao = 0;
	if(tipo_produto=='grouped'){
		var quantidades = [];
		var lista = jQuery('form').find('.qty');
		jQuery.each(lista, function( key, value ) {
			quantidades.push(jQuery(value).attr('value'));
		});
		var qtd = quantidades.join(',');
	}else if(tipo_produto=='variable'){
		var variacao = jQuery('input[name="variation_id"]').val();
		var qtd = jQuery('.qty,.qtd').val(); 
		if(variacao=='' || variacao==0){
			alert('Selecione as opções!');
			return false;
		}
	}else{
		var qtd = jQuery('.qty,.qtd').val(); 
	}
	var cep = jQuery('#cep_simulador').val(); 
	cep = cep.replace(/[^\d]/,'');
	if(cep.length==8){
		jQuery('#botao_simulador_frete').html('Aguarde...');
		jQuery('#resultado-simulador-frete').html('');
		jQuery.ajax({
			url : '<?php echo admin_url( 'admin-ajax.php' );?>',
			type : 'post',
			dataType: 'JSON',
			data : {id: id_produto,variacao: variacao,cep: cep, qtd: qtd, action:'calcular_frete_simulador_loja5'},
			success : function( response ) {        
				console.log(response);
				if(response.erro==false && response.rates){
					var html = '<table class="table">';
					html += '<tr><th style="width:70%">M&eacute;todo</th><th style="width:30%">Valor</th></tr>';
					jQuery.each( response.rates, function( key, value ) {
						html += '<tr><td>'+value.label+' '+value.prazo+'</td><td>R$'+value.cost+'</td></tr>';
					});
					html += '</table>';
					<?php if($localidade){ ?>
					if(response.local){
						html += '<i style="float:right;">'+response.local+'</i><br>';
					}
					<?php } ?>
					jQuery('#resultado-simulador-frete').html(html);
				}else{
					jQuery('#resultado-simulador-frete').html('<i>'+response.msg+'</i>');
				}
				jQuery('#botao_simulador_frete').html(botao_simular);
			}
		});
	}else{
		jQuery('#cep_simulador').focus();
	}
});
</script>