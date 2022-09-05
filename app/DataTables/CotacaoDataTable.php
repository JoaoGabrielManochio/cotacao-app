<?php

namespace App\DataTables;

use App\Models\Cotacao;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class CotacaoDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('forma_pagamento', function($cotacao) {

                switch ($cotacao->forma_pagamento) {
                    case 'boleto':
                        $format = 'Boleto';
                        break;
                    case 'cartao_credito':
                        $format = 'Cartão de Crédito';
                        break;
                }

                return $format;
            })
            ->editColumn('valor_conversao', function($cotacao) {
                return 'R$' . $cotacao->valor_conversao;
            })
            ->editColumn('taxa_pagamento', function($cotacao) {
                return 'R$' . $cotacao->taxa_pagamento;
            })
            ->editColumn('taxa_conversao', function($cotacao) {
                return 'R$' . $cotacao->taxa_conversao;
            })
            ->editColumn('valor_convertido_pos_taxa', function($cotacao) {
                return 'R$' . $cotacao->valor_convertido_pos_taxa;
            })
            ->editColumn('valor_moeda_destino', function($cotacao) {
                $format = '';
                switch ($cotacao->moeda_destino) {

                    case 'USD':
                        $format = '$';
                        break;
                    case 'JPY':
                        $format = '¥';
                        break;
                    case 'EUR':
                        $format = '€';
                        break;
                    case 'BTC':
                        $format = '₿';
                        break;
                }
                return $format . $cotacao->valor_moeda_destino;
            })
            ->editColumn('valor_comprado_moeda_destino', function($cotacao) {

                $format = '';
                switch ($cotacao->moeda_destino) {

                    case 'USD':
                        $format = '$';
                        break;
                    case 'JPY':
                        $format = '¥';
                        break;
                    case 'EUR':
                        $format = '€';
                        break;
                    case 'BTC':
                        $format = '₿';
                        break;
                }
                return $format . $cotacao->valor_comprado_moeda_destino;
            })
            ->editColumn('created_at', function($cotacao) {
                return $cotacao->created_at->format('d/m/Y H:i:s');
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Cotacao $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Cotacao::query()
            ->select(
                [
                    'cotacoes.moeda_origem',
                    'cotacoes.moeda_destino',
                    'cotacoes.valor_conversao',
                    'cotacoes.forma_pagamento',
                    'cotacoes.valor_moeda_destino',
                    'cotacoes.valor_comprado_moeda_destino',
                    'cotacoes.taxa_pagamento',
                    'cotacoes.taxa_conversao',
                    'cotacoes.valor_convertido_pos_taxa',
                    'cotacoes.created_at',
                    'cotacoes.id'
                ]
            );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('cotacaos-table')
            ->columns($this->getColumns())
            ->parameters(
                [
                    'autoWidth' => true,
                    'responsive' => true
                ]
            )
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(1)
            ->language('//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese-Brasil.json');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'moeda_origem' => [
                'title' => 'Moeda de origem',
                'class' => 'text-center'
            ],
            'moeda_destino' => [
                'title' => 'Moeda de destino',
                'class' => 'text-center'
            ],
            'valor_conversao' => [
                'title' => 'Valor conversão',
                'class' => 'text-center'
            ],
            'forma_pagamento' => [
                'title' => 'Pagamento',
                'class' => 'text-center'
            ],
            'valor_moeda_destino' => [
                'title' => 'Valor moeda destino',
                'class' => 'text-center'
            ],
            'valor_comprado_moeda_destino' => [
                'title' => 'Valor comprado',
                'class' => 'text-center'
            ],
            'taxa_pagamento' => [
                'title' => 'Taxa de pagamento',
                'class' => 'text-center'
            ],
            'taxa_conversao' => [
                'title' => 'Taxa de conversão',
                'class' => 'text-center'
            ],
            'valor_convertido_pos_taxa' => [
                'title' => 'Valor Pós Taxa',
                'class' => 'text-center'
            ],
            'created_at' => [
                'title' => 'Criado em',
                'class' => 'text-center'
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Cotações_' . date('YmdHis');
    }
}
