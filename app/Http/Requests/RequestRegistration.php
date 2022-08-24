<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RequestRegistration extends FormRequest
{
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
            'name' => ['required', 'string', 'max:100',],
            'email' =>  ['required', 'string', 'email', 'max:191', 'unique:App\Models\User,email'],
            'phone' => ['required'],
            'type' => ['prohibited']
        ];
    }

    /**
     * Retorno das mensagens de validação do formulário de solicitar cadastro.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => "Informe o nome.",
            'email.required' => "Informe o Email.",
            'email.email' => "Informe um Email válido",
            'email.unique' => "Já existe uma solicitação para esse e-mail",
            'phone.required' => "Informe o telefone",
            
        ];
    }

    public function failedValidation(Validator $validator){throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));}
}
