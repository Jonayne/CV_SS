<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use App\Curriculum;
use App\ExtracurricularCourse;
use App\Http\Requests\CurriculumFormRequest;
use App\PreviousExperience;
use App\Subject;
use App\SupportingDocument;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        
        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        $request->session()->put('previous_url', 'curricula.capture1');

        return view('cv.capture.step1', compact('curriculum'));
    }

    public function capture2(Request $request) {   
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        
        $request->session()->put('previous_url', 'curricula.capture2');

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);
        
        return view('cv.capture.step2', compact('curriculum'));
    }
    
    public function capture3(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'));
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
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $curriculum = $this->getOrCreateUserCurriculum($user_id, $request);

        $request->session()->put('previous_url', 'curricula.capture4');

        return view('cv.capture.step4', compact('curriculum'));
    }

    public function capture5(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
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
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
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
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
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
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $validatedData = $request->validated();

        $curriculum = Curriculum::findOrFail($id);

        // Guardamos la imagen en nuestro sistema de archivos, en la BD se guardará el hash de ésta.
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
     * MÉTODOS AUXILIARES
     * */

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

        $completedList = $request->session()->get('completedList');
        if(empty($completedList)) {
            $completedList = ['form1' => false, 'form2' => false, 'form3' => false,
                              'form4' => false, 'form5' => false,'form6' => false,
                              'form7' => false];
        }

        // Esta es una forma muy poco elegante para validar que el formulario 1, 2 y 4
        // están capturados... si esos campos ya están la base, significa que todas las
        // validaciones de dicho formulario pasaron y por ende está capturado.
        // Una alternativa podría ser tener en la base de datos un campo donde se lleve control
        // de estas cosas, pero... aunque esto es menos elegante, funciona, y es simple.                                                                                                
        if($curriculum->fotografia) {
            $completedList['form1'] = true;
        }

        if($curriculum->estudios_carrera) {
            $completedList['form2'] = true;
        }

        // Para los formularios 3, 5, 6 y 7, como son entidades "independientes" al CV, hay que revisar que hayan
        // registros de cada una y así sabremos si esa parte del formuarlio ya está validada.
        $extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->get();
        if(!count($extracurricular_courses) > 0) {
            $completedList['form3'] = false;
        } else {
            $completedList['form3'] = true;
        }

        if($curriculum->certificaciones_obtenidas) {
            $completedList['form4'] = true;
        } 

        $subjects = Subject::where('user_id', '=', $user_id)->get();
        if(!count($subjects) > 0) {
            $completedList['form5'] = false;
        } else {
            $completedList['form5'] = true;
        }

        $pe = PreviousExperience::where('user_id', '=', $user_id)->get();
        if(!count($pe) > 0) {
            $completedList['form6'] = false;
        } else {
            $completedList['form6'] = true;
        }

        $sd = SupportingDocument::where('user_id', '=', $user_id)->get();
        if(!count($sd) > 0) {
            $completedList['form7'] = false;
        } else {
            $completedList['form7'] = true;
        }

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

    /**
     * Muestra el i-ésimo formulario del curriculum bajo este id. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {   
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step1', compact('curriculum'));    
    }

    public function show2($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step2', compact('curriculum')); 
    
    }

    public function show3($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
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

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step4', compact('curriculum')); 
    }

    public function show5($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        $user_id = $curriculum->user_id;

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        return view('cv.show.step5', compact('curriculum', 'subjects')); 
    }

    public function show6($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        return view('cv.show.step6', compact('curriculum', 'previous_exp')); 
    }

    public function show7($id) {
        $curriculum = Curriculum::findOrFail($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $sd_aca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', true)->get();
        $sd_naca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', false)->get();

        return view('cv.show.step7', compact('curriculum', 'sd_aca', 'sd_naca')); 
    }
}
