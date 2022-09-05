<?php

namespace App\Http\Controllers;

use App\DataTables\CotacaoDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCotacaoRequest;
use App\Repository\CotacaoRepository;

class CotacaoController extends Controller
{
    protected $cotacaoRepository;

    public function __construct(CotacaoRepository $cotacaoRepository)
    {
        $this->cotacaoRepository = $cotacaoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CotacaoDataTable $dataTable)
    {
        return $dataTable->render('pages.cotacoes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forma_pagamentos = [
            'boleto' => 'Boleto',
            'cartao_credito' => 'Cartão de Crédito'
        ];

        $moeda_destinos = [
            'USD' => 'USD',
            'JPY' => 'JPY',
            'EUR' => 'EUR',
            'BTC' => 'BTC'
        ];

        return view('pages.cotacoes.create')->with(
            compact(
                [
                    'forma_pagamentos',
                    'moeda_destinos'
                ]
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCotacaoRequest $request)
    {
        $input = [
            'moeda_origem' => $request->moeda_origem,
            'moeda_destino' => $request->moeda_destino,
            'valor_conversao' => $request->valor_conversao,
            'forma_pagamento' => $request->forma_pagamento
        ];

        $response = $this->cotacaoRepository->store($input);

        if (!$response['success']) {
            flash($response['message'], 'error');
            return back()->withInput();
        }

        flash($response['message'], 'success');
        return redirect()->route('cotacoes.index');
    }
}
