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
     * Descarga el currículum bajo este id, con los parámetros requeridos en
     * la petición.
     * Usamos principalmente dos bibliotecas externas. PHPOffice/PHPWord y dompdf/dompdf.
     * Primero, con PHPOffice generamos el documento a partir de templates en docx, y luego pasamos
     * las variables capturadas del curriculum. Ya teniendo el docx rellenado, decidimos qué hacer según
     * el formato de descarga.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadCV(CurriculumFormRequest $request, $id) {
        $validatedData = $request->validated();

        $curriculum = Curriculum::findOrFail($id);

        $templateProcessor = new TemplateProcessor('word-templates/'.$validatedData['formato_curriculum'].'.docx');

        $curriculum_array = $curriculum->toArray();

        // Cambiamos el formato de la fecha en la que se actualizó el CV.
        $updated_at = Carbon::parse($curriculum->updated_at)->format('m/Y');

        $curriculum_array['updated_at'] = $updated_at;
        $curriculum_array['categoria_de_pago'] = $validatedData['categoria_de_pago'];
        
        // Rellenamos lo que corresponde a cursos extracurriculares, docs probatorios, etc...
        $this->putExtracurricularCoursesValues($curriculum_array['user_id'], $templateProcessor);
        $this->putSubjectsValues($curriculum_array['user_id'], $templateProcessor);
        $this->putPreviousExperienciesValues($curriculum_array['user_id'], $templateProcessor);

        // Obtenemos la url de la fotografía del profesor y la pasamos al documento.
        $photo_url = 'storage/images/'.$curriculum_array['fotografia'];
        Arr::forget($curriculum_array, 'fotografia');
        
        $templateProcessor->setImageValue('fotografia', array( 
            'path' => $photo_url,
            'width' => 77,
            'height' => 108,
            'ratio' => false));
        
        // Pasamos los valores del curriculum al documento (y que se sustituyan 1 vez).
        $templateProcessor->setValues($curriculum_array, 1);
        
        $name = $curriculum->nombre."_".
                $curriculum->apellido_paterno."_".
                $curriculum->apellido_materno."_". "CV";

        $filenameDocx = $name . '.docx';
        
        $templateProcessor->saveAs($filenameDocx);

        // pendiente... mejro pasar de docx a html y luego a pdf
        if($validatedData['formato_descarga'] == "pdf") {

            $domPDFPath = base_path('vendor/dompdf/dompdf');
            \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPDFPath);
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

            //Cargamos el archivo temporal... 
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($filenameDocx); 

            //Lo guardamos.
            $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
            $xmlWriter->save($name.'.pdf');

            // Borramos el docx.
            File::delete($filenameDocx);

        }

        return response()->download($name.'.'.$validatedData['formato_descarga'])->
                           deleteFileAfterSend(true);
    }
    
    // Sustituye en el template de word las experiencias previas guardadas.
    private function putPreviousExperienciesValues($user_id, $templateProcessor) {
        
        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();
        
        /* Por ej. si tenemos
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
         poder hacer los reemplazos no funciona bien :( en la versión 0.17.0
         (Esta es la llamada que debería funcionar en vez del código anexado abajo)
         $templateProcessor->cloneBlock('experiencia_previa_bloque', 0, true, false, $previous_exp->toArray())
        */
        $i = 1;
        foreach ($previous_exp as $pe) {
            $templateProcessor->setValue('periodo#'.$i, $pe->periodo);
            $templateProcessor->setValue('institucion#'.$i, $pe->institucion);
            $templateProcessor->setValue('cargo#'.$i, $pe->cargo);
            $templateProcessor->setValue('actividades_principales#'.$i, $pe->actividades_principales);
            $i += 1;
        }

    }

    // Método auxiliar para pasar a una sola cadena todos los cursos extracurriculares.
    private function putExtracurricularCoursesValues($user_id, $templateProcessor) {

        $te_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                            where('es_curso_tecnico', '=', true)->get();

        $tc_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', false)->get();

        $templateProcessor->cloneBlock('curso_extracurricular_tecnico_bloque', 
                                        count($te_courses), true, true);

        $templateProcessor->cloneBlock('curso_extracurricular_docente_bloque', 
                                        count($tc_courses), true, true);

        $i = 1;
        foreach ($te_courses as $course) {
            // el 1 al final indica que sólo se sustituya la primer incidencia.
            // están diferenciados por un id dentro de este bloque, pero no el otro.
            $templateProcessor->setValue('nombre#'.$i, $course->nombre, 1);
            $templateProcessor->setValue('anio#'.$i, $course->anio, 1);
            $templateProcessor->setValue('documento_obtenido#'.$i, $course->documento_obtenido, 1);
            $i += 1;
        }

        $i = 1;
        foreach ($tc_courses as $course) {
            $templateProcessor->setValue('nombre#'.$i, $course->nombre, 1);
            $templateProcessor->setValue('anio#'.$i, $course->anio, 1);
            $templateProcessor->setValue('documento_obtenido#'.$i, $course->documento_obtenido, 1);
            $i += 1;
        }

    }

    // Método auxiliar para pasar a una sola cadena la lista de temas a impartir.
    private function putSubjectsValues($user_id, $templateProcessor) {
        
        $subjects = Subject::where('user_id', '=', $user_id)->get();
        
        $templateProcessor->cloneBlock('temas_bloque', 
                                        count($subjects), true, true);

        $i = 1;
        foreach ($subjects as $subject) {
            $templateProcessor->setValue('periodo#'.$i, $subject->version);
            $templateProcessor->setValue('institucion#'.$i, $subject->nivel);
            $templateProcessor->setValue('cargo#'.$i, $subject->sistema_operativo);
            $i += 1;
        }

    }

    // Método auxiliar para pasar a una sola cadena todos los cursos extracurriculares.
    private function getDSAsString() {
        // ?? Docs probatorios pendientes
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
            $completedList['percentage'] = ($this->count_array_values($completedList, true)*100) / 7;
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
    private function count_array_values($array, $val)  { 
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
                break;

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
