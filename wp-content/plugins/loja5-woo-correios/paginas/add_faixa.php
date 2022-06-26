<style>
.form-group{
	margin: 2px;
}
.col-sm-3 {
	display: inline-table;
    width: 20%;
	font-weight: bold;
}
.col-sm-9 {
	display: inline-table;
    width: 70%;
}
.help-block {
	display: block;
    font-style: italic;
    font-size: 12px;
}
</style>

<div class="updated notice" role="alert">Adicione as faixas de cep de acordo deseja usar em sua loja, fique atento para n&atilde;o adicionar faixas duplicadas, lembrando que sempre que atualizar qualquer faixa de cep dever&aacute; atualizar as tabelas de frete.</div>

<div style="margin-left: 15px;">

<form id="form-add-correios-offline" method="post" action="admin.php?page=loja5-woo-correios-faixas&acao=salvar_add" class="form-horizontal">

<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">Estado (UF)</label>
<div class="col-sm-9">
<input style="width:50%" type="text" maxlength="2" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="uf" name="uf" placeholder="Ex: SP" required>
<span id="helpBlock" class="help-block">UF do estado correspondente a faixa de CEP.</span>
</div>
</div>

<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">Detalhes</label>
<div class="col-sm-9">
<input type="text" class="form-control" id="detalhes" name="detalhes" placeholder="Ex: Capital do estado X">
<span id="helpBlock" class="help-block">Detalhes da faixa.</span>
</div>
</div>

<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">CEP Inicial</label>
<div class="col-sm-9">
<div style="width:50%" class="input-group">
<input type="text" value="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="5" class="form-control" id="cep_inicio" name="cep_inicio" placeholder="Somente numeros!" required>
<span class="input-group-addon" id="basic-addon2">-000</span>
</div>
<span id="helpBlock" class="help-block">Os 5 digitos iniciais do CEP.</span>
</div>
</div>

<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">CEP Final</label>
<div class="col-sm-9">

<div style="width:50%" class="input-group">
<input type="text" value="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="5" class="form-control" id="cep_final" name="cep_final" placeholder="Somente numeros!" required>
<span class="input-group-addon" id="basic-addon2">-999</span>
</div>
<span id="helpBlock" class="help-block">Os 5 digitos iniciais do CEP.</span>

</div>
</div>
<div class="form-group">
<label for="inputEmail3" class="col-sm-3 control-label">CEP Base</label>
<div class="col-sm-9">
<input style="width:50%" type="text" value="" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="8" class="form-control" id="cep_base" name="cep_base" placeholder="Somente numeros!" required>
<span id="helpBlock" class="help-block">Este CEP ser&aacute; o base usado para calculo do frete junto aos correios para toda faixa.</span>
</div>
</div>
<div class="form-group">
<div class="col-sm-12" style="text-align: center;">
<button type="submit" class="button button-primary">Salvar Faixa</button>
</div>
</div>
</form>

</div>