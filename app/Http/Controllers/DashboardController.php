<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminFormRequest;

use App\Models\Pedidos;
use App\Models\Churros;
use App\Models\FormaPagamento;
use App\Models\Status;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function index() {
        if(auth()->guard('admin')->check()) {
            return view('site.dashboard');
        } else {
            return redirect()->route('loginAdm');
        }
    }

    public function login() {
        return view('site.loginAdm');
    }

    // Efetua login do admin
    public function loginDo(AdminFormRequest $request) {
        auth()->guard('web')->logout();

        $credentials = [
            'email' => $request->email,
            'password' => $request->senha
        ];

        if (auth()->guard('admin')->attempt($credentials)) {
            return retornoJson(true, [['Logado com sucesso!']]);
        } else {
            return retornoJson(false, [['Email ou Senha incorretos.']]);
        }
    }

    // Efetua o logout do admin
    public function logout() {
        auth()->guard('admin')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    // Retorna todos os pedidos efetuados
    public function showPedidos($dia = false, $mes = false, $ano = false, $qtd = 1) {

        if ($mes && $ano) {
            if ($dia > 0) {
                $pedidosAll = Pedidos::whereYear('created_at', $ano)->whereMonth('created_at', $mes)->whereDay('created_at', $dia)->get();
            } else {
                $pedidosAll = Pedidos::whereYear('created_at', $ano)->whereMonth('created_at', $mes)->get();
            }
        } else {
            $pedidosAll = Pedidos::all();
        }
        
        $pedidos = ['quantidade' => $pedidosAll->count(), 'pedidos' => []];

        foreach($pedidosAll as $key => $value) {
            $pedidos['pedidos'][$key] = [
                'id' => $value->id,
                'nome' => $value->user()->first()->name,
                'data' => $value->created_at,
                'total' => floatval($value->valor_final),
                'status' => $value->status()->first(['nome', 'cor', 'id']),
                'pagamento' => $value->pagamento()->first(['nome', 'icone']),
                'troco' => $value->troco,
                'telefone' => '(11) '.substr_replace($value->telefone, '-', 4, 0),
                'obs' => $value->observacoes,
                'endereco' => $value->rua.', Nº '.$value->num.'; '.$value->bairro.', '.$value->cidade.'.'
            ];

            foreach($value->churros()->get(['codigo', 'nome', 'quantidade']) as $key2 => $value2) {
                $pedidos['pedidos'][$key]['churros'][$key2] = $value2;
                $pedidos['pedidos'][$key]['churros'][$key2]['codigo'] = json_decode($value2['codigo']);
            }

            if ($value->troco != null) {
                $pedidos['pedidos'][$key]['troco'] = floatval($value->troco);
            }
        }

        return response()->json($pedidos, 200);
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