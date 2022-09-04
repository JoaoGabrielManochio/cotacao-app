<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCotacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'moeda_origem' => ['required'],
            'moeda_destino'   => ['required'],
            'valor_conversao' => ['required'],
            'forma_pagamento' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'moeda_origem.required'   => 'É necessário a moeda de origem',
            'moeda_destino.required'   => 'É necessário a moeda de destino',
            'valor_conversao.required' => 'É necessário o valor de conversão',
            'forma_pagamento.required' => 'É necessário informar a forma de pagamento',
        ];
    }
}
