<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BikeRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [
            'name' => 'required|max:1000',
            'position' => 'required'
        ];

        return $rules;
    }

    public function messages() {
        return [
            'required' => 'Поля :attribute обязательно для заполения',
            'unique' => 'Значение :attribute должны быть уникально',
            'max' => 'Максмиальная длина поля :attribute :max символов',
            'alpha' => 'Поле :attribute должно содержать только латинские символы без цифр и знаков тире и подчеркивания'
        ];
    }

}
