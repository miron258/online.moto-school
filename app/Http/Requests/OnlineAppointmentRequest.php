<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OnlineAppointmentRequest extends FormRequest {

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
            'text' => 'required|max:100',
            'time_from' => 'required',
            'time_to' => 'required',
            'bike_id' => 'required',
            'status' => 'required',
            'date_record' => 'required'
        ];



        return $rules;
    }

    public function messages() {
        return [
            'required' => 'Поля :attribute обязательно для заполнения',
            'unique' => 'Значение :attribute должны быть уникально',
            'max' => 'Максмиальная длина поля :attribute :max символов',
            'alpha' => 'Поле :attribute должно содержать только латинские символы без цифр и знаков тире и подчеркивания'
        ];
    }

}
