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
        switch($this->formNumVal) {
            case 1:
                return [
                    "fotografia" => "bail|required_without_all:edit|image|max:9999",
                    "nombre" => "required|string|max:255",
                    "apellido_paterno" => "required|string|max:255",
                    "apellido_materno" => "required|string|max:255",
                    "domicilio_calle" => "required|string|max:255",
                    "domicilio_num_ext" => "required|numeric",
                    "domicilio_num_int" => "sometimes|nullable|numeric",
                    "domicilio_cp" => "required|bail|numeric|digits:5",
                    "domicilio_colonia" => "required|string|max:255",
                    "domicilio_delegacion" => "required|string|max:255",
                    "tel_casa" => "required|bail|digits_between:8,12|numeric",
                    "tel_oficina" => "required|bail|digits_between:8,12|numeric",
                    "tel_recado" => "required|bail|digits_between:8,12|numeric",
                    "celular" => "required|bail|digits_between:8,12|numeric",
                    "email_personal" => "required|email",
                    "email_cursos_linea" => "sometimes|nullable|email",
                    "twitter" => "sometimes|nullable",
                    "fecha_nacimiento" => "required|date_format:Y-m-d|before:today|after:1900-01-01",
                    "disponibilidad_horario" => "required|string|max:255",
                    "dias_disponibles" => "required|string|max:255",
                    "nacionalidad" => "required|string|max:255",
                    "rfc" => "bail|required|alpha_num|size:13",
                    "curp" => "bail|required|alpha_num|size:18",
                    "num_ife" => "required|bail|numeric|digits_between:10,13",
                    "num_proveedor_UNAM" => "sometimes|nullable",
                    "num_autorizacion_de_impresion" => "sometimes|nullable",
                    "tipo_contratacion" => "required",
                    "registro_secretaria_de_trabajo_y_prevision_social" => "sometimes|nullable",
                    "ocupacion_actual" => "bail|required|string",
                    "cursos_impartir_sdpc" => "required_if:proyecto_sep,on",
                    "proyecto_sep" => "sometimes"
                ];
                break;
            case 2:
                return [
                    "estudios_grado_maximo_estudios" => "bail|required|string|max:255",
                    "estudios_escuela" => "bail|required|string|max:255",
                    "estudios_carrera" => "bail|required|string|max:255",
                    "estudios_estatus" => "bail|required|string|max:255",
                    "estudios_documento_obtenido" => "bail|required|string|max:255",
                    "cedula_profesional" => "bail|sometimes|nullable|string|max:255"
                ];
                break;
            case 3:
                return [
                    "nombre_curso" => "bail|required|string|max:255",
                    "anio" => "bail|required|date_format:Y|before:today|after:1900",
                    "documento_obtenido" => "bail|required|string|max:255",
                    "es_curso_tecnico" => "bail|required"
                ];
                break;
            case 4:
                return [
                    "modalidad" => "required|string|max:255",
                    "nombre_cert" => "required|string|max:255",
                    "institucion_emisora" => "required|string|max:255"
                ];
                break;
            case 5:
                return [
                    "nombre_tema" => "required|string|max:255",
                    "nivel" => "required",
                    "version" => "required",
                    "sistema_operativo" => "required"
                ];
                break;
            case 6:
                return [
                    "periodo" => "bail|required|string|max:255",
                    "institucion" => "bail|required|string|max:255",
                    "cargo" => "bail|required|string|max:255",
                    "actividades_principales" => "required|string|max:255",
                    "curso_sep" => "required_if:sep,on"
                ];
                break;
            case 7:
                return [
                    "nombre_doc" => "required",
                    "documento" => "required_without_all:edit|max:100000|mimes:jpeg,bmp,jpg,png,jpe,gif,tif,tiff,webp,svg"
                ];
                break;
            case "download":
                return [
                    "categoria_de_pago" => "required_if:formato_curriculum,FORMATO_CV_CE|nullable|string|max:255",
                    "formato_curriculum" => "required"
                ];
                break;
        }
        
    }

    public function attributes() {
        return [
            "nombre_doc" => 'nombre del documento',
            "nombre_cert" => 'nombre de la certificación',
            "nombre_tema" => 'nombre del tema',
            "nombre_curso" => 'nombre del curso extracurricular',
            "categoria_de_pago" => 'Categoría de pago',
            "formato_descarga" => 'Formato de descarga',
            "formato_curriculum" => 'Formato del curriculum',
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
            "categoria_de_pago.required_if" => "El campo Categoría de Pago es obligatorio al escoger el formato de curriculum CE",
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
            "version.required" => "La version del tema es obligatoria",
            "sistema_operativo.required" => "El sistema operativo es obligatorio",
            "periodo.required" => "El periodo de su experiencia es obligatorio",
            "institucion.required" => "La institución es obligatoria",
            "cargo.required" => "El cargo es obligatorio",
            "actividades_principales.required" => "Una descripción de sus actividades principales es obligatoria",
            "es_documento_academico.required" => "Escoja el tipo de documento",
            "documento.max" => "El máximo de tamaño de archivo son 10mb",
            "documento.mimes" => "Documento con formato incompatible. Por favor, asegúrese de subir una imagen.",
            "documento.required_without_all" => "Subir el documento es obligatorio",
            "cursos_impartir_sdpc.required_if" => "Seleccionar los cursos a impartir para el SDPC es obligatorio cuando indica que participa en el Proyecto SEP.",
            "curso_sep.required_if" => "Por favor, indique el nombre del curso SEP."
        ];
    }
}
