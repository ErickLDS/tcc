<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

use App\Rules\HtmlClear;

class TiposSaboresFormRequest extends FormRequest
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
            'opcional' => ['required', 'boolean']
        ];
    }

    
    public function messages ()
    {
        return [
            'nome.required' => "O campo 'nome' é obrigatório!",
            'nome.min' => "O campo 'nome' precisa ter no mínimo 3 caracteres.",
            'nome.max' => "O campo 'nome' permite ter no máximo 20 caracteres."
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
