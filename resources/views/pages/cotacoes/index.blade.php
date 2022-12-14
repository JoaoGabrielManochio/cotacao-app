@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Cotações</span>
                    <a href="{{ route('cotacoes.create') }}" class="btn btn-sm btn-success">Nova Cotação</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('pages.cotacoes.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

