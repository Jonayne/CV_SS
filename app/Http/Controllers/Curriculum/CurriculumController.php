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
    public function capture1(Request $request, $id=0) {
        $user_id = Auth::user()->id;

        // Con esto revisamos si el rol asociado a este usuario tiene permisos para realizar esto.
        // También revisamos que el usuario no tenga capturado ya su cv.
        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        
        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }

        $request->session()->put('previous_url', 'curricula.capture1');

        return view('cv.capture.step1', compact('curriculum'));
    }

    public function capture2(Request $request, $id=0) {   
        $user_id = Auth::user()->id;

        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        
        $request->session()->put('previous_url', 'curricula.capture2');

        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }
        
        return view('cv.capture.step2', compact('curriculum'));
    }
    
    public function capture3(Request $request, $id=0) {  
        $user_id = Auth::user()->id;

        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
            return redirect(route('home'));
        }

        $technical_extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', true)->get();
        $extracurricular_teaching_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', false)->get();
                                                    
        $request->session()->put('previous_url', 'curricula.capture3');

        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }

        return view('cv.capture.step3', 
                    compact('technical_extracurricular_courses', 
                            'extracurricular_teaching_courses',
                            'curriculum'));
    }

    public function capture4(Request $request, $id=0) {  
        $user_id = Auth::user()->id;

        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }

        $request->session()->put('previous_url', 'curricula.capture4');

        return view('cv.capture.step4', compact('curriculum'));
    }

    public function capture5(Request $request, $id=0) {  
        $user_id = Auth::user()->id;

        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.capture5');

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }

        return view('cv.capture.step5', 
                    compact('subjects', 'curriculum'));
    }

    public function capture6(Request $request, $id=0) {  
        $user_id = Auth::user()->id;

        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        $request->session()->put('previous_url', 'curricula.capture6');

        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }

        return view('cv.capture.step6', 
                    compact('previous_exp', 'curriculum'));
    }

    public function capture7(Request $request, $id=0) {  
        $user_id = Auth::user()->id;
        
        if(!$this->isOwner($id, $user_id) || Gate::denies('capturar-cv')) {
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
        
        if($id != 0) {
            $curriculum = Curriculum::findOrFail($id);
        } else {
            $curriculum = $this->getOrCreateUserCurriculum($user_id);
        }

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
    public function update(CurriculumFormRequest $request, $id) {
        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        // validar que ya este completo o no... 

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
     * Muestran el curriculum bajo el id. 
     * Cada show-i muestra el formulario i.
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

    // Método auxiliar que sirve para que al editar un CV, se valide que los
    // 'formularios' en los que se guardan listas no queden vacíos, y si es el caso,
    // no los deje avanzar a menos que agreguen un elemento.
    // (esto en cursos extracurriculares, lista de temas, documentos probatorios, etc...)
    private function listsEmpty($except = '') {
        $user_id = Auth::user()->id;

        $pe = PreviousExperience::where('user_id', '=', $user_id)->get();
        if($except != 'pe' && !count($pe) > 0) {
            return '/editar_cv_experiencia_previa';
        }

        $subjects = Subject::where('user_id', '=', $user_id)->get();
        if($except != 'subjects' && !count($subjects) > 0) {
            return '/editar_cv_lista_de_temas';
        }

        $extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->get();
        if($except != 'extracurricular_courses' && !count($extracurricular_courses) > 0) {
            return '/editar_cv_cursos_extracurriculares';
        }

        $sd = SupportingDocument::where('user_id', '=', $user_id)->get();
        if($except != 'sd' && !count($sd) > 0) {
            return '/editar_cv_documentos_probatorios';
        }

        return false;
    }

    // Método auxiliar que devuelve el curriculum del usuario indicado, si no existe, lo crea y guarda.
    private function getOrCreateUserCurriculum($user_id) {
        $curriculum = Curriculum::where('user_id', '=', $user_id)->get();
        if(count($curriculum) == 0) {
            $curriculum = new Curriculum();
            $curriculum->user_id = $user_id;
            $curriculum->status = 'en_proceso';
            $curriculum->save();
        }else {
            $curriculum = $curriculum->first();
        }

        return $curriculum;
    }

    // Función auxiliar para determinar si este usuario está permitido
    // para modificar el elemento bajo este id.
    private function isOwner($id, $user_id) {
        if($id != 0) {
            $curri_user_id = Curriculum::findOrFail($id)->user_id;
        } else {
            return true;
        }

        if($user_id == $curri_user_id) {
            return true;
        }

        return false;
    }
}
