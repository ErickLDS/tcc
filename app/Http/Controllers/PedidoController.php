<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\EnderecoFormRequest;
use App\Http\Requests\PedidoFormRequest;

use App\Models\Pedidos;
use App\Models\Churros;
use App\Models\FormaPagamento;
use App\Models\Status;

class PedidoController extends Controller
{
    public function index () {
        return view('site.finalizar');
    }

    // Armazena o pedido
    public function store (PedidoFormRequest $request) {
        $pedido = new Pedidos;

        $pedido->valor_final = $request->valor_final;
        $pedido->telefone = $request->telefone;
        $pedido->rua = $request->rua;
        $pedido->bairro = $request->bairro;
        $pedido->cidade = $request->cidade;
        $pedido->num = $request->num;
        $pedido->observacoes = $request->obs;
        $pedido->troco = $request->troco;
        $pedido->id_usuario = auth()->id();
        $pedido->id_forma_pagamento = $request->id_forma_pagamento;
        $pedido->id_status = 1;

        if ($pedido->save()) {
            foreach($request->churros as $key => $value) {
                $churros = new Churros;
    
                $churros->nome = $value['nome'];
                $churros->quantidade = $value['quantidade'];
                $churros->codigo = json_encode($value['codigo']);
                $churros->id_pedido = $pedido->id;

                $churros->save();
            }
            
            return retornoJson(true, [['Pedido efetuado com sucesso!']]);
        } else {
            return retornoJson(false, [['erro ao efetuar pedido.']]);
        }
    }

    // Mostra todos os pedidos de um determinado usuário
    public function showAll () {
        $pedidosAll = Pedidos::all()->where('id_usuario', auth()->id());
        $pedidos = array();
        $count = 0;

        foreach($pedidosAll as $key => $value) {
            $pedidos[$count]['id'] = $value['id'];
            $pedidos[$count]['total'] = floatval($value['valor_final']);
            $pedidos[$count]['data'] = $value['created_at'];
            $pedidos[$count]['status'] = $value->status()->first(['nome', 'cor']);
            $count++;
        }

        return response()->json($pedidos, 200);
    }

    // Retorna o pedido especificado
    public function show ($id) {
        $pedidoBD = Pedidos::where('id', $id)->first();

        $pedido = [
            'id' => $pedidoBD->id,
            'data' => $pedidoBD->created_at,
            'total' => floatval($pedidoBD->valor_final),
            'status' => $pedidoBD->status()->first(['nome', 'cor']),
            'pagamento' => $pedidoBD->pagamento()->first(['nome', 'icone']),
            'troco' => $pedidoBD->troco,
            'churros' => $pedidoBD->churros()->get(['codigo', 'nome', 'quantidade']),
        ];

        foreach($pedido['churros'] as $value) {
            $value['codigo'] = json_decode($value['codigo']);
        }
        
        return response()->json($pedido, 200);
    }

    // Atualiza o status do pedido
    public function editStatus (Request $request) {
        $pedido = Pedidos::where("id", $request->id)->first();

        if ($pedido) {
            $pedido->update([
                'id_status' => $request->id_status
            ]);

            return retornoJson(true, [['Status atualizado com sucesso!']]);
        } else {
            return retornoJson(false);
        }
    }

    // Valida o formulário de endereço
    public function validarEndereco (EnderecoFormRequest $request) {
        return retornoJson(true);
    }

    // Valida o formulário de pagamento
    public function validarPagamento (Request $request) {
        $request->troco = floatval($request->troco);
        $request->total = floatval($request->total);

        if (!empty($request->id)) {
            if (FormaPagamento::where('id', $request->id)->first()) {
                if ($request->troco != null) {
                    if ($request->troco >= $request->total)  {
                        if ($request->troco < ($request->total * 20))  {
                            return retornoJson(true);
                        }
                        else {
                            return retornoJson(false, [['Você ultrapassou o limite de troco.']]);
                        }
                    } 
                    else {
                        return retornoJson(false, [['A quantia inserida é menor que o total do pedido.']]);
                    }
                } else{
                    return retornoJson(true);
                }
            } 
            else {
                return retornoJson(false, [['Forma de pagamento inválida.']]);
            }
        } 
        else {
            return retornoJson(false, [['Selecione uma forma de pagamento.']]);
        }
    }

    // Retorna todas as formas de pagamento
    public function showFormaPagamento () {
        $formas = FormaPagamento::all(['id', 'nome', 'icone', 'troco']);

        foreach ($formas as $key => $item) {
            if ($item['troco'] == 1) {
                $item['troco'] = true;
            } else {
                $item['troco'] = false;
            }
        }

        return response()->json($formas, 200);
    }

    // Retorna todos os status
    public function showStatus () {
        return response()->json(Status::all(['id', 'nome', 'cor']) ,200);
    }
}

// Retorno padrão
function retornoJson ($tipo, $msg = false, $campos = false) {
    return response()->json([
        'sucesso' => $tipo,
        'mensagens' => $msg,
        'campos' => $campos
    ], 200);
}
