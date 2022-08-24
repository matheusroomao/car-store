<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function auth;
use function response;

class UserRequest extends FormRequest
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


    public function rules()
    {
        $rules = [];

        if (empty(intval($this->route()->parameter("user")))) {
            $rules = [
                'name' => ['required', 'min:3', 'max:191'],
                'password' => ['required', 'confirmed', 'min:8', 'max:191'],
                'email' => ['required', 'email:rfc,dns', 'unique:App\Models\User,email'],
                'phone' => ['required', 'unique:App\Models\User,phone'],
                'type' => ['required','string','in:ADMIN,SELLER']
            ];
        } else {
            if ($this->request->has('name')) {
                $name = ['required', 'min:3', 'max:191'];
                $rules['name'] = $name;
            }
            if ($this->request->has('password')) {
                $password = ['required', 'confirmed', 'min:8', 'max:191'];
                $rules['password'] = $password;
            }
            if ($this->request->has('email')) {
                $email = ['required', 'email:rfc,dns', 'unique:App\Models\User,email'];
                $rules['email'] = $email;
            }
            if ($this->request->has('phone')) {
                $phone = ['required', 'unique:App\Models\User,phone'];
                $rules['phone'] = $phone;
            }
            if ($this->request->has('type')) {
                $type = ['required','string','in:ADMIN,SELLER'];
                $rules['type'] = $type;
            }
        }
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}
