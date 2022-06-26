<?php 
//dados da faixa 
$linha = $wpdb->get_row( "SELECT * FROM correios_offline5_base WHERE id = '".(int)$_GET['id']."'", ARRAY_A );
//total 
$total = $wpdb->get_var( "SELECT COUNT(*) FROM correios_offline5_cotacoes WHERE 1=1 AND (cep_base = '".$linha['base_cep']."' OR cep_base = '".str_pad($linha['base_cep'], 8, "0", STR_PAD_LEFT)."') AND cliente = 0" );
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
$cotacoes = $wpdb->get_results( "SELECT b.titulo,a.* FROM correios_offline5_cotacoes AS a 
LEFT JOIN correios_offline5_tabelas AS b ON(b.id_servico=a.id_servico)
WHERE 1=1 AND (cep_base = '".$linha['base_cep']."' OR cep_base = '".str_pad($linha['base_cep'], 8, "0", STR_PAD_LEFT)."') AND cliente = 0 ORDER BY a.id_servico ASC, a.peso ASC, a.cep_base ASC, custom ASC LIMIT $inicio, $por_pagina", ARRAY_A );
?>

<div class="updated notice">
<p>
Lista de valores e prazos de entrega de acordo a faixa de CEP selecionada e servi&ccedil;os de entrega configurados e atualizados em sua loja para uso offline.
</p>
</div>

<div id="tela-faixas-offline" class="wrap">

<h1 class="wp-heading-inline">Valores <?php echo $linha['detalhes'];?>: <?php echo str_pad($linha['inicio'], 5, "0", STR_PAD_LEFT);?>~<?php echo str_pad($linha['fim'], 5, "0", STR_PAD_LEFT);?> (<?php echo str_pad($linha['base_cep'], 8, "0", STR_PAD_LEFT);?>)</h1>
<a class="page-title-action" href="admin.php?page=loja5-woo-correios-faixas&pg=<?php echo (int)$_GET['pg'];?>">Lista de Faixas</a>

<hr class="wp-header-end">

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th scope="col" style="width:60px;" class="manage-column">ID</th>
<th scope="col" class="manage-column">Servi&ccedil;o</th>
<th scope="col" style="width:60px;" class="manage-column">Erro</th>
<th scope="col" style="width:100px;" class="manage-column">Valor</th>
<th scope="col" style="width:100px;" class="manage-column">Prazo</th>
<th scope="col" style="width:100px;" class="manage-column">Peso</th>
<th scope="col" style="width:120px;" class="manage-column">CEP Inicio</th>
<th scope="col" style="width:120px;" class="manage-column">CEP Fim</th>
<th scope="col" style="width:120px;" class="manage-column">CEP Base</th>
<th scope="col" style="width:100px;" class="manage-column">Atualizado</th>
</tr>
</thead>
<tbody>
<?php 
foreach($cotacoes as $k => $v) {
?>
<tr>
<th><?php echo str_pad($v['id'], 5, "0", STR_PAD_LEFT); ?></th>
<td><?php echo str_pad($v['id_servico'], 5, "0", STR_PAD_LEFT); ?> - <?php echo $v['titulo']; ?></td>
<td><?php echo $v['erro']; ?></td>
<td><?php echo $v['valor']; ?></td>
<td><?php echo $v['prazo']; ?></td>
<td><?php echo $v['peso']; ?></td>
<td><?php echo str_pad($v['cep_inicio'], 5, "0", STR_PAD_LEFT); ?>000</td>
<td><?php echo str_pad($v['cep_fim'], 5, "0", STR_PAD_LEFT); ?>999</td>
<td><?php echo str_pad($v['cep_base'], 8, "0", STR_PAD_LEFT); ?></td>
<td><?php echo date('d/m/Y',strtotime($v['atualizado'])); ?></td>
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