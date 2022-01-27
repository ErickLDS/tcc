<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\Rules\HtmlClear;

class CadastroUserFormRequest extends FormRequest
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
            'nome' => ['required', 'min:3', 'max:20', new HtmlClear],
            'email' => ['required', 'email', 'max:80', new HtmlClear, 'unique:ck_usuarios,email'],
            'senha' => ['required', 'min:8', 'max:60', 'confirmed'],
            'senha_confirmation' => ['required', 'min:8', 'max:60'],
        ];
    }

    
    public function messages ()
    {
        return [
            'nome.required' => "O campo 'nome' é obrigatório!",
            'email.required' => "O campo 'email' é obrigatório!",
            'senha.required' => "O campo 'senha' é obrigatório!",
            'senha_confirmation.required' => "O campo 'confirmar senha' é obrigatório!",

            'nome.min' => "O campo 'nome' precisa ter no mínimo 3 caracteres.",
            'nome.max' => "O campo 'nome' permite ter no máximo 20 caracteres.",

            'senha.min' => "O campo 'senha' precisa ter no mínimo 8 caracteres.",
            'senha.max' => "O campo 'senha' permite ter no máximo 60 caracteres.",

            'senha_confirmation.min' => "O campo 'confirmar senha' precisa ter no mínimo 8 caracteres.",
            'senha_confirmation.max' => "O campo 'confirmar senha' permite ter no máximo 60 caracteres.",

            'email.max' => "O campo 'email' permite ter no máximo 60 caracteres.",

            'email.email' => "Digite um Email válido.",
            'email.unique' => "O Email digitado já está cadastrado.",

            'senha.confirmed' => "O campo 'senha' não está identico ao campo 'confirmar senha'.",
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
