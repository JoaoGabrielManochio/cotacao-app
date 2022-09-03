<?php

namespace App\Repository;

use App\Models\Contato;
use App\Models\Telefone;

class ContatoRepository {

    public function list()
    {
        return Contato::paginate(30);
    }

    public function show($id)
    {
        $contato = Contato::find($id);

        if (!$contato) {
            return false;
        }

        return $contato;
    }

    public function store()
    {
        $validate = $this->validate();

        if ($validate) {
            return [
                'success' => false,
                'message' => $validate,
            ];
        }

        $contato = Contato::create($this->fields());

        foreach (request('telefone') as $telefone) {

            $create = [
                'numero' => $telefone,
                'contato_id' => $contato->id
            ];

            Telefone::create($create);
        }

        return [
            'success' => true,
            'message' => 'Contato criado com sucesso!',
        ];
    }

    public function update($id)
    {

        $validate = $this->validate();

        if ($validate) {
            return [
                'success' => false,
                'message' => $validate,
            ];
        }

        $contato = $this->show($id);

        if (!$contato) {
            return [
                'success' => false,
                'message' => 'Contato não encontrato',
            ];
        }

        $contato->fill($this->fields());
        $contato->save();

        Telefone::where('contato_id', $contato->id)->forceDelete();

        foreach (request('telefone') as $telefone) {

            if ($telefone) {
                $create = [
                    'numero' => $telefone,
                    'contato_id' => $contato->id
                ];

                Telefone::create($create);
            }
        }

        return [
            'success' => true,
            'message' => 'Contato atualizado com sucesso!',
        ];
    }

    public function destroy($id)
    {
        $contato = $this->show($id);

        if (!$contato) {
            return [
                'success' => false,
                'message' => 'Contato não encontrato',
            ];
        }

        $remove_contato = $contato->delete();

        if ($remove_contato) {
            $this->geraArquivoLog($contato);

            return [
                'success' => true,
                'message' => 'Contato removido com sucesso!',
            ];
        }

        return [
            'success' => false,
            'message' => 'Ocorreu um erro inesperado ao remover o contato!',
        ];

    }

    private function fields()
    {
        $fields = [
            'nome' => request('nome'),
            'idade'  => request('idade')
        ];

        return $fields;
    }

    private function validate()
    {
        if (empty(request('nome'))) {
            return 'O campo nome precisa ser preenchido';
        }

        if (empty(request('telefone'))) {
            return 'O campo telefone precisa ser preenchido';
        }
    }

    public function geraArquivoLog(Contato $contato)
    {
        $path = 'public/logs';
        $file_name = $path . '/logs.txt';

        if (!is_dir($path)) {
            mkdir($path, 0777, false);
        }

        $file_handle = fopen($file_name, 'w');
        fwrite($file_handle, 'O contato com ID ' . $contato->id . ', ');
        fwrite($file_handle, ' e nome ' . $contato->nome . ' foi removido');
        fwrite($file_handle, "\n");
        fclose($file_handle);
    }
}
