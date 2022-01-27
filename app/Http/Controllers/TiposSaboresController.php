<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TiposSaboresFormRequest;

use App\Models\TiposSabores;
use App\Models\Sabores;

class TiposSaboresController extends Controller
{
    // Retorna todos os tipos de sabores
    public function show($tipoSabor = NULL) {
        $tipos = TiposSabores::all(['id', 'nome', 'opcional']);

        foreach ($tipos as $key => $item) {
            if ($item['opcional'] == 1) {
                $item['opcional'] = true;
            } else {
                $item['opcional'] = false;
            }
        }

        foreach($tipos as $key => $value) {
            $tipos[$key]['qtd_itens'] = Sabores::where('id_tipos_sabores', $value->id)->count();
        }

        return response()->json($tipos, 200);
    }

    // Adiciona um tipo de sabor
    public function store(TiposSaboresFormRequest $request) {
        $tipo = new TiposSabores;

        if (TiposSabores::where('nome', $request->nome)->first() == false) 
        {
            $tipo->nome = mb_strtolower(trim($request->nome, 'UTF-8'));
            $tipo->opcional = $request->opcional;
            
            if ($tipo->save()) {
                return retornoJson(true, [['Item adicionado com sucesso!']]);
            } else {
                return retornoJson(false, [['Erro ao adicionar o item.']]);
            }
        } else {
            return retornoJson(false, ['nome' => ['Já existe um item com o mesmo nome.']], true);
        }
    }

    // Edita um tipo de sabor
    public function edit(TiposSaboresFormRequest $request, $id) {
        $tipo = TiposSabores::where('id', $id)->firstOrFail();

        if (TiposSabores::where('nome', $request->nome)->first() == false) 
        {
            $update = $tipo->update([
                'nome' => mb_strtolower(trim($request->nome, 'UTF-8')), 
            ]);
        } else {
            $retorno = retornoJson(false, ['nome' => ['Já existe um item com o mesmo nome.']], true);
        }

        if ($request->opcional != $tipo->opcional) 
        {
            $update = $tipo->update([
                'opcional' => $request->opcional
            ]);
        }

        if ($update) {
            return retornoJson(true, [['Item editado com sucesso!']]);
        } else {
            return $retorno;
        }
    }

    // Exclui um tipo de sabor especificado
    public function destroy($id) {
        $tipo = TiposSabores::where('id', $id)->firstOrFail();

        if ($tipo->delete()) {
            return retornoJson(true, [['Item excluído com sucesso!']]);
        } else {
            return retornoJson(false, [['Erro ao excluir o item.']]);
        }
    }
}

// Retorno padrão
function retornoJson ($tipo, $msg, $campos = false) {
    return response()->json([
        'sucesso' => $tipo,
        'mensagens' => $msg,
        'campos' => $campos
    ], 200);
}