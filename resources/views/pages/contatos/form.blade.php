<div class="form-group row">
    <label for="nome" class="col-md-4 col-form-label text-md-right">Nome</label>
    <div class="col-md-6">
        <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ !empty($contato) ? $contato->nome : old('nome') }}" required autocomplete="nome" autofocus>

        @error('nome')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="idade" class="col-md-4 col-form-label text-md-right">Idade</label>
    <div class="col-md-6">
        <input id="idade" type="text" class="form-control" name="idade" value="{{ !empty($contato) ? $contato->idade : old('idade') }}" required autocomplete="idade" autofocus>
    </div>
</div>

<div class="form-group row">
    <label for="telefone" class="col-md-4 col-form-label text-md-right">Telefone</label>
    <div class="col-md-6">

        @if (!empty($contato->telefones))
            @php
                $row = 0;
            @endphp
            @foreach ($contato->telefones as $telefone)
                <button type="button" class="iconeExpandeEncolhe{{ $row }} btn btn-default btn-xs pull-right"
                        onclick="expandeTelefone('iconeExpandeEncolhe{{ $row }}', '{{ $row }}');">
                    <i class="fa fa-minus"></i>
                </button>
                <input id="telefone{{ $row }}" type="text" class="form-control col-md-6 @error('telefone') is-invalid @enderror" name="telefone[]" value="{{ $telefone->numero }}"/>
                </br>

                @php
                    $row++;
                @endphp
            @endforeach
            <button type="button" class="iconeExpandeEncolhe{{ $row }} btn btn-default btn-xs pull-right"
                    onclick="expandeTelefone('iconeExpandeEncolhe{{ $row }}', '{{ $row }}');">
                <i class="fa fa-plus"></i>
            </button>
            <input id="telefone{{ $row }}" type="text" class="form-control col-md-6" name="telefone[]"/>

            @php
                $row++;
            @endphp
        @else
            <button type="button" class="iconeExpandeEncolhe0 btn btn-default btn-xs pull-right"
                    onclick="expandeTelefone('iconeExpandeEncolhe0', '0');">
                <i class="fa fa-plus"></i>
            </button>

            <input id="telefone0" type="text" class="form-control col-md-6 @error('telefone') is-invalid @enderror" name="telefone[]"/>
            @error('telefone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @endif

    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary">
            {{ !empty($contato) ? 'Salvar' : 'Cadastrar' }}
        </button>
    </div>
</div>

<script>

    var row = '{{$row}}' > 0 ? '{{$row}}' : 1;

    function expandeTelefone(btn, linha) {

        if ($('.' + btn + ' > i').hasClass('fa-minus')) {
            $('.' + btn).remove();
            $('#telefone' + linha).remove();
        } else {
            let param = "'iconeExpandeEncolhe" + row + "'";

            let html =  '</br>';
            html +=     '<button type="button" class="iconeExpandeEncolhe' + row + ' btn btn-default btn-xs pull-right" onclick="expandeTelefone(' + param + ', ' + row + ');">'
            html +=         '<i class="fa fa-plus"></i>';
            html +=     '</button>';
            html +=     '<input id="telefone' + row + '" type="text" class="form-control col-md-6" name="telefone[' + row + ']" />';

            $(html).insertAfter('#telefone' + linha);
        }

        alteraIcone(linha);

        row++;
    }

    function alteraIcone(linha) {

        if ($('.iconeExpandeEncolhe' + linha + ' > i').hasClass('fa-minus')) {
            $('.iconeExpandeEncolhe' + linha + ' > i').removeClass('fa-minus');
            $('.iconeExpandeEncolhe' + linha + ' > i').addClass('fa-plus');
        } else {
            $('.iconeExpandeEncolhe' + linha + ' > i').removeClass('fa-plus');
            $('.iconeExpandeEncolhe' + linha + ' > i').addClass('fa-minus');
        }
    }

</script>
