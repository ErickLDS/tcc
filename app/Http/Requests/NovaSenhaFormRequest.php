<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\Rules\HtmlClear;

class NovaSenhaFormRequest extends FormRequest
{
    protected $redirect = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:80', new HtmlClear],
            'password' => ['required', 'min:8', 'max:60', 'confirmed'],
            'password_confirmation' => ['required', 'min:8', 'max:60'],
            'token' => ['required']
        ];
    }

    
    public function messages ()
    {
        return [
            'email.required' => "O campo 'email' é obrigatório!",
            'password.required' => "O campo 'senha' é obrigatório!",
            'password_confirmation.required' => "O campo 'confirmar senha' é obrigatório!",
            'token.required' => "Token inválido. Tente confirmar seu email novamente.",

            'password.min' => "O campo 'senha' precisa ter no mínimo 8 caracteres.",
            'password.max' => "O campo 'senha' permite ter no máximo 60 caracteres.",

            'password_confirmation.min' => "O campo 'confirmar senha' precisa ter no mínimo 8 caracteres.",
            'password_confirmation.max' => "O campo 'confirmar senha' permite ter no máximo 60 caracteres.",

            'email.max' => "O campo 'email' permite ter no máximo 60 caracteres.",

            'email.email' => "Digite um Email válido.",

            'password.confirmed' => "O campo 'senha' não está identico ao campo 'confirmar senha'.",
        ];
    }

    protected function failedValidation(Validator $validator) 
    { 
        throw new HttpResponseException(response()->json([
            'sucesso' => false,
            'mensagens' => $validator->errors(),
            'campos' => true
        ], 200));
    }
}
