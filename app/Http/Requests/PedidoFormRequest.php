<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\Rules\HtmlClear;

class PedidoFormRequest extends FormRequest
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
            'valor_final' => ['required', 'numeric'],
            'churros' => ['required']
        ];
    }

    
    public function messages ()
    {
        return [
            'valor_final.required' => "Erro ao efetuar pedido, valor não especificado. Tente novamente.",
            'churros.required' => "Erro ao efetuar pedido, churros não especificados. Tente novamente.",

            'valor_final.required' => "Erro ao efetuar pedido, valor não é um número.",
        ];
    }

    protected function failedValidation(Validator $validator) 
    { 
        throw new HttpResponseException(response()->json([
            'sucesso' => false,
            'mensagens' => $validator->errors(),
            'campos' => false
        ], 200));
    }
}
