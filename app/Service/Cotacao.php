<?php

namespace App\Service;

use Exception;
use Illuminate\Support\Facades\Http;

class Cotacao
{
    private $url_api;

    public function __construct()
    {
        $this->url_api = 'https://economia.awesomeapi.com.br';
    }

    public function callApi(string $metodo_url, string $metodo_tipo, array $params = [])
    {
        try {
            $url = $this->url_api . $metodo_url;

            $result = Http::timeout(20)->{$metodo_tipo}($url);

            if (!$result->successful()) {
                return [
                    'success' => false,
                    'message' => $result->throw()->json(),
                    'response' => []
                ];
            }

            return [
                'success' => true,
                'message' => '',
                'response' => $result->json()
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'response' => []
            ];
        }
    }
}