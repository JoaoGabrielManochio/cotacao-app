<?php

namespace Tests\Feature\Cotacao;

use App\Repository\CotacaoRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testShouldCreateNewCotacaoWithBoleto()
    {
        $repository = app(CotacaoRepository::class);

        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'valor_conversao' => 1000,
            'forma_pagamento' => 'boleto',
            'moeda_origem' => 'BRL',
        ];

        $response = $repository->store($input);

        $this->assertTrue($response['success']);
    }

     /**
     *
     * @return void
     */
    public function testShouldCreateNewCotacaoWithCartaoCredito()
    {
        $repository = app(CotacaoRepository::class);

        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'valor_conversao' => 1000,
            'forma_pagamento' => 'cartao_credito',
            'moeda_origem' => 'BRL',
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
        $repository = app(CotacaoRepository::class);

        // Valor de conversão maior que R$100000,00
        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'valor_conversao' => 100001,
            'forma_pagamento' => 'cartao_credito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo valor de conversão precisa ser menor que R$100000.00', $response['message']);

        // Valor de conversão menor que R$1000,00
        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'valor_conversao' => 999,
            'forma_pagamento' => 'cartao_credito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo valor de conversão precisa ser maior que R$1000.00', $response['message']);
    }

     /**
     *
     * @return void
     */
    public function testShouldNotCreateNewCotacaoWithEmptyInputs()
    {
        $repository = app(CotacaoRepository::class);

        // Sem moeda de origem no input
        $input = [
            'moeda_destino' => 'USD',
            'valor_conversao' => 100001,
            'forma_pagamento' => 'cartao_credito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo moeda de origem precisa ser preenchido', $response['message']);

        // Sem moeda de destino no input
        $input = [
            'moeda_origem' => 'BRL',
            'valor_conversao' => 999,
            'forma_pagamento' => 'cartao_credito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo moeda de destino precisa ser preenchido', $response['message']);

        // Sem valor de conversão no input
        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'forma_pagamento' => 'cartao_credito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo valor de conversão precisa ser preenchido', $response['message']);

        // Sem forma de pagamento no input
        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'valor_conversao' => 1000,
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('O campo forma de pagamento precisa ser preenchido', $response['message']);
    }

     /**
     *
     * @return void
     */
    public function testShouldNotCreateNewCotacaoWhenInputNotExists()
    {
        $repository = app(CotacaoRepository::class);

        // Moeda de origem inexistente
        $input = [
            'moeda_origem' => 'USD',
            'moeda_destino' => 'USD',
            'valor_conversao' => 10000,
            'forma_pagamento' => 'cartao_credito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('Moeda de origem não permitida', $response['message']);

        // Moeda de destino inexistente
        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'BRL',
            'valor_conversao' => 10000,
            'forma_pagamento' => 'boleto',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('Moeda de destino não permitida', $response['message']);

        // Forma de pagamento inexistente
        $input = [
            'moeda_origem' => 'BRL',
            'moeda_destino' => 'USD',
            'valor_conversao' => 10000,
            'forma_pagamento' => 'cartao_debito',
        ];

        $response = $repository->store($input);

        $this->assertFalse($response['success']);
        $this->assertEquals('Forma de pagamento não permitida', $response['message']);
    }
}
