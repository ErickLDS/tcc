<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\Rules\HtmlClear;

class AdminFormRequest extends FormRequest
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
            'senha' => ['required', 'min:8', 'max:60'],
        ];
    }

    
    public function messages ()
    {
        return [
            'email.required' => "O campo 'email' é obrigatório!",
            'senha.required' => "O campo 'senha' é obrigatório!",

            'senha.min' => "O campo 'senha' precisa ter no mínimo 8 caracteres.",
            'senha.max' => "O campo 'senha' permite ter no máximo 60 caracteres.",
            'email.max' => "O campo 'email' permite ter no máximo 60 caracteres.",

            'email.email' => "Digite um Email válido.",
            'email.unique' => "O Email digitado já está cadastrado.",
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
