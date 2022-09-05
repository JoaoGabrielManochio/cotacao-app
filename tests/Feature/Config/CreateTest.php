<?php

namespace Tests\Feature\Config;

use App\Repository\ConfigRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
     /**
     *
     * @return void
     */
    public function testShouldCreateNewConfig()
    {
        $repository = app(ConfigRepository::class);

        $input = [
            'taxa_boleto' => 10,
            'taxa_cartao_credito' => 11,
            'taxa_menor_valor' => 12,
            'taxa_maior_valor' => 1
        ];

        $response = $repository->store($input);

        $this->assertTrue($response['success']);
    }

     /**
     *
     * @return void
     */
    public function testShouldNotCreateNewCotacao()
    {
        $repository = app(ConfigRepository::class);

        // Taxa do boleto negativa
        $input = [
            'taxa_boleto' => -1,
            'taxa_cartao_credito' => 11,
            'taxa_menor_valor' => 12,
            'taxa_maior_valor' => 1
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo taxa para boleto precisa ser maior que 0', $response['message']);

        // Taxa do cartão de crédito negativa
        $input = [
            'taxa_boleto' => 0,
            'taxa_cartao_credito' => -1,
            'taxa_menor_valor' => 12,
            'taxa_maior_valor' => 1
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo taxa para cartão de crédito precisa ser maior que 0', $response['message']);

        // Taxa do menor valor negativa
        $input = [
            'taxa_boleto' => 0,
            'taxa_cartao_credito' => 1,
            'taxa_menor_valor' => -12,
            'taxa_maior_valor' => 1
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo taxa para valor menor que R$3000,00 precisa ser maior que 0', $response['message']);

         // Taxa do maior valor negativa
         $input = [
            'taxa_boleto' => 0,
            'taxa_cartao_credito' => 1,
            'taxa_menor_valor' => 12,
            'taxa_maior_valor' => -1
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo taxa para valor maior que R$3000,00 precisa ser maior que 0', $response['message']);
    }
}
