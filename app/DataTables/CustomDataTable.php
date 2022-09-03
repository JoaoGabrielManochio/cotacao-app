<?php
namespace App\DataTables;

use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\Config;

class CustomDataTable extends DataTable
{
    private $export_extension = null;

    public function snappyPdf()
    {
        /** @var \Barryvdh\Snappy\PdfWrapper $snappy */
        $snappy = app('snappy.pdf.wrapper');

        $options = Config::get('datatables.snappy.options', [
            'no-outline' => true,
            'margin-left' => '0',
            'margin-right' => '0',
            'margin-top' => '10mm',
            'margin-bottom' => '10mm',
        ]);
        $orientation = Config::get('datatables.snappy.orientation', 'landscape');

        $snappy->setOptions($options)
            ->setOrientation($orientation)
            ->setTimeOut(3600);

        return $snappy->loadHTML($this->printPreview())
            ->download($this->getFilename() . ".pdf");
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {

    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {

    }

    protected function getAjaxResponseData()
    {
        ini_set('memory_limit','256M');

        $limit = -1;

        $getData = $this->ajax()->getData(true);

        $qtd_registros = $getData['recordsTotal'];

        if ($qtd_registros > 20000) {
            flash('Os resultados exportados são de ' .
                  number_format($qtd_registros, 0, ',', '.') .
                  ', portanto são maiores que o limite de 20 mil linhas para exportação via grid,
                 logo foi limitado à este total, ajuste os filtros para gerar uma quantidade menor ou solicite um relatório para gerar em background', 'warning');
            $limit = 20000;
        }
        $this->datatables->getRequest()->merge(['length' => $limit]);

        $response = $this->ajax();
        $data     = $response->getData(true);

        return $data['data'];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {

    }
}
