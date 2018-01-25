<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectValidation extends FormRequest {

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
        return [
            'project_name' => 'required|max:100',
            'project_domain' => [
                'required',
                'regex:/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'
            ]
        ];
    }

    public function messages() {
        return [
            'project_name.required' => 'Nazwa jest wymagane',
            'project_name.max' => 'Nazwa może mieć max :max znaków',
            'project_domain.required' => 'Domena jest wymagane',
            'project_domain.max' => 'Domena może mieć max :max znaków',
            'project_domain.regex' => 'Poprawny format domeny https://www.domena.pl',
        ];
    }

}
