<?php

namespace App\Repository;

use App\Models\Cotacao;
use App\Models\Telefone;
use App\Service\Cotacao as ServiceCotacao;

class CotacaoRepository {

    public function store($request) : array
    {
        $tem_erro = $this->validate($request);

        if ($tem_erro) {
            return [
                'success' => false,
                'message' => $tem_erro,
            ];
        }

        $response = $this->callApi();

        if (!empty($response['message'])) {
            return [
                'success' => false,
                'message' => $response['message'],
            ];
        }

        $result_api = $response['response'][request('moeda_destino') . request('moeda_origem')] ?? [];

        if ($result_api) {

            $cotacao = Cotacao::create($this->fields($result_api));

            if ($cotacao) {
                return [
                    'success' => true,
                    'message' => 'Cotação criado com sucesso!',
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Ocorreu uma instabilidade, tente novamente',
        ];
    }

    private function callApi() : array
    {
        $cotacao_api = new ServiceCotacao();

        $moeda_destino = request('moeda_destino');
        $moeda_origem = request('moeda_origem');

        $motodo_url = '/last/' . $moeda_destino .'-' . $moeda_origem;

        $response = $cotacao_api->callApi($motodo_url, 'get');

        return $response;

    }

    private function fields(array $result_api) : array
    {
        $forma_pagamento = request('forma_pagamento');
        $valor_conversao = request('valor_conversao');
        $pctm_pagamento = $forma_pagamento == 'boleto' ? 1.45 : 7.63;
        $pctm_conversao = $valor_conversao < 3000 ? 2 : 1;

        $taxa_pagamento = $valor_conversao / 100 * $pctm_pagamento;
        $taxa_conversao = $valor_conversao / 100 * $pctm_conversao;

        $valor_convertido_pos_taxa = $valor_conversao - $taxa_pagamento - $taxa_conversao;

        $valor_comprado_moeda_destino = round($valor_convertido_pos_taxa / $result_api['bid'], 2);

        $fields = [
            'moeda_destino' => request('moeda_destino'),
            'moeda_origem'  => request('moeda_origem'),
            'valor_conversao' => $valor_conversao,
            'forma_pagamento' => $forma_pagamento,
            'valor_moeda_destino' => round($result_api['bid'], 2),
            'taxa_pagamento' => $taxa_pagamento,
            'taxa_conversao' => $taxa_conversao,
            'valor_convertido_pos_taxa' => $valor_convertido_pos_taxa,
            'valor_comprado_moeda_destino' => $valor_comprado_moeda_destino
        ];

        return $fields;
    }

    private function validate($request) : string
    {
        if (empty($request->moeda_destino)) {
            return 'O campo Moeda de destino precisa ser preenchido';
        }

        if (empty($request->valor_conversao)) {
            return 'O campo valor de conversão precisa ser preenchido';
        }

        if ($request->valor_conversao < 1000 ) {
            return 'O campo valor de conversão precisa ser maior que R$1000.00';
        }

        if ($request->valor_conversao > 100000) {
            return 'O campo valor de conversão precisa ser menor que R$100000.00';
        }

        if (empty($request->forma_pagamento)) {
            return 'O campo forma de pagamento precisa ser preenchido';
        }

        return '';
    }
}
