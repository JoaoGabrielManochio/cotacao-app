<?php

namespace App\DataTables;

use App\Models\Contato;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class ContatoDataTable extends DataTable
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
            ->editColumn('nome', function($contato) {
                return $contato->nome;
            })
            ->editColumn('idade', function($contato) {
                return $contato->idade ?? ' - ';
            })
            ->editColumn('telefone', function($contato) {

                $telefones = '';
                foreach ($contato->telefones as $telefone) {
                    $telefones .= $telefone->numero . '</br>';
                }

                return $telefones;
            })
            ->editColumn('created_at', function($contato) {
                return $contato->created_at->format('d/m/Y H:i:s');
            })
            ->filterColumn('telefone', function ($query, $keyword) {
                $query->whereRaw("telefones.numero LIKE '%" . $keyword . "%'");
            })
            ->addColumn('action', 'pages.contatos.actions')
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Contato $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Contato::query()
            ->select(
                [
                    DB::raw('null as telefone'),
                    'contatos.nome',
                    'contatos.idade',
                    'contatos.created_at',
                    'contatos.id'
                ]
            )
            ->join('telefones', 'telefones.contato_id', 'contatos.id')
            ->groupBy('telefones.contato_id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('contatos-table')
            ->columns($this->getColumns())
            ->parameters(['autoWidth' => true])
            ->addAction(['title' => 'Ações', 'class' => 'text-center'])
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
            'nome' => [
                'title' => 'Nome',
                'class' => 'text-center'
            ],
            'idade' => [
                'title' => 'Idade',
                'class' => 'text-center'
            ],
            'telefone' => [
                'title' => 'Telefone',
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
        return 'Contatos_' . date('YmdHis');
    }
}
