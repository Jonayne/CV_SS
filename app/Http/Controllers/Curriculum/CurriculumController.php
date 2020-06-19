<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use App\Curriculum;
use App\ExtracurricularCourse;
use App\Http\Requests\CurriculumFormRequest;
use App\PreviousExperience;
use App\Subject;
use App\SupportingDocument;
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
     * Muestra el formulario i según el método capture-i. 
     *
     * @return \Illuminate\Http\Response
     */
    public function capture1(Request $request) {
        $user_id = Auth::user()->id;

        // Con esto revisamos si el rol asociado a este usuario tiene permisos para realizar esto.
        // También revisamos que el usuario no tenga capturado ya su cv.
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        
        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        // esta variable nos servirá para saber a donde redireccionar (tener la página anterior).
        // back() no nos sirve porque si alguna validación falla, se sobreescribe la URL anterior y
        // ya nunca nos regresa donde debería.
        $request->session()->put('previous_url', 'curricula.capture1');

        return view('cv.capture.step1', compact('curriculum'));
    }

    public function capture2(Request $request) {   
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        
        $request->session()->put('previous_url', 'curricula.capture2');

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);
        
        return view('cv.capture.step2', compact('curriculum'));
    }
    
    public function capture3(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home');
        }

        $technical_extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', true)->get();
        $extracurricular_teaching_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', false)->get();
                                                    
        $request->session()->put('previous_url', 'curricula.capture3');

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        return view('cv.capture.step3', 
                    compact('technical_extracurricular_courses', 
                            'extracurricular_teaching_courses',
                            'curriculum'));
    }

    public function capture4(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        $request->session()->put('previous_url', 'curricula.capture4');

        return view('cv.capture.step4', compact('curriculum'));
    }

    public function capture5(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.capture5');

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        return view('cv.capture.step5', 
                    compact('subjects', 'curriculum'));
    }

    public function capture6(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        $request->session()->put('previous_url', 'curricula.capture6');

        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        return view('cv.capture.step6', 
                    compact('previous_exp', 'curriculum'));
    }

    public function capture7(Request $request) {  
        $user_id = Auth::user()->id;
        
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.capture7');

        // documento probatorio académico
        $sd_aca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', true)->get();
        // documento probatorio no académico
        $sd_naca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', false)->get();
        
        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        return view('cv.capture.step7', 
                    compact('sd_aca', 'sd_naca', 'curriculum'));
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
        // La guardamos en nuestro sistema de archivos. En nuestra BD tendremos su hash.
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

        return redirect(route($request->session()->get('previous_url')))
                                 ->with('status', 'Información guardada con éxito.')
                                 ->with('status_color', 'success');
    }

        /**
     * Muestra el i-ésimo formulario del curriculum bajo este id. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {   
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->route('home')->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step1', compact('curriculum'));    
    }

    public function show2($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->back()->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step2', compact('curriculum')); 
    
    }

    public function show3($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->back()->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $technical_extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                where('es_curso_tecnico', '=', true)->get();
        $extracurricular_teaching_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                where('es_curso_tecnico', '=', false)->get();
                
        return view('cv.show.step3', compact('curriculum', 'technical_extracurricular_courses'
                                            , 'extracurricular_teaching_courses')); 
    }

    public function show4($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->back()->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step4', compact('curriculum')); 
    }

    public function show5($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->back()->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        return view('cv.show.step5', compact('curriculum', 'subjects')); 
    }

    public function show6($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->back()->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        return view('cv.show.step6', compact('curriculum', 'previous_exp')); 
    }

    public function show7($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('descargar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        if ($curriculum->status == 'en_proceso') {
            return redirect()->back()->with('status', 'No se puede mostrar el recurso solicitado porque sigue en proceso de captura')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $sd_aca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', true)->get();
        $sd_naca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', false)->get();

        return view('cv.show.step7', compact('curriculum', 'sd_aca', 'sd_naca')); 
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
            // hmm...
            error_reporting(E_ALL ^ E_DEPRECATED);

            \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
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
    private function updateCVStatus($user_id, $request, $curriculum) {

        $previous_status = $curriculum->status;

        // Esta lista nos ayuda a tener control sobre los formularios que ya han sido validados, y su porcentaje.
        $completedList = $request->session()->get('completedList');
        
        if(empty($completedList)) {
            $completedList = ['form1' => false, 'form2' => false, 'form3' => false,
                              'form4' => false, 'form5' => false,'form6' => false,
                              'form7' => false, 'percentage' => 0];
        }

        $completedList['percentage'] = 0;

        // Esta es una forma muy poco elegante para validar que los formulario 1, 2 y 4
        // están capturados... si esos campos ya están la base, significa que todas las
        // validaciones de dicho formulario pasaron y por ende está capturado.
        // Una alternativa podría ser tener en la base de datos un campo donde se lleve control
        // de estas cosas, pero... aunque esto es menos elegante, funciona, y es simple.                                                                                                
        if($curriculum->fotografia) {
            $completedList['form1'] = true;
            $completedList['percentage'] += 1/7; 
        }

        if($curriculum->estudios_carrera) {
            $completedList['form2'] = true;
            $completedList['percentage'] += 1/7; 
        }

        // Para los formularios 3, 5, 6 y 7, como son entidades "independientes" al CV, hay que revisar que hayan
        // registros de cada una y así sabremos si esa parte del formuarlio ya está validada.
        $extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->get();

        if(!count($extracurricular_courses) > 0) {
            $completedList['form3'] = false;
        } else {
            $completedList['form3'] = true;
            $completedList['percentage'] += 1/7; 
        }

        if($curriculum->certificaciones_obtenidas) {
            $completedList['form4'] = true;
            $completedList['percentage'] += 1/7; 
        } 

        $subjects = Subject::where('user_id', '=', $user_id)->get();
        if(!count($subjects) > 0) {
            $completedList['form5'] = false;
        } else {
            $completedList['form5'] = true;
            $completedList['percentage'] += 1/7; 
        }

        $pe = PreviousExperience::where('user_id', '=', $user_id)->get();
        if(!count($pe) > 0) {
            $completedList['form6'] = false;
        } else {
            $completedList['form6'] = true;
            $completedList['percentage'] += 1/7; 
        }

        $sd = SupportingDocument::where('user_id', '=', $user_id)->get();
        if(!count($sd) > 0) {
            $completedList['form7'] = false;
        } else {
            $completedList['form7'] = true;
            $completedList['percentage'] += 1/7; 
        }

        $completedList['percentage'] *= 100; 

        // Verificamos si todas los formularios ya están (o no) capturados
        if(in_array(false, $completedList)) {
            $new_status = ['status' => 'en_proceso'];
        } else {
            $new_status = ['status' => 'completado'];
        }
        
        if($previous_status !== $new_status['status']) {
            $curriculum->update($new_status);
        }

        $request->session()->put('completedList', $completedList);

        return $curriculum;
    }

    // Método auxiliar que devuelve el curriculum del usuario indicado, si no existe, lo crea y guarda.
    // También manda a actualizar el status de éste.
    private function getOrCreateUserCurriculum($user_id, $request) {
        $curriculum = Curriculum::where('user_id', '=', $user_id)->get();
        if(count($curriculum) == 0) {
            $curriculum = new Curriculum();
            $curriculum->user_id = $user_id;
            $curriculum->status = 'en_proceso';
            $curriculum->save();

            return $curriculum;
        }
        
        $curriculum = $this->updateCVStatus($user_id, $request, $curriculum->first());

        return $curriculum;
    }

}
