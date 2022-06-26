<?php 
//total de faixas 
$total_faixas = $wpdb->get_var( "SELECT COUNT(*) FROM correios_offline5_base" );
//listagem
$tabelas = $wpdb->get_results( "SELECT (SELECT COUNT(*) FROM correios_offline5_cotacoes AS a WHERE a.id_servico=b.id_servico AND a.erro = 0 AND a.cliente=0) AS cotacoes_cadastradas,(SELECT COUNT(*) FROM correios_offline5_cotacoes AS a WHERE a.id_servico=b.id_servico AND a.erro = 0 AND a.cliente=1) AS cotacoes_clientes,b.* FROM correios_offline5_tabelas AS b WHERE 1=1 ORDER BY b.titulo ASC", ARRAY_A );
?>

<div class="updated notice">
<p>
Lista de servi&ccedil;os Correios dispon&iacute;veis para uso em modo offline, mantenha as tabelas atualizadas para um melhor funcionamento, e lembre-se que os valores s&atilde;o estimados onde dependendo da faixa poder&aacute; ocorrer varia&ccedil;&otilde;es no mesmo.
</p>
</div>

<div id="tela-faixas-offline" class="wrap">

<h1 class="wp-heading-inline">Tabela de Servi&ccedil;os Dispon&iacute;veis para uso Offline</h1>

<hr class="wp-header-end">

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
<th scope="col" style="width:60px;" class="manage-column">ID</th>
<th scope="col" class="manage-column">Servi&ccedil;o</th>
<th scope="col" class="manage-column">Titulo</th>
<th scope="col" style="width:100px;" class="manage-column">Faixas</th>
<th scope="col" style="width:100px;" class="manage-column">Cota&ccedil;&otilde;es</th>
<!--<th scope="col" style="width:100px;" class="manage-column">Cota&ccedil;&otilde;es Clientes</th>-->
<th scope="col" style="width:100px;" class="manage-column">Atualizado</th>
<th scope="col" style="width:10%"></th>
</tr>
</thead>
<tbody>
<?php 
foreach($tabelas as $k => $v) {
?>
<tr>
<th><?php echo str_pad($v['id'], 5, "0", STR_PAD_LEFT); ?></th>
<td><?php echo str_pad($v['id_servico'], 5, "0", STR_PAD_LEFT); ?></td>
<td><?php echo $v['titulo']; ?></td>
<td><?php echo $total_faixas; ?></td>
<td><?php echo $v['cotacoes_cadastradas']?>/<?php echo $total_faixas*30; ?></td>
<!--<td><?php echo $v['cotacoes_clientes']?></td>-->
<td><?php echo date('d/m/Y',strtotime($v['atualizado'])); ?></td>
<td>
<a href="admin.php?page=loja5-woo-correios-tabelas&acao=atualizar&id=<?php echo $v['id']; ?>&servico=<?php echo $v['id_servico']; ?>" class="button button-primary">Atualizar</a>
<a onclick="return confirm('Confirma limpar todos os registros da tabela selecionada?')" href="admin.php?page=loja5-woo-correios-tabelas&acao=limpar&id=<?php echo $v['id']; ?>&servico=<?php echo $v['id_servico']; ?>" class="button" style="color: #ffffff; background-color: #ff5722;border-color: #bd443c;">Limpar</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>

</div>