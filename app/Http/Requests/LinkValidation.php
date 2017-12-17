<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkValidation extends FormRequest {

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
            'url' => 'required',
            'anchor' => 'required',
            'refersto' => 'required',
            ];
    }

    public function messages() {
        return [
            'url.required' => 'Link jest wymagany',
            'anchor.required' => 'Anchor jest wymagany',
            'refersto.required' => 'Strona docelowa jest wymagana',
            
        ];
    }

}
