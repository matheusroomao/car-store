<?php

namespace App\Http\Requests\Admin;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function auth;
use function response;

class CarItemRequest extends FormRequest
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
        if (empty(intval($this->route()->parameter('car_item')))) {
            return [
                'car_id' => ['required', 'int'],
                'item_id' => ['required', 'int'],
            ];
        } else {
            if ($this->request->has('car_id')) {
                $car_id = ['required', 'int'];
                $rules['car_id'] = $car_id;
            }
             if ($this->request->has('item_id')) {
                $item_id = ['required', 'int'];
                $rules['item_id'] = $item_id;
            }
        }
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}