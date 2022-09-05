<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConfigRequest;
use App\Http\Requests\StoreCotacaoRequest;
use App\Repository\ConfigRepository;

class ConfigController extends Controller
{
    protected $configRepository;

    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs = $this->configRepository->show();

        $config = [];
        if (!empty($configs)) {
            $config = json_decode($configs['config'], true);
        }

        return view('pages.config.index')->with(
            compact(
                [
                    'config',
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
    public function store(StoreConfigRequest $request)
    {
        $input = [
            'taxa_boleto' => $request->config['taxa_boleto'],
            'taxa_cartao_credito' => $request->config['taxa_cartao_credito'],
            'taxa_menor_valor' => $request->config['taxa_menor_valor'],
            'taxa_maior_valor' => $request->config['taxa_maior_valor']
        ];

        $response = $this->configRepository->store($input);

        if (!$response['success']) {
            flash($response['message'], 'error');
            return back()->withInput();
        }

        flash($response['message'], 'success');
        return redirect()->route('config.index');
    }
}
