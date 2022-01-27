<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\ConfirmarEmailFormRequest;
use App\Http\Requests\NovaSenhaFormRequest;

use App\Models\User;

class RedefinirController extends Controller
{
    public function index () {
        return view('site.confirmarEmail');
    }

    public function redefinirSenha() {
        return view('site.redefinirSenha');
    }

    // Confirma o Email enviando um link para redefinir senha
    public function email (ConfirmarEmailFormRequest $request) {
        if (User::where('email', $request->email)->first()) {
            $status = Password::sendResetLink(
                $request->only('email')
            ); 

            if ($status == 'passwords.throttled') {
                return retornoJson(false, [['Você já atingiu o limite de envio de Emails. Tente novamente mais tarde.']]);
            } else {
                if ($status == Password::RESET_LINK_SENT) {
                    return retornoJson(true);
                } else {
                    return retornoJson(false, [['Falha no envio do email para redefinir senha. Tente novamente']]);
                }
            }
        } else {
            return retornoJson(false, ['email' => ['O Email digitado não está cadastrado.']], true);
        }
    }

    // Define a nova senha do usuário
    public function novaSenha(NovaSenhaFormRequest $request) {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                
                $user->save();
                event(new PasswordReset($user));
            }
        );       

        if ($status == 'passwords.token') {
            return retornoJson(false, [['Token inválido. Tente novamente mais tarde.']]);
        } else {
            if ($status == Password::PASSWORD_RESET) {
                return retornoJson(true, [['Senha editada com sucesso.']]);
            } else {
                return retornoJson(false, [['Falha ao redefinir senha. Tente novamente.']]);
            }
        }
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