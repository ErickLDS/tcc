<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\Rules\HtmlClear;

class EnderecoFormRequest extends FormRequest
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
            'cep' => ['nullable', 'min:8', 'max:8', new HtmlClear],
            'rua' => ['required', 'min:4', 'max:50', new HtmlClear],
            'bairro' => ['required', 'min:4', 'max:50', new HtmlClear],
            'cidade' => ['required', 'min:4', 'max:50', new HtmlClear],
            'num' => ['required', 'min:2', 'max:4', new HtmlClear],
            'telefone' => ['required', 'min:8', 'max:8', new HtmlClear],
            'obs' => ['nullable', 'min:12', 'max:200', new HtmlClear],
        ];
    }

    
    public function messages ()
    {
        return [
            'rua.required' => "O campo 'rua' é obrigatório!",
            'bairro.required' => "O campo 'bairro' é obrigatório!",
            'cidade.required' => "O campo 'cidade' é obrigatório!",
            'num.required' => "O campo 'nº residêncial' é obrigatório!",
            'telefone.required' => "O campo 'telefone' é obrigatório!",

            'cep.min' => "CEP inválido.",
            'cep.max' => "CEP inválido.",
            'rua.min' => "O campo 'rua' precisa ter no mínimo 4 caracteres.",
            'rua.max' => "O campo 'rua' permite ter no máximo 50 caracteres.",
            'bairro.min' => "O campo 'bairro' precisa ter no mínimo 4 caracteres.",
            'bairro.max' => "O campo 'bairro' permite ter no máximo 50 caracteres.",
            'cidade.min' => "O campo 'cidade' precisa ter no mínimo 4 caracteres.",
            'cidade.max' => "O campo 'cidade' permite ter no máximo 50 caracteres.",
            'num.min' => "O campo 'Nº residêncial' precisa ter no mínimo 2 números.",
            'num.max' => "O campo 'Nº residêncial' permite ter no máximo 4 números.",
            'telefone.min' => "Telefone Fixo inválido.",
            'telefone.max' => "Telefone Fixo inválido.",
            'obs.min' => "O campo 'observações' precisa ter no mínimo 12 caracteres.",
            'obs.max' => "O campo 'observações' permite ter no máximo 200 caracteres.",
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
