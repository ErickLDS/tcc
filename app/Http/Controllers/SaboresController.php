<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaboresFormRequest;

use App\Models\Sabores;
use App\Models\TiposSabores;

class SaboresController extends Controller
{

    // Retorna os sabores através de um tipo especificado
    public function show($id) {
        $sabor = Sabores::all(['id', 'nome', 'adicional', 'id_tipos_sabores'])->where('id_tipos_sabores', $id);

        foreach ($sabor as $key => $item) {
            if ($item['adicional']) {
                $item['adicional'] = floatval($item['adicional']);
            }
        }

        return response()->json($sabor);
    }

    // Adiciona um sabor através de um tipo especificado
    public function store(SaboresFormRequest $request, $id) {
        if (Sabores::where(['nome' => $request->nome, 'id_tipos_sabores' => $id])->first() == false) 
        {
            $sabor = new Sabores;

            $sabor->id_tipos_sabores = $id;
            $sabor->nome = mb_strtolower(trim($request->nome, 'UTF-8'));

            if ($sabor->adicional && $sabor->adicional > 0) {
                $sabor->adicional = number_format($request->adicional, 2);
            } else {
                $sabor->adicional = $request->adicional;
            }
            
            if ($sabor->save()) {
                return retornoJson(true, [['Item adicionado com sucesso!']]);
            } else {
                return retornoJson(false, [['Erro ao adicionar o item.']]);
            }
        } else {
            return retornoJson(false, ['nome' => ['Já existe um item com o mesmo nome.']], true);
        }
    }

    // Edita um sabor através de um tipo especificado
    public function edit(SaboresFormRequest $request, $id) {
        $sabor = Sabores::where('id', $id)->firstOrFail();

        if (Sabores::where(['nome' => $request->nome, 'id_tipos_sabores' => $id])->first() == false) 
        {
            $update = $sabor->update([
                'nome' => mb_strtolower(trim($request->nome, 'UTF-8')), 
            ]);
        } else {
            $retorno = retornoJson(false, ['nome' => ['Já existe um item com o mesmo nome.']], true);
        }

        if ($request->adicional != $sabor->adicional) 
        {
            if ($request->adicional && $request->adicional > 0) {
                $request->adicional = number_format($request->adicional, 2);
            } else {
                $request->adicional = null;
            }
    
            $update = $sabor->update([
                'adicional' => $request->adicional
            ]);
        }

        if ($update) {
            return retornoJson(true, [['Item editado com sucesso!']]);
        } else {
            return $retorno;
        }
    }

    // Exclui um sabor especificado
    public function destroy($id) {
        $sabor = Sabores::where('id', $id)->firstOrFail();

        if ($sabor->delete()) {
            return retornoJson(true, [['Item excluído com sucesso!']]);
        } else {
            return retornoJson(false, [['Erro ao excluir o item.']]);
        }
    }

    // Através de um array com o id dos sabores, retorna o nome deles
    public function showChurros($codigo) {
        $codigo = json_decode($codigo);
        $churros = ["codigo" => [], "preco" => 0];
        $preco = 10;

        foreach ($codigo as $key => $value) {
            if ($value != null) {
                $churros['codigo'][$key] = Sabores::where('id', $value)->firstOrFail(['nome', 'adicional']);
                if ($churros['codigo'][$key]->adicional != null) {
                    $preco = $preco + $churros['codigo'][$key]->adicional;
                }
                $churros['codigo'][$key] = $churros['codigo'][$key]->nome;
            } else {
                $churros['codigo'][$key] = null;
            }
        }

        $churros['preco'] = $preco; 

        return response()->json($churros, 200);
    }

    // Através de um array com o id dos sabores, retorna o preço deles
    public function showPreco($churros) {
        $churros = json_decode($churros);
        $preco = 0;
        $precoFinal = 0;

        foreach ($churros as $key => $value) {
            $preco = 10;
            foreach ($value->codigo as $key2 => $value2) {
                if ($value2 != null) {
                    if (($adicional = Sabores::where([['id', '=', $value2], ['adicional', '>', 0]])->first('adicional')) != null) {
                        $preco = $preco + floatval($adicional->adicional);
                    }
                }
            }

            $precoFinal = $precoFinal + ($preco * $value->quantidade);
        }

        $precoFinal = $precoFinal + 2;

        return response()->json($precoFinal, 200);
    }

    // Retorna 6 combinações de churros aleatórias 
    public function showRandom() {
        $churros = array();
        $churrosRandom = array();
        $sabor = array();
        $tipos = TiposSabores::all(['id', 'nome']);

        foreach($tipos as $key => $value) {
            $sabor = Sabores::where('id_tipos_sabores', $value->id)->get(['id', 'nome']);
        
            foreach($sabor as $value2) {
                $churros[$key][$value2->id] = $value2;
            }
        }

        for ($i = 0; $i < 6; $i++) {
            foreach($churros as $key => $value) {
                $churrosRandom[$i]['codigo'][$key] = $churros[$key][array_rand($value)]->id;
                $churrosRandom[$i]['nome'] = 'Churros '.$churros[$key][$churrosRandom[$i]['codigo'][$key]]->nome;
            }
        }

        return response()->json($churrosRandom, 200);
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