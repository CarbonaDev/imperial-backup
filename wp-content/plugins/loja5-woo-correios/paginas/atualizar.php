<?php 
//dados da tabela
$linha = $wpdb->get_row( "SELECT * FROM correios_offline5_tabelas WHERE id = '".(int)$_GET['id']."'", ARRAY_A );
//faixas de ceps
$faixas = $wpdb->get_results( "SELECT * FROM correios_offline5_base ORDER BY base_cep ASC", ARRAY_A );
?>

<div class="updated notice">
<p>
Ao iniciar o processo de atualiza&ccedil;&atilde;o dever&aacute; aguardar o procedimento at&eacute; que o mesmo seja concluido, n&atilde;o feche esta janela e lembre-se que servi&ccedil;os com contrato s&oacute; funciona caso tenha contrato Correios e o mesmo esteja devidamente configurado, lembre-se que os valores calculados s&atilde;o apenas estimativas para uso em contig&ecirc;ncia.
</p>
</div>

<div class="wrap">

<h1 class="wp-heading-inline">Atualizar Tabela <?php echo $linha['titulo'];?></h1>

<hr class="wp-header-end">

<div id="barra-progresso" style="height: 35px; border: 1px solid #CCC; border-radius: 5px;">
<div id="atualizar-progresso" style="border-radius: 5px; line-height: 35px; width: 0%; background-color: #8BC34A; text-align: center; color: #FFF;">0%</div>
</div>
<br>
<button type="button" onclick="calcular_fretes(0)" id="botao-atualizar-faixas" class="button button-primary">Confirmar e Atualizar</button>

</div>

<script>
//faixas ceps base
var faixa_ceps = [];
<?php foreach($faixas as $k=>$v){?>
faixa_ceps.push('<?php echo str_pad($v['base_cep'], 8, "0", STR_PAD_LEFT); ?>');
<?php } ?>

//faixas ceps de
var faixa_ceps_inicio = [];
<?php foreach($faixas as $k=>$v){?>
faixa_ceps_inicio.push('<?php echo str_pad($v['inicio'], 5, "0", STR_PAD_LEFT); ?>');
<?php } ?>

//faixas ceps para
var faixa_ceps_fim = [];
<?php foreach($faixas as $k=>$v){?>
faixa_ceps_fim.push('<?php echo str_pad($v['fim'], 5, "0", STR_PAD_LEFT); ?>');
<?php } ?>

//faixas custom
var faixa_custom = [];
<?php foreach($faixas as $k=>$v){?>
faixa_custom.push('<?php echo $v['custom']; ?>');
<?php } ?>

//calcula os fretes
var progresso = 0;
function calcular_fretes(inicio){
    jQuery('#botao-atualizar-faixas').attr("disabled","disabled").html('(aguarde o termino)');
    var incremento = inicio;
    var arrayStop = faixa_ceps.length-1;
    var pulo = <?php echo number_format((100/count($faixas)), 2, '.', '');?>;
	jQuery.ajax({
		method: "POST",
		url: "<?php echo admin_url( 'admin-ajax.php' );?>?action=loja5_woo_correios_atualizar",
		data: { custom: faixa_custom[inicio], cep: faixa_ceps[inicio], index: inicio, servico: '<?php echo (int)$linha['id_servico'];?>', de: faixa_ceps_inicio[inicio], para: faixa_ceps_fim[inicio] }
	}).done(function( ret ) {
		
		//incrementa o bar
		console.log(progresso);
		progresso += pulo;
		
		//regra para nao passar de 100
		if(progresso >= 100){
			progresso = 100;
		}
		
		//alimenta o bar
		jQuery('#atualizar-progresso').css('width', progresso.toFixed(2)+'%'); 
		jQuery('#atualizar-progresso').html(progresso.toFixed(2)+'%'); 
		
		//verifica se e a ultima
		incremento += 1;
		if(inicio < arrayStop){
			calcular_fretes(incremento);
		}else{
			console.log('fim');
			jQuery('#atualizar-progresso').css('width', '100%'); 
			jQuery('#atualizar-progresso').html('100%'); 
			jQuery('#botao-atualizar-faixas').attr("disabled","disabled").html('Concluido');
			setTimeout(function(){location.href='admin.php?page=loja5-woo-correios-tabelas';}, 5000);
		}
	}).fail(function(jqXHR, textStatus) {
		alert( "Ops ocorreu um erro ao atualizar a tabela, o sistema de webservice dos Correios podera esta lento ao fora de servico, tente novamente mas tarde!" );
		jQuery('#botao-atualizar-faixas').removeAttr("disabled").html('Confirmar e Atualizar');
		progresso = incremento-1;
		//calcular_fretes(incremento-1);
	});
}
</script>