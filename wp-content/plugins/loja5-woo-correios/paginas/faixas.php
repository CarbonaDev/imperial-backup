<?php 
//filtros
$where = '';
if(isset($_GET['cep']) && !empty($_GET['cep'])){
	$cep_filtro = substr(str_pad(preg_replace('/\D/', '', $_GET['cep']), 8, "0", STR_PAD_LEFT),0,5);
	$where .= " AND (".(int)$cep_filtro." BETWEEN `inicio` AND `fim`) ";
}
//total 
$total = $wpdb->get_var( "SELECT COUNT(*) FROM correios_offline5_base WHERE 1=1 $where" );
//paginacao
$por_pagina = LOJA5_WOO_CORREIOS_REG_PG;
$max_num_paginas = ceil( $total / $por_pagina );
$pagina = (int)isset($_GET['pg'])?$_GET['pg']:1;
$inicio = ($pagina-1) * $por_pagina;
$page_links = paginate_links( array(
	'base' => add_query_arg( 'pg', '%#%' ),
	'format' => '',
	'prev_text' => __( '&laquo;', 'loja5-woo-correios' ),
	'next_text' => __( '&raquo;', 'loja5-woo-correios' ),
	'total' => $max_num_paginas,
	'current' => $pagina
));
//listagem
$sql = "SELECT * FROM correios_offline5_base WHERE 1=1 $where ORDER BY custom DESC, base_cep ASC LIMIT $inicio, $por_pagina";
$faixas = $wpdb->get_results( $sql, ARRAY_A );
?>

<div class="updated notice">
<p>
O CEP Base ser&aacute; o CEP usado para calculo do frete para as faixas de entrega de cada local de acordo as modalidades que deseja usar, regras custom s&atilde;o verificadas primeiro, somente regras custom podem ser removidas, lembre-se que sempre que editar regras dever&aacute; atualizar as tabelas.
</p>
</div>

<div id="tela-faixas-offline" class="wrap">

<h1 class="wp-heading-inline">Faixas de CEPs Correios Offline</h1>
<a class="page-title-action" onclick="adicionar_faixa()" style="color: #ffffff; background-color: #8bc34a;border-color: #5f9a1a;">Adicionar Faixa</a>

<hr class="wp-header-end">

<div class="tablenav">	
<div class="tablenav-pages" style="margin: 1em 0">
<label class="screen-reader-text" for="post-search-input">Pesquisar CEP:</label>
<input type="search" id="cep-pesquisa" name="s" value="">
<input type="button" onclick="pequisar_cep()" class="button" value="Pesquisar CEP">
</div>
</div>

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th scope="col" style="width:60px;" class="manage-column">ID</th>
<th scope="col" style="width:60px;" class="manage-column">UF</th>
<th scope="col" class="manage-column">Detalhes</th>
<th scope="col" style="width:100px;" class="manage-column">CEP Inicio</th>
<th scope="col" style="width:100px;" class="manage-column">Data Fim</th>
<th scope="col" style="width:100px;" class="manage-column">CEP Base</th>
<th scope="col" style="width:20%"></th>
</tr>
</thead>
<tbody>
<?php 
foreach($faixas as $k => $v) {
?>
<tr>
<th><?php echo str_pad($v['id'], 5, "0", STR_PAD_LEFT); ?></th>
<td><?php echo $v['uf']; ?></td>
<td><?php echo $v['detalhes']; ?></td>
<td><?php echo str_pad($v['inicio'], 5, "0", STR_PAD_LEFT); ?></td>
<td><?php echo str_pad($v['fim'], 5, "0", STR_PAD_LEFT); ?></td>
<td><?php echo str_pad($v['base_cep'], 8, "0", STR_PAD_LEFT); ?></td>
<td>
<a href="admin.php?page=loja5-woo-correios-faixas&pg=<?php echo $pagina;?>&acao=valores&id=<?php echo $v['id']; ?>" class="button button-primary">Valores</a>
<a class="button" onclick="edita_faixa('<?php echo $v['id']; ?>')" style="color: #ffffff; background-color: #ff9800;border-color: #d68f26;">Editar</a>
<?php if($v['custom']){ ?>
<a class="button" onclick="return confirm('Confirma remover a faixa selecionada?')" href="admin.php?page=loja5-woo-correios-faixas&pg=<?php echo $pagina;?>&acao=remover&id=<?php echo $v['id']; ?>" style="color: #ffffff; background-color: #ff5722;border-color: #bd443c;">Excluir</a>
<?php } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>

<?php if($total > 0){ ?>
<div class="tablenav">
<div class="tablenav-pages" style="margin: 1em 0">
<?php echo $total; ?> Registros - <?php echo ($page_links)?$page_links:'';?>
</div>
</div>
<?php } ?>

</div>

<script>
function adicionar_faixa(){
	jQuery.pgwModal({
		title : 'Nova Faixa',
		url: '<?php echo admin_url( 'admin-ajax.php' );?>?action=loja5_woo_correios_adicionar_faixa_form&pg=<?php echo $pagina;?>',
		loadingContent: '<span style="text-align:center">Aguarde o processamento...</span>',
		closable: true,
		maxWidth: 600,
		titleBar: true
	});
	jQuery.pgwModal('reposition');
}

function edita_faixa(id){
	jQuery.pgwModal({
		title : 'Editar Faixa',
		url: '<?php echo admin_url( 'admin-ajax.php' );?>?action=loja5_woo_correios_editar_faixa_form&pg=<?php echo $pagina;?>&id='+id,
		loadingContent: '<span style="text-align:center">Aguarde o processamento...</span>',
		closable: true,
		maxWidth: 600,
		titleBar: true
	});
	jQuery.pgwModal('reposition');
}

function pequisar_cep(){
	var cep = jQuery('#cep-pesquisa').val();
	var url = 'admin.php?page=loja5-woo-correios-faixas&cep='+cep.replace(/\D/g, '');
	location.href = url;
}

jQuery(document).bind('PgwModal::Close', function() {
    jQuery('#pgwModalBackdrop').remove();
	jQuery('#pgwModal').remove();
});
</script>