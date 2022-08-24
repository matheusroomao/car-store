<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use function auth;
use function response;

class CarRequest extends FormRequest
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
        if (empty(intval($this->route()->parameter('car')))) {
            return [
                'name' => ['required', 'string', 'max:191', 'min:2'],
                'year' => ['required', 'date_format:Y'],
                'km'   => ['required', 'int'],
                'change' => ['required','string', 'in:manual,automatic'],
                'fuel' => ['required','string', 'in:flex,gasolina,diesel,etanol'],
                'end_plate' => ['required','int', 'max:2'],
                'color' => ['required','string'],
                'ipva_paid' => ['required','boolean'],
                'only_owner' => ['required','boolean'],
                'licensed' => ['required','boolean'],
                'bodywork' => ['required','string','in:Sedã,suv,Hatch,Picape'],
                'description' => ['required','string'],
                'brand_id' => ['required', 'int', 'exists:App\Models\Brand,id'],
                'user_id' => ['prohibited'],
                'active' => ['prohibited'],
                'price' => ['required','numeric'],
                'motor' => ['required','numeric'],
            ];
        } else {
            if ($this->request->has('name')) {
                $name = ['required', 'string', 'max:191', 'min:2'];
                $rules['name'] = $name;
            }
            if ($this->request->has('year')) {
                $year = ['required', 'date_format:Y'];
                $rules['year'] = $year;
            }
            if ($this->request->has('km')) {
                $km = ['required', 'int'];
                $rules['km'] = $km;
            }
            if ($this->request->has('change')) {
                $change = ['required','string', 'in:manual,automatic'];
                $rules['change'] = $change;
            }
            if ($this->request->has('fuel')) {
                $fuel = ['required','string', 'in:flex,gasolina,diesel,etanol'];
                $rules['fuel'] = $fuel;
            }
            if ($this->request->has('end_plate')) {
                $end_plate = ['required','int', 'max:1'];
                $rules['end_plate'] = $end_plate;
            }
            if ($this->request->has('color')) {
                $color = ['required','string'];
                $rules['color'] = $color;
            }
            if ($this->request->has('ipva_paid')) {
                $ipva_paid = ['required','boolean'];
                $rules['ipva_paid'] = $ipva_paid;
            }
            if ($this->request->has('licensed')) {
                $licensed = ['required','boolean'];
                $rules['licensed'] = $licensed;
            }
            if ($this->request->has('only_owner')) {
                $only_owner = ['required','boolean'];
                $rules['only_owner'] = $only_owner;
            }
            if ($this->request->has('bodywork')) {
                $bodywork = ['required','string','in:Sedã,suv,Hatch,Picape'];
                $rules['bodywork'] = $bodywork;
            }
            if ($this->request->has('description')) {
                $description = ['required','string'];
                $rules['description'] = $description;
            }
            if ($this->request->has('image')) {
                $image = ['required', 'file', 'max:5020', 'mimes:png,jpeg,jpg,pdf,ppt,xls'];
                $rules['image'] = $image;
            }
            if ($this->request->has('brand_id')) {
                $brand_id = ['required', 'int', 'exists:App\Models\Brand,id'];
                $rules['brand_id'] = $brand_id;
            }
            if ($this->request->has('user_id')) {
                $user_id = ['prohibited'];
                $rules['user_id'] = $user_id;
            }
            if ($this->request->has('active')) {
                $active = ['prohibited'];
                $rules['active'] = $active;
            }
            if ($this->request->has('price')) {
                $price = ['required','numeric'];
                $rules['price'] = $price;
            }
            if ($this->request->has('motor')) {
                $motor = ['required','numeric'];
                $rules['motor'] = $motor;
            }
        }
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()->first()], 422));
    }
}