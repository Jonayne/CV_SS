<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest {
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
            'nombre' => 'required|string|max:255',
            'ap_paterno' => 'required|string|max:255',
            'ap_materno' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required',
            'sede' => 'required_if:role,control_escolar'
        ];
    }

    public function attributes() {
        return [
            "nombre" => "nombre",
            "ap_paterno" => "apellido paterno",
            "ap_materno" => "apellido materno",
        ];
    }

    public function messages() {
        return [
            "sede.required_if" => "La sede es obligatoria cuando el rol asignado es \"Encargado(a) del Área Control Escolar\" ",
        ];
    }

}
