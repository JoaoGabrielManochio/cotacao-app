<div class="form-group row">
    <label for="taxa_boleto" class="col-md-4 col-form-label text-md-right">Taxa para boleto</label>
    <div class="col-md-6">
        <input id="taxa_boleto" type="number" step="0.01" class="form-control" name="config[taxa_boleto]" value="{{ $config['taxa_boleto'] ?? old('taxa_boleto') }}" required autofocus>
    </div>
</div>

<div class="form-group row">
    <label for="taxa_cartao_credito" class="col-md-4 col-form-label text-md-right">Taxa para cartão de crédito</label>
    <div class="col-md-6">
        <input id="taxa_cartao_credito" type="number" step="0.01" class="form-control" name="config[taxa_cartao_credito]" value="{{ $config['taxa_cartao_credito'] ?? old('taxa_cartao_credito') }}" required autofocus>
    </div>
</div>

<div class="form-group row">
    <label for="taxa_menor_valor" class="col-md-4 col-form-label text-md-right">Taxa para valor menor que R$3000,00</label>
    <div class="col-md-6">
        <input id="taxa_menor_valor" type="number" step="0.01" class="form-control" name="config[taxa_menor_valor]" value="{{ $config['taxa_menor_valor'] ?? old('taxa_menor_valor') }}" required autofocus>
    </div>
</div>

<div class="form-group row">
    <label for="taxa_maior_valor" class="col-md-4 col-form-label text-md-right">Taxa para valor menor que R$3000,00</label>
    <div class="col-md-6">
        <input id="taxa_maior_valor" type="number" step="0.01" class="form-control" name="config[taxa_maior_valor]" value="{{ $config['taxa_maior_valor'] ?? old('taxa_maior_valor') }}" required autofocus>
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            Salvar
        </button>
    </div>
</div>