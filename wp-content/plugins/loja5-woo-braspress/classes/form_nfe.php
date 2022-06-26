<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="braspress_nota_fiscal">
	<fieldset>
		<label for="braspress_nota_fiscal">
		<?php esc_html_e( 'Nota Fiscal', 'loja5-woo-braspress' ); ?>
		</label>
		<br>
		<select id="braspress_enviar_email" name="braspress_enviar_email">
		<option value="0"<?php echo ($email)?' selected':'';?>>N&atildeo enviar e-mail</option>
		<option value="1"<?php echo (!$email)?' selected':'';?>>Enviar e-mail ao cliente</option>
		</select>
		<br>
		<input type="text" id="braspress_nota_fiscal" name="braspress_nota_fiscal" value="<?php echo $notas;?>">
		<button class="button"><?php esc_html_e( 'Salvar', 'loja5-woo-braspress' ); ?></button>
		<br>
		<i><?php esc_html_e( 'Para mais de uma nota fiscal as separe usando virgula. Ex: 12345,67890', 'loja5-woo-braspress' ); ?></i>
	</fieldset>
</div>
