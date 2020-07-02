<?php

namespace App\Http\Controllers\Curriculum;

use App\Certification;
use App\Http\Controllers\Controller;
use App\Curriculum;
use App\ExtracurricularCourse;
use App\Http\Requests\CurriculumFormRequest;
use App\PreviousExperience;
use App\Subject;
use App\SupportingDocument;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class CurriculumController extends Controller {

    protected $lista_nombres_cursos_sep = [
                "Automatización de Documentos para la Oficina",
                "Conoce tu Computadora",
                "Combinación de Herramientas para Elaborar Informes",
                "Elaboración de Diagramas para la Oficina",
                "Estadísticas con Excel",
                "Elaboración de Formatos de Oficina con Word",
                "Herramientas de TIC para Incrementar la Productividad",
                "Módulo Básico de Cómputo con Internet y Windows",
                "Módulo de Excel (Básico – Avanzado)",
                "Módulo de Herramientas Contables y Administrativas",
                "Módulo de Word (Básico – Avanzado)",
                "Procesamiento y Manejo de Información con Word y Excel",
                "Primeros Pasos en la Internet",
                "Seguridad en el Manejo de Equipos de Cómputo",
                "Taller de Actualización Profesional en TIC",
                "Trabajo Colaborativo en la Nube",
                "Taller de Elaboración de Reportes con Excel",
                "Taller de Presentaciones Electrónicas Efectivas"
            ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Método que devueive la vista núm $formNum con los datos capturados hasta el momento.
     * 
     * @param \Illuminate\Http\Request  $request
     * @param int $formNum
     * @return \Illuminate\Http\Response
     */
    public function capture(Request $request, $formNum) {
        // Con esto revisamos si el rol asociado a este usuario tiene permisos para realizar
        // esta acción.
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        $user = Auth::user();

        $curriculum = $this->getOrCreateUserCurriculum($user, $request);
        $element = $this->getFormElementCapture($request, $formNum, $user);

        return view('cv.capture.step'.$formNum, 
                            compact('curriculum', 'element', 'formNum'));
    }

    /**
     * Actualiza el curriculum.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(CurriculumFormRequest $request, $id) {
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $validatedData = $request->validated();

        $curriculum = Curriculum::findOrFail($id);

        // Si estamos capturando la lista de cursos SEP, la pasamos a una cadena y asi la guardamos.
        if(array_key_exists('cursos_impartir_sdpc', $validatedData)) {
            $validatedData['cursos_impartir_sdpc'] = implode(',', $validatedData['cursos_impartir_sdpc']);
        }

        // Para la fotografía.
        // La guardamos en nuestro sistema de archivos. En nuestra BD tendremos su hashname.
        if($request->file('fotografia') ) {
            $hashName = $request->file('fotografia')->hashName();

            $oldHashName = $curriculum->fotografia;
            // Si ya había una fotografía y la estamos actualizando...
            if($oldHashName) {
                // Borramos la foto anterior antes de poner la nueva.
                Storage::delete(['public/images/'.$oldHashName]);
            }
            
            $request->file('fotografia')->store('public/images');
            $validatedData['fotografia'] = $hashName;
        }
        
        $curriculum->update($validatedData);

        return redirect(route('curricula.capture', $request->session()->get('previous_url')))
                                 ->with('status', 'Información guardada con éxito.')
                                 ->with('status_color', 'success');
    }

    /**
     * Muestra el $formNum formulario del curriculum bajo este id. 
     * 
     * @param  int  $id
     * @param  int  $formNum
     * @return \Illuminate\Http\Response
     */
    public function show($id, $formNum) {   
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->route('home')->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        $element = $this->getFormElementShow($formNum, $curriculum->user_id);

        return view('cv.show.step'.$formNum, 
                        compact('curriculum', 'element', 'formNum'));    
    }
    
    /**
     * Renderiza la vista de ayuda de exportación a PDF. 
     * 
     * @return \Illuminate\Http\Response
     */
    public function helpPDF() {
        return view('cv.show.pdf_help');
    }

    /**
     * Descarga el currículum bajo este id, con los parámetros requeridos en
     * la petición.
     * Usamos principalmente dos bibliotecas externas. PHPOffice/PHPWord y dompdf/dompdf.
     * Primero, con PHPOffice generamos el documento a partir de templates en docx, y luego pasamos
     * las variables capturadas del curriculum. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadCV(CurriculumFormRequest $request, $id) {
        $validatedData = $request->validated();

        // Obtenemos el template que corresponda al CV que descargaremos.
        $templateProcessor = new TemplateProcessor('word-templates/'.$validatedData['formato_curriculum'].'.docx');

        $curriculum = Curriculum::findOrFail($id);
        $curriculum_array = $curriculum->toArray();
        
        // Cada CV requiere sus propio llenado, por lo que lo haremos en un método auxiliar.
        if($validatedData['formato_curriculum'] == "curriculum_SEP") {
            $updated_at = Carbon::parse($curriculum->updated_at)->format('m/Y');
            $curriculum_array['updated_at'] = $updated_at;
            return $this->fillCV_SEP($curriculum_array, $templateProcessor);
        } else if ($validatedData['formato_curriculum'] == "FORMATO_CV_CE") {
            $updated_at = Carbon::parse($curriculum->updated_at)->format('d/m/Y');
            $curriculum_array['updated_at'] = $updated_at;
            $curriculum_array['categoria_de_pago'] = $validatedData['categoria_de_pago'];
            return $this->fillCV_CE($curriculum_array, $templateProcessor);
        }
    }
    
    // Método auxiliar para llenar el CV de la SEP. Se debe hacer en el orden del template, si no
    // no funcionan los bloques.
    private function fillCV_SEP($curriculum_array, $templateProcessor) {
        // Obtenemos la url de la fotografía del profesor y la pasamos al documento.
        $photo_url = 'storage/images/'.$curriculum_array['fotografia'];
        Arr::forget($curriculum_array, 'fotografia');
        
        $templateProcessor->setImageValue('fotografia', array( 
            'path' => $photo_url,
            'width' => 77,
            'height' => 108,
            'ratio' => false));

        // esto es necesario porque sino habrán bloques que no se podran clonar por el tamaño.
        ini_set('pcre.backtrack_limit', "10000000");

        $user_id = $curriculum_array['user_id'];

        /*  Estas llamadas son para llenar nuestros bloques en el template en el orden correcto.
            Primero el bloque de documentos probatorios de formacion academica, después el de experiencia
            en capacitación, luego los documentos probatorios de la experiencia en capacitacion,
            despues el de certificaciones, cursos a impartir y finalmente las imagenes de
            los documentos probatorios.
        */
        $this->putAcademicFormationDocs_SEP($user_id, $templateProcessor, 'nombres');
        $this->putPreviousExp_SEP($user_id, $templateProcessor);
        $this->putPreviousExpDocs_SEP($user_id, $templateProcessor, 'nombres');
        $this->putCertifications($user_id, $templateProcessor);
        $this->putCourses_SEP($curriculum_array, $templateProcessor);
        $this->putAcademicFormationDocs_SEP($user_id, $templateProcessor, 'imgs');
        $this->putPreviousExpDocs_SEP($user_id, $templateProcessor, 'imgs');
        
        // Al final susituímos en el documentos los valores simples y listo.
        $templateProcessor->setValues($curriculum_array);
        $filenameDocx = $curriculum_array['nombre']."_".
                        $curriculum_array['apellido_paterno']."_".
                        $curriculum_array['apellido_materno']."_". "CV.docx";
        
        $templateProcessor->saveAs($filenameDocx);

        return response()->download($filenameDocx)->deleteFileAfterSend(true);
    }

    // Sustituye en el template de word de la SEP las experiencias en capacitación.
    private function putPreviousExp_SEP($user_id, $templateProcessor) {
        
        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->
                                        where('curso_sep', '!=', '')->get();
        
        /* Por ej. si en el template tenemos
        {clone_block}
        Periodo: ${periodo}
        {/clone_block}

        Con el método de abajo, dependiendo el tamaño del resultado de nuestra query,
        se crearán varias copias en el template docx, quedando así:
        Periodo: ${periodo#i} con i=1, ... , count($previous_exp) 
        */
        $templateProcessor->cloneBlock('experiencia_previa_bloque', 
                                        count($previous_exp), true, true);
                            
        /* Esto se hizo a mano porque el método cloneBlock, con el que también se deberían
         poder hacer los reemplazos no funciona bien :( en la versión 0.17.0 de phpword
         (Esta es la llamada que debería funcionar, pero como no, se hizo el foreach)
         $templateProcessor->cloneBlock('experiencia_previa_bloque', 0, true, false, $previous_exp->toArray())
        */
        $i = 1;
        foreach ($previous_exp as $pe) {
            $templateProcessor->setValue('curso_sep#'.$i, $pe->curso_sep);
            $templateProcessor->setValue('periodo#'.$i, $pe->periodo);
            $i += 1;
        }

    }

    // Pone los documentos probatorios de experiencia en capacitación, según el modo imágenes o nombres.
    private function putPreviousExpDocs_SEP($user_id, $templateProcessor, $mode) {
        $sds = SupportingDocument::where('user_id', '=', $user_id)
                        ->where('nombre_doc', '=', "(Proyecto SEP) Comprobante por impartir curso de la SEP")
                        ->get();                         
        
        if($mode == 'nombres') {
            $templateProcessor->cloneBlock('capa_bloque', 
                                        count($sds), true, true);
            $i = 1;
            foreach ($sds as $sd) {
                $templateProcessor->setValue('nombre_doc#'.$i, "Comprobante de curso $i");
                $i += 1;
            }
        } else {
            // ponemos las imágenes
            $templateProcessor->cloneBlock('docs_exp_bloque', 
                                        count($sds), true, true);
            $i = 1;
            foreach ($sds as $sd) {
                $templateProcessor->setValue('nombre_doc#'.$i, "Comprobante de curso $i");
                $templateProcessor->setImageValue('imagen#'.$i, array( 
                    'path' => 'storage/supporting_documents/'.$sd->documento,
                    'width' => 300,
                    'height' => ''));
                $i += 1;
            }
        }
        
    }
    
    // Pone los documentos probatorios en formación académica, según el modo imágenes o nombres.
    private function putAcademicFormationDocs_SEP($user_id, $templateProcessor, $mode) {
        $sds = SupportingDocument::where('user_id', '=', $user_id)
                                ->where(function($query) {
                                    $query->orWhere('nombre_doc', '=', "Título")
                                            ->orWhere('nombre_doc', '=', "Cédula profesional")
                                            ->orWhere('nombre_doc', '=', "Historial académico");
                                })->get();                            
        
        if($mode == 'nombres') {
            $templateProcessor->cloneBlock('aca_bloque', 
                                        count($sds), true, true);
            $i = 1;
            foreach ($sds as $sd) {
                $templateProcessor->setValue('nombre_doc#'.$i, $sd->nombre_doc);
                $i += 1;
            }
        } else {
            // ponemos las imágenes
            $templateProcessor->cloneBlock('docs_formacion_bloque', 
                                        count($sds), true, true);
            $i = 1;
            foreach ($sds as $sd) {
                $templateProcessor->setValue('nombre_doc#'.$i, $sd->nombre_doc);
                $templateProcessor->setImageValue('imagen#'.$i, array( 
                    'path' => 'storage/supporting_documents/'.$sd->documento,
                    'width' => 300,
                    'height' => ''));
                $i += 1;
            }
        }
        
    }

    // Pone los nombres de los cursos SEP que este profesor puede impartir.
    private function putCourses_SEP($curriculum_array, $templateProcessor) {
        $user_id = $curriculum_array['user_id'];

        $sdpc_names = explode(',', $curriculum_array['cursos_impartir_sdpc']);
        
        $templateProcessor->cloneBlock('cursos_sdpc_bloque', 
                                        count($sdpc_names), true, true);
                            
        $i = 1;
        foreach ($sdpc_names as $nombre) {
            $templateProcessor->setValue('nombre_curso#'.$i, $nombre);
            $i += 1;
        }
    }

    // Pone las certificaciones obtenidas en cualquiera de las dos templates.
    private function putCertifications($user_id, $templateProcessor) {
        $certifications = Certification::where('user_id', '=', $user_id)->get();
        
        $templateProcessor->cloneBlock('certificaciones_bloque', 
                                        count($certifications), true, true);
                            
        $i = 1;
        foreach ($certifications as $cert) {
            $templateProcessor->setValue('modalidad#'.$i, $cert->modalidad);
            $templateProcessor->setValue('nombre_cert#'.$i, $cert->nombre_cert);
            $templateProcessor->setValue('institucion_emisora#'.$i, $cert->institucion_emisora);
            $i += 1;
        }
    }

    // Método auxiliar que rellena el CV de formato CE.
    private function fillCV_CE($curriculum_array, $templateProcessor) {

        if($curriculum_array['tipo_contratacion'] == 'UNAM') {
            $curriculum_array = Arr::add($curriculum_array, 'contratacion_UNAM', ' X ');
            $curriculum_array = Arr::add($curriculum_array, 'contratacion_EXTERNO', '__');
        }
        else {
            $curriculum_array = Arr::add($curriculum_array, 'contratacion_UNAM', '__');
            $curriculum_array = Arr::add($curriculum_array, 'contratacion_EXTERNO', ' X ');
        }

        // Obtenemos la url de la fotografía del profesor y la pasamos al documento.
        $photo_url = 'storage/images/'.$curriculum_array['fotografia'];
        Arr::forget($curriculum_array, 'fotografia');
        
        $templateProcessor->setImageValue('fotografia', array( 
            'path' => $photo_url,
            'width' => 100,
            'height' => 80,
            'ratio' => false));

        ini_set('pcre.backtrack_limit', "10000000");
        $user_id = $curriculum_array['user_id'];
        $this->putExtracurricularCourses_CE($user_id, $templateProcessor, 'nombres');
        $this->putCertifications($user_id, $templateProcessor);
        $this->putSubjects_CE($user_id, $templateProcessor, 'nombres');
        $this->putPreviousExp_CE($user_id, $templateProcessor);
        
        $templateProcessor->setValues($curriculum_array);

        $filenameDocx = $curriculum_array['nombre']."_".
                        $curriculum_array['apellido_paterno']."_".
                        $curriculum_array['apellido_materno']."_". "CV.docx";
        
        $templateProcessor->saveAs($filenameDocx);
        // to do: pues que se opueda descargar en zip con los probatorios
        return response()->download($filenameDocx)->deleteFileAfterSend(true);
    }

    // Sustituye en el template de word CV-CE las experiencias profesionales.
    private function putPreviousExp_CE($user_id, $templateProcessor) {
        
        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();
        
        $templateProcessor->cloneBlock('experiencia_previa_bloque', 
                                        count($previous_exp), true, true);
                            
        $i = 1;
        foreach ($previous_exp as $pe) {
            $templateProcessor->setValue('periodo#'.$i, $pe->periodo);
            $templateProcessor->setValue('institucion#'.$i, $pe->institucion);
            $templateProcessor->setValue('cargo#'.$i, $pe->cargo);
            $templateProcessor->setValue('actividades_principales#'.$i, $pe->actividades_principales);
            $i += 1;
        }

    }

    // Pone los cursos extracurriculares en el CV CE.
    private function putExtracurricularCourses_CE($user_id, $templateProcessor) {

        $te_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                            where('es_curso_tecnico', '=', true)->get();

        $tc_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', false)->get();

        $templateProcessor->cloneBlock('curso_extracurricular_tecnico_bloque', 
                                        count($te_courses), true, true);

        $i = 1;
        foreach ($te_courses as $course) {
            // el 1 al final indica que sólo se sustituya la primer incidencia.
            // están diferenciados por un id dentro de este bloque, pero no el otro.
            $templateProcessor->setValue('nombre_curso#'.$i, $course->nombre_curso);
            $templateProcessor->setValue('anio#'.$i, $course->anio);
            $templateProcessor->setValue('documento_obtenido#'.$i, $course->documento_obtenido);
            $i += 1;
        }

        $templateProcessor->cloneBlock('curso_extracurricular_docente_bloque', 
                                        count($tc_courses), true, true);

        $i = 1;
        foreach ($tc_courses as $course) {
            $templateProcessor->setValue('nombre_curso#'.$i, $course->nombre_curso);
            $templateProcessor->setValue('anio#'.$i, $course->anio);
            $templateProcessor->setValue('documento_obtenido#'.$i, $course->documento_obtenido);
            $i += 1;
        }

    }

    // Pone los temas a impartir en el CV CE.
    private function putSubjects_CE($user_id, $templateProcessor) {
        
        $subjects = Subject::where('user_id', '=', $user_id)->get();
        
        $templateProcessor->cloneBlock('temas_bloque', 
                                        count($subjects), true, true);

        $i = 1;
        foreach ($subjects as $subject) {
            $templateProcessor->setValue('version#'.$i, $subject->version);
            $templateProcessor->setValue('nivel#'.$i, $subject->nivel);
            $templateProcessor->setValue('sistema_operativo#'.$i, $subject->sistema_operativo);
            $i += 1;
        }

    }

     // Método auxiliar que verifica que este curriculum sea del usuario autentificado.
    private function isUsersCurriculum($curriculum) {
        if($curriculum) {
            $user_id = Auth::user()->id;
            if ($user_id != $curriculum->user_id) {
                return false;
            }

            return true;
        }
        return false;
    }

    // Método auxiliar que verifica el estado actual de la captura del curriculum y lo cambia en la BD.
    private function updateCVStatus($user, $request, $curriculum) {

        // Esta lista nos ayuda a tener control sobre los formularios que ya 
        // han sido validados, y el porcentaje (para la barra de progreso).
        $completedList = $request->session()->get('completedList');
        
        if(empty($completedList)) {
            $completedList = ['form1' => false, 'form2' => false, 'form3' => false,
                              'form4' => false, 'form5' => false,'form6' => false,
                              'form7' => false, 'percentage' => 0];
        }

        // Esta es una forma muy poco elegante para validar que los formulario 1 y 2 
        // están capturados... si esos campos ya están la base, significa que todas las
        // validaciones de dicho formulario pasaron y por ende está capturado.                                                                                              
        if($curriculum->fotografia) {
            $completedList['form1'] = true;
        }
        if($curriculum->estudios_carrera) {
            $completedList['form2'] = true;
        }
        // Para los demás, basta con revisar que la relación exista para este usuario.
        $completedList['form3'] = $user->extracurricularCourses()->exists();          
        $completedList['form4'] = $user->certifications()->exists();
        $completedList['form5'] = $user->subjects()->exists();
        $completedList['form6'] = $user->previousExperiences()->exists();
        $completedList['form7'] = $user->supportingDocuments()->exists();

        // Verificamos si todas los formularios ya están (o no) capturados
        if(in_array(false, $completedList, true)) {
            if($curriculum->status != 'en_proceso') {
                $curriculum->update(['status' => 'en_proceso']);
            }
            // Calculamos el porcentaje que llevamos hasta ahora. 7 es el núm de formularios.
            $completedList['percentage'] = ($this->countArrayValues($completedList, true)*100) / 7;
        } else {
            if($curriculum->status != 'completado') {
                $curriculum->update(['status' => 'completado']);
            }

            $completedList['percentage'] = 100;
        }

        $request->session()->put('completedList', $completedList);

        return $curriculum;
    }

    // Método auxiliar que devuelve el curriculum del usuario indicado, si no existe, lo crea y guarda.
    // También manda a actualizar el status de éste.
    private function getOrCreateUserCurriculum($user, $request) {
        if(!$user->curriculum()->exists()) {
            $curriculum = new Curriculum();
            $curriculum->user_id = $user->id;
            $curriculum->status = 'en_proceso';
            $curriculum->save();

            return $curriculum;
        }
        
        $curriculum = $this->updateCVStatus($user, $request, $user->curriculum()->first());

        return $curriculum;
    }

    // Método auxiliar para contar el número de incidencias de una variable
    // en un array.
    private function countArrayValues($array, $val)  { 
        $count = 0; 
        
        foreach ($array as $key => $value) { 
            if ($value === $val) { 
                $count++; 
            } 
        } 
        
        return $count; 
    } 

    // Para vista CAPTURE: Según el formulario actual, nos devuelve el elemento solicitado.
    private function getFormElementCapture($request, $num, $user) {
        switch ($num) {
            case 1:
                // esta variable nos servirá para saber a donde redireccionar (tener la página anterior).
                // back() no nos sirve porque si alguna validación falla, se sobreescribe la URL anterior y
                // ya nunca nos regresa donde debería.
                $request->session()->put('previous_url', 1);
                return $this->lista_nombres_cursos_sep;

            case 2:
                $request->session()->put('previous_url', 2);
                break;

            case 3:
                $request->session()->put('previous_url', 3);
                $curso_tecnico = $user->extracurricularCourses()
                                      ->where('es_curso_tecnico', '=', true)->get();
                $curso_docente = $user->extracurricularCourses()
                                      ->where('es_curso_tecnico', '=', false)->get();
                return ['curso_tecnico' => $curso_tecnico, 
                        'curso_docente' => $curso_docente];

            case 4:
                $request->session()->put('previous_url', 4);
                return $user->certifications()->get();

            case 5:
                $request->session()->put('previous_url', 5);
                return $user->subjects()->get();

            case 6:
                $request->session()->put('previous_url', 6);
                return $user->previousExperiences()->get();

            case 7:
                $request->session()->put('previous_url', 7);
                $personales = $user->supportingDocuments()
                                   ->where('es_documento_academico', '=', false)->get();
                $academicos = $user->supportingDocuments()
                                   ->where('es_documento_academico', '=', true)->get();
                return ['personales' => $personales, 
                        'academicos' => $academicos];
        }

        return "No-elemento";
    }

    // Para vista SHOW
    private function getFormElementShow($num, $user_id) {
        $user = User::findOrFail($user_id);
        switch ($num) {
            case 1:
                return $this->lista_nombres_cursos_sep;
            case 3:
                $curso_tecnico = $user->extracurricularCourses()
                                      ->where('es_curso_tecnico', '=', true)->get();
                $curso_docente = $user->extracurricularCourses()
                                      ->where('es_curso_tecnico', '=', false)->get();
                return ['curso_tecnico' => $curso_tecnico, 
                        'curso_docente' => $curso_docente];

            case 4:
                return $user->certifications()->get();

            case 5:
                return $user->subjects()->get();

            case 6:
                return $user->previousExperiences()->get();

            case 7:
                $personales = $user->supportingDocuments()
                                   ->where('es_documento_academico', '=', false)->get();
                $academicos = $user->supportingDocuments()
                                   ->where('es_documento_academico', '=', true)->get();
                return ['personales' => $personales, 
                        'academicos' => $academicos];
        }

        return "No-elemento";
    }
}
