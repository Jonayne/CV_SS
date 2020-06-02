<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchProfessorRequest extends FormRequest
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
            'name' => 'required_without_all:email',
            'email' => 'required_without_all:name'
        ];
    }

    public function messages()
    {
        return [
            'name.required_without_all' => "El campo de nombre es obligatorio cuando no ha introducido el email.",
            'email.required_without_all' => "El campo de email es obligatorio cuando no ha introducido el nombre."
        ];
    }
}
