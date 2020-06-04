<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurriculumFormRequest extends FormRequest {

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
        switch($this->formNum) {
            case 1:
                return [
                    "fotografia" => "bail|required_without_all:edit|image|max:9999",
                    "nombre" => "required|string|max:255",
                    "apellido_paterno" => "required|string|max:255",
                    "apellido_materno" => "required|string|max:255",
                    "domicilio_calle" => "required|string|max:255",
                    "domicilio_num_ext" => "required|numeric",
                    "domicilio_num_int" => "nullable|numeric",
                    "domicilio_cp" => "required|bail|numeric|digits:5",
                    "domicilio_colonia" => "required|string|max:255",
                    "domicilio_delegacion" => "required|string|max:255",
                    "tel_casa" => "sometimes|nullable|bail|digits_between:8,12|numeric",
                    "tel_oficina" => "sometimes|nullable|bail|digits_between:8,12|numeric",
                    "tel_recado" => "sometimes|nullable|bail|digits_between:8,12|numeric",
                    "celular" => "sometimes|nullable|bail|digits_between:8,12|numeric",
                    "email_personal" => "required|email",
                    "email_cursos_linea" => "sometimes|nullable|email",
                    "twitter" => "sometimes|nullable",
                    "fecha_nacimiento" => "required|date_format:Y-m-d|before:today|after:1900-01-01",
                    "disponibilidad_horario" => "sometimes|nullable|string|max:255",
                    "dias_disponibles" => "sometimes|nullable|string|max:255",
                    "nacionalidad" => "required|string|max:255",
                    "rfc" => "bail|required|alpha_num|size:13",
                    "curp" => "bail|required|alpha_num|size:18",
                    "num_ife" => "sometimes|nullable|bail|numeric|digits_between:10,13",
                    "num_proveedor_UNAM" => "sometimes|nullable",
                    "num_autorizacion_de_impresion" => "sometimes|nullable",
                    "tipo_contratacion" => "required",
                    "cursos_impartir_sdpc" => "sometimes|nullable",
                    "registro_secretaria_de_trabajo_y_prevision_social" => "sometimes|nullable",
                    "ocupacion_actual" => "sometimes|nullable"
                ];
                break;
            case 2:
                return [
                    "estudios_grado_maximo_estudios" => "required|string|max:255",
                    "estudios_escuela" => "required|string|max:255",
                    "estudios_carrera" => "required|string|max:255",
                    "estudios_estatus" => "required|string|max:255",
                    "estudios_documento_obtenido" => "required|string|max:255",
                    "cedula_profesional" => "sometimes|string|max:255"
                ];
                break;
            case 3:
                return [
                    "nombre" => "required|string|max:255",
                    "anio" => "bail|required|date_format:Y|before:today|after:1900",
                    "documento_obtenido" => "required|string|max:255",
                    "es_curso_tecnico" => "required"
                ];
                break;
            case 4:
                return [
                    "certificaciones_obtenidas" => "required|string|min:10|max:1000"
                ];
                break;
            case 5:
                return [
                    "nivel" => "required",
                    "version" => "required",
                    "sistema_operativo" => "required"
                ];
                break;
            case 6:
                return [
                    "periodo" => "required|string|max:255",
                    "institucion" => "required|string|max:255",
                    "cargo" => "required|string|max:255",
                    "actividades_principales" => "required|string|max:255"
                ];
                break;
            case 7:
                return [
                    "nombre" => "required|string|max:255",
                    "es_documento_academico" => "required",
                    "documento" => "required_without_all:edit|max:100000|mimes:doc,docx,dot,pdf,odt,odi,jpeg,bpm,jpg,png,jpe"
                ];
                break;
        }
        
    }

    public function attributes() {
        return [
            "nombre" => "Nombre",
            "apellido_paterno" => "Apellido paterno",
            "apellido_materno" => "Apellido materno",
            "domicilio_calle" => "Calle",
            "domicilio_num_ext" => "Número exterior",
            "domicilio_num_int" => "Número interior",
            "domicilio_cp" => "Código postal",
            "domicilio_colonia" => "Colonia",
            "domicilio_delegacion" => "Delegación",
            "tel_casa" => "Teléfono de casa",
            "tel_oficina" => "Teléfono de oficina",
            "tel_recado" => "Teléfono de recado",
            "celular" => "Teléfono celular",
            "email_personal" => "Email personal",
            "email_cursos_linea" => "Email para cursos en línea",
            "fecha_nacimiento" => "Fecha de nacimiento",
            "disponibilidad_horario" => "Disponibilidad de horario",
            "dias_disponibles" => "Días disponibles",
            "nacionalidad" => "Nacionalidad",
            "rfc" => "RFC con homoclave",
            "curp" => "CURP",
            "num_ife" => "Número de IFE",
            "num_proveedor_UNAM" => "Número de proveedor UNAM",
            "num_autorizacion_de_impresion" => "Número de autorización de impresión (SICOFI)",
            "tipo_contratacion" => "Tipo de contratación",
            "cursos_impartir_sdpc" => "Cursos a impartir para el SDPC (Nombre del curso SEP)",
            "registro_secretaria_de_trabajo_y_prevision_social" => "Registro ante la Secretaría de Trabajo y Previsión Social",
            "ocupacion_actual" => "Ocupación actual",
        ];
    }

    public function messages() {
        return [
            "fotografia.required_without_all" => "La fotografía es obligatoria",
            "fotografia.image" => "El formato de la fotografía es erroneo",
            "fotografia.max" => "El tamaño del archivo de la fotografía debe ser menor a 10MB",
            "fecha_nacimiento.before" => "Fecha de nacimiento inválida",
            "fecha_nacimiento.after" => "Fecha de nacimiento inválida",
            "estudios_grado_maximo_estudios.required" => "El grado máximo de estudios es obligatorio",
            "estudios_escuela.required" => "La escuela es obligatoria",
            "estudios_carrera.required" => "La carrera es obligatoria",
            "estudios_estatus.required" => "El estatus es obligatoria",
            "estudios_documento_obtenido.required" => "El documento obtenido es obligatorio",
            "anio.required" => "El año del curso es obligatorio",
            "anio.date_format" => "El año del curso debe tener el formato Y (ej. 2018)",
            "anio.before" => "El año del curso introducido es inválido",
            "anio.after" => "El año del curso introducido es inválido",
            "documento_obtenido.required" => "El documento obtenido es obligatorio",
            "es_curso_tecnico.required" => "Escoger el tipo del curso es obligatorio",
            "certificaciones_obtenidas.min" => "El mínimo de texto son 10 letras",
            "certificaciones_obtenidas.max" => "Ha superado el límite de espacio (1000)",
            "nivel.required" => "El nivel del tema es obligatorio",
            "version.required" => "La version del tema es obligatorio",
            "sistema_operativo.required" => "El sistema operativo es obligatorio",
            "periodo.required" => "El periodo de su experiencia es obligatorio",
            "institucion.required" => "La institución es obligatoria",
            "cargo.required" => "El cargo es obligatorio",
            "actividades_principales.required" => "Una descripción de sus actividades principales es obligatoria",
            "es_documento_academico.required" => "Escoja el tipo de documento",
            "documento.max" => "El máximo de tamaño de archivo son 10mb",
            "documento.mimes" => "Documento con formato incompatible",
            "documento.required_without_all" => "Subir el documento es obligatorio",
        ];
    }
}
