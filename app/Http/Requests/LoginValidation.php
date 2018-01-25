<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidation extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    
    public function rules() {
        return [
            'login' => 'required|min:4',
            'password' => 'required|min:8|max:30',
        ];
    }

    public function messages() {
        return [
            'password.required' => 'Hasło jest wymagane',
            'password.max' => 'Hasło musi zawierać 8 - 30 znaków',
            'password.min' => 'Hasło musi zawierać 8 - 30 znaków',
            'login.required' => 'Login jest wymagane',
            'login.min' => 'Login musi mieć min :min znaków',
            'login.max' => 'Login musi mieć max :max znaków',
        ];
    }

}
