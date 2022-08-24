<?php

namespace App\Http\Requests\Admin;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function auth;
use function response;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if (empty(intval($this->route()->parameter('item')))) {
            return [
                'name' => ['required', 'string', 'max:191', 'min:2','unique:App\Models\Item,name'],
            ];
        } else {
            if ($this->request->has('name')) {
                $name = ['required', 'string', 'max:191', 'min:2','unique:App\Models\Item,name'];
                $rules['name'] = $name;
            }
        }
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}