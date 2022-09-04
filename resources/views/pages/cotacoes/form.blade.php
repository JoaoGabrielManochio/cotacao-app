<div class="form-group row">
    <label for="moeda_origem" class="col-md-4 col-form-label text-md-right">Moeda de origem</label>
    <div class="col-md-6">
        <input id="moeda_origem" type="text" class="form-control" name="moeda_origem" value="BRL" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="moeda_destino" class="col-md-4 col-form-label text-md-right">Moeda de destino</label>
    <div class="col-md-6">
        <select name="moeda_destino" id="moeda_destino" class="form-control" required>
            <option value=""></option>
            @foreach ($moeda_destinos as $key => $moeda_destino)
                <option value="{{ $key }}">{{ $moeda_destino }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="valor_conversao" class="col-md-4 col-form-label text-md-right">Valor para conversão</label>
    <div class="col-md-6">
        <input id="valor_conversao" type="text" class="form-control" name="valor_conversao" value="{{ old('valor_conversao') }}" required autocomplete="valor_conversao" autofocus>
    </div>
</div>

<div class="form-group row">
    <label for="forma_pagamento" class="col-md-4 col-form-label text-md-right">Forma de pagamento</label>
    <div class="col-md-6">
        <select name="forma_pagamento" id="forma_pagamento" class="form-control" required>
            <option value=""></option>
            @foreach ($forma_pagamentos as $key => $forma_pagamento)
                <option value="{{ $key }}">{{ $forma_pagamento }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            Cadastrar
        </button>
    </div>
</div>