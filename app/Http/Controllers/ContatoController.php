<?php

namespace App\Http\Controllers;

use App\DataTables\ContatoDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContatoRequest;
use App\Http\Requests\UpdateContatoRequest;
use App\Models\Contato;
use App\Repository\ContatoRepository;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    protected $contatoRepository;

    public function __construct(ContatoRepository $contatoRepository)
    {
        $this->contatoRepository = $contatoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContatoDataTable $dataTable)
    {
        return $dataTable->render('pages.contatos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $row = 0;

        return view('pages.contatos.create')->with(compact([
            'row'
        ]));;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContatoRequest $request)
    {
        $response = $this->contatoRepository->store();

        if (!$response['success']) {
            flash($response['message'], 'error');
            return back()->withInput();
        }

        flash($response['message'], 'success');
        return redirect()->route('contatos.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contato = $this->contatoRepository->show($id);

        if (!$contato) {
            flash('Contato não encontrato', 'error');
            return redirect()->route('contatos.index');
        }

        return view('pages.contatos.edit')->with(compact([
            'contato'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContatoRequest $request, $id)
    {
        $response = $this->contatoRepository->update($id);

        if (!$response['success']) {
            flash($response['message'], 'error');
            return redirect()->route('contatos.index')->withInput();
        }

        flash($response['message'], 'success');
        return redirect()->route('contatos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->contatoRepository->destroy($id);

        if (!$response['success']) {
            flash($response['message'], 'error');
            return redirect()->route('contatos.index')->withInput();
        }

        flash($response['message'], 'success');
        return redirect()->route('contatos.index');

        return redirect()->route('contatos.index');
    }
}
