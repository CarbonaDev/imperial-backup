<fieldset>
	<div class="rastreamento_braspress">
	<h3><?php esc_html_e( 'Rastreamento', 'loja5-woo-braspress' ); ?></h3>
	<i><?php esc_html_e( 'Para acompanhar e visualizar a situação do envio de seu pedido junto a transportadora basta apenas clicar abaixo no número da nota fiscal correspondente ao mesmo.', 'loja5-woo-braspress' ); ?></i>
	<br><br>
	<b><?php esc_html_e( 'Nota(s)', 'loja5-woo-braspress' ); ?>:</b> <?php echo implode(', ',$links_notas);?>
	</div>
</fieldset>