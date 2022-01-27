<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Http\Requests\LoginUserFormRequest;
use App\Http\Requests\CadastroUserFormRequest;
use App\Http\Requests\UpdateUserFormRequest;

class LoginController extends Controller
{
    public function index() {
        return view('site.login');
    }

    // Efetua o login do usuário
    public function login(LoginUserFormRequest $request) {
        auth()->guard('admin')->logout();

        $credentials = [
            'email' => $request->email,
            'password' => $request->senha
        ];

        if (auth()->attempt($credentials, $request->remember)) {
            return retornoJson(true, [['Logado com sucesso!']]);
        } else {
            return retornoJson(false, [['Email ou Senha incorretos.']]);
        }
    }

    // Efetua o cadastro do usuário
    public function store(CadastroUserFormRequest $request) {
        $usuario = new User;

        if ($request->senha == $request->senha_confirmation) {
            $usuario->name = mb_strtolower(trim($request->nome));
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->senha);

            if ($usuario->save()) {
                auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->senha]);
                return retornoJson(true, [['Cadastrado com sucesso!']]);
            } else {
                return retornoJson(false, [['Erro ao cadastrar. Tente novamente.']]);
            }
        } else {
            return retornoJson(false, [["As senhas não são iguais! Verifique o campo 'confirmar senha' está correto."]]);
        }
    }

    // Edita as informações como nome e email do usuário
    public function edit(UpdateUserFormRequest $request) {
        $usuario = User::findOrFail(auth()->id());

        if ((User::where('email', $request->email)->first() == false)) {
            $update = $usuario->update([
                'email' => $request->email
            ]);
        } else {
            $retorno = retornoJson(false, ['email' => ['O Email digitado já está cadastrado.']], true);
        }

        if (mb_strtolower($request->nome) != $usuario->getOriginal('name')) {
            $update = $usuario->update([
                'name' => mb_strtolower(trim($request->nome))
            ]);
        }
        
        if (!empty($update)) {
            return retornoJson(true, [['Editado com sucesso!']], true);
        } else {
            return $retorno;
        }
    }

    // Efetua o logout do usuário
    public function logout() {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        return response()->json(true, 200);
    }

    // Verifica se o usuário está logado e retorna o email e nome dele
    public function check() {
        if (auth()->check()) {
            return response()->json([
                'nome' => auth()->user()->name, 
                'email' => auth()->user()->email
            ], 200);
        } else {
            return response()->json(false, 200);
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