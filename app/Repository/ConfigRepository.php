<?php

namespace App\Repository;

use App\Models\Config;
use App\Models\Cotacao;

class ConfigRepository {


    public function show() : array
    {
        $config = Config::first();

        if (!$config) {
            return [];
        }

        return $config->toArray();
    }

    public function store(array $request) : array
    {
        $tem_erro = $this->validate($request);

        if ($tem_erro) {
            return [
                'success' => false,
                'message' => $tem_erro,
            ];
        }

        $config = Config::updateOrCreate(
            $this->fieldsUpdate(),
            $this->fields($request)
        );

        if ($config) {
            return [
                'success' => true,
                'message' => 'Configuração salva com sucesso!',
            ];
        }

        return [
            'success' => false,
            'message' => 'Ocorreu uma instabilidade, tente novamente',
        ];
    }

    private function fields($request) : array
    {
        $fields = [
            'config' => json_encode($request)
        ];

        return $fields;
    }

    private function fieldsUpdate() : array
    {
        $tem_config = $this->show();

        if (!$tem_config) {
            return [];
        }

        $fields = [
            'id' => $tem_config['id']
        ];

        return $fields;
    }

    private function validate(array $request) : string
    {
        if ($request['taxa_boleto'] < 0) {
            return 'O campo taxa para boleto precisa ser maior que 0';
        }

        if ($request['taxa_cartao_credito'] < 0) {
            return 'O campo taxa para cartão de crédito precisa ser maior que 0';
        }

        if ($request['taxa_menor_valor'] < 0) {
            return 'O campo taxa para valor menor que R$3000,00 precisa ser maior que 0';
        }

        if ($request['taxa_maior_valor'] < 0) {
            return 'O campo taxa para valor maior que R$3000,00 precisa ser maior que 0';
        }

        return '';
    }
}
