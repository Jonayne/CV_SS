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
     * Muestra el formulario i según el método create-i. 
     * Los métodos Postcreate-i validan los datos del formulario i y redirigen a la siguiente
     * pestaña. (Algunos formularios no llevan un form pues desde el inicio salen de la BD
     * y ahí mismo se agregan/actualizan, por eso algunos create no tienen su método 
     * Postcreate correspondiente)
     *
     * @return \Illuminate\Http\Response
     */
    public function create1(Request $request) {
        $user_id = Auth::user()->id;
        // Con esto revisamos si el rol asociado a este usuario tiene permisos para realizar esto.
        // También revisamos que el usuario no tenga capturado ya su cv.
        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        // esta lista sirve para tener control en como se van desbloqueando las pestañas en el formulario.
        if(empty($request->session()->get('disabledList'))) {
            $disabledList =  [  'create2_disabled' => 'disabled', 'create3_disabled' => 'disabled', 
                                'create4_disabled' => 'disabled', 'create5_disabled' => 'disabled', 
                                'create6_disabled' => 'disabled', 'create7_disabled' => 'disabled'
                             ];
            $request->session()->put('disabledList', $disabledList);
        }else {
            $disabledList = $request->session()->get('disabledList');
        }

        $request->session()->put('previous_url', 'curricula.create1');
        return view('cv.create.step1');
    }

    public function Postcreate1(CurriculumFormRequest $request) {
        $validatedData = $request->validated();

        // Guardamos la imagen en nuestro sistema de archivos, en la BD se guardará el hash de ésta.
        if($request->file('fotografia') ) {
            $hashName = $request->file('fotografia')->hashName();

            // Si ya había una fotografía y la estamos actualizando...
            if($request->session()->get('curriculum')) {
                $oldHashName = $request->session()->get('curriculum')->fotografia;
                if($oldHashName) {
                    // Borramos la foto anterior antes de poner la nueva.
                    Storage::delete(['public/images/'.$oldHashName]);
                }
            }
            
            $path = $request->file('fotografia')->store('public/images');
            $validatedData['fotografia'] = $hashName;
        }

        if(empty($request->session()->get('curriculum'))) {
            $curriculum = new \App\Curriculum();
        }else {
            $curriculum = $request->session()->get('curriculum');
        }
        
        $curriculum->fill($validatedData);
        $request->session()->put('curriculum', $curriculum);
        
        $disabledList = $request->session()->get('disabledList');
        $disabledList['create2_disabled'] = '';
        $request->session()->put('disabledList', $disabledList);

        return redirect('/capturar_cv_datos_academicos');
    }

    public function create2(Request $request) {   
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        // revisamos si este formulario ya está desbloqueado (es decir, ya completamos el anterior)
        if(empty($request->session()->get('disabledList')) || 
            ($request->session()->get('disabledList'))['create2_disabled'] === 'disabled')  {
            return redirect('/capturar_cv_datos_personales')->with('status', 'No ha terminado de rellenar este formulario')
                                                            ->with('status_color', 'danger');
        }
        
        $request->session()->put('previous_url', 'curricula.create2');

        return view('cv.create.step2');
    }

    public function Postcreate2(CurriculumFormRequest $request) {
        $validatedData = $request->validated();

        if(empty($request->session()->get('curriculum'))) {
            $curriculum = new \App\Curriculum();
        }else {
            $curriculum = $request->session()->get('curriculum');
        }

        $curriculum->fill($validatedData);
        $request->session()->put('curriculum', $curriculum);

        $disabledList = $request->session()->get('disabledList');
        $disabledList['create3_disabled'] = '';
        $request->session()->put('disabledList', $disabledList);

        return redirect('/capturar_cv_cursos_extracurriculares');
    }
    
    public function create3(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'));
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        if(empty($request->session()->get('disabledList')) || 
            ($request->session()->get('disabledList'))['create3_disabled'] === 'disabled')  {
            return redirect('/capturar_cv_datos_academicos')->with('status', 'No ha terminado de rellenar este formulario')
                                                            ->with('status_color', 'danger');
        }

        $technical_extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', true)->get();
        $extracurricular_teaching_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', false)->get();
                                                    
        $request->session()->put('previous_url', 'curricula.create3');

        return view('cv.create.step3', 
                    compact('technical_extracurricular_courses', 
                            'extracurricular_teaching_courses'));
    }

    public function create4(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        $extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->get();

        if(!count($extracurricular_courses) > 0) {
            return redirect('/capturar_cv_cursos_extracurriculares')->with('status', 'Agregue al menos un curso extracurricular.')
                                                                    ->with('status_color', 'danger');;
        
        }else{
            $disabledList = $request->session()->get('disabledList');
            $disabledList['create4_disabled'] = '';
            $request->session()->put('disabledList', $disabledList);
        }

        if(empty($request->session()->get('disabledList')) || 
            ($request->session()->get('disabledList'))['create4_disabled'] === 'disabled')  {
            return redirect('/capturar_cv_cursos_extracurriculares')->with('status', 'No ha terminado de rellenar este formulario')
                                                                    ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.create4');

        return view('cv.create.step4');
    }

    public function Postcreate4(CurriculumFormRequest $request) {
        $validatedData = $request->validated();

        if(empty($request->session()->get('curriculum'))) {
            $curriculum = new \App\Curriculum();
        }else {
            $curriculum = $request->session()->get('curriculum');
        }

        $disabledList = $request->session()->get('disabledList');
        $disabledList['create5_disabled'] = '';
        $request->session()->put('disabledList', $disabledList);

        $curriculum->fill($validatedData);
        $request->session()->put('curriculum', $curriculum);

        return redirect('/capturar_cv_lista_de_temas');
    }

    public function create5(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        if(empty($request->session()->get('disabledList')) || 
            ($request->session()->get('disabledList'))['create5_disabled'] === 'disabled')  {
            return redirect('/capturar_cv_certificaciones_obtenidas')->with('status', 'No ha terminado de rellenar este formulario')
                                                                     ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.create5');

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        return view('cv.create.step5', 
                    compact('subjects'));
    }

    public function create6(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        if(!count($subjects) > 0) {
            return redirect('/capturar_cv_lista_de_temas')->with('status', 'Agregue al menos un tema a impartir')
                                                          ->with('status_color', 'danger');
        }else{
            $disabledList = $request->session()->get('disabledList');
            $disabledList['create6_disabled'] = '';
            $request->session()->put('disabledList', $disabledList);
        }

        if(empty($request->session()->get('disabledList')) || 
            ($request->session()->get('disabledList'))['create6_disabled'] === 'disabled')  {
            return redirect('/capturar_cv_lista_de_temas')->with('status', 'No ha terminado de rellenar este formulario')
                                                          ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.create6');

        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        return view('cv.create.step6', 
                    compact('previous_exp'));
    }

    public function create7(Request $request) {  
        $user_id = Auth::user()->id;
        
        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) > 0) {
            return redirect(route('home'))->with('status', 'Usted ya ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        $pe = PreviousExperience::where('user_id', '=', $user_id)->get();

        if(!count($pe) > 0) {
            return redirect('/capturar_cv_experiencia_previa')->with('status', 'Registre al menos una experiencia profesional previa')
                                                              ->with('status_color', 'danger');
        }else{
            $disabledList = $request->session()->get('disabledList');
            $disabledList['create7_disabled'] = '';
            $request->session()->put('disabledList', $disabledList);
        }

        if(empty($request->session()->get('disabledList')) || 
            ($request->session()->get('disabledList'))['create7_disabled'] === 'disabled')  {
            return redirect('/capturar_cv_experiencia_previa')->with('status', 'No ha terminado de rellenar este formulario')
                                                              ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.create7');

        // documento probatorio académico
        $sd_aca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', true)->get();
        // documento probatorio no académico
        $sd_naca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', false)->get();

        return view('cv.create.step7', 
                    compact('sd_aca', 'sd_naca'));
    }

    /**
     * Guarda en la BD el curriculum que se estuvo capturando.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if(Gate::denies('capturar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $user_id = Auth::user()->id;

        $sd = SupportingDocument::where('user_id', '=', $user_id)->get();

        if(!count($sd) > 0) {
            return redirect('/capturar_cv_documentos_probatorios')->with('status', 'Agregue los documentos probatorios solicitados.')
                                                                  ->with('status_color', 'danger');
        }

        $curriculum = $request->session()->get('curriculum');
        $curriculum->user_id = $user_id;
        $curriculum->save();

        return redirect(route('home'))->with('status', 'Su curriculum ha sido capturado con éxito.')
                                      ->with('status_color', 'success');
    }

    /**
     * TERMINAN MÉTODOS CREATE----------------------------------------------------------------------
     * */


    /**
     * Muestra el curricculum de este usuario y permite su edición. Cada edit-i 
     * muestra el curriculum i.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit1(Request $request) {
        $user_id = Auth::user()->id;
        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        // Revisamos que el usuario ya haya capturado su CV antes de entrar aquí.
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }
        // Revisamos que los formularios de tipo lista (como cursos extracurriculares, docs. probatorios, etc)
        // al ser modificados no hayan quedado vacíos, si es así, se lo notificamos al usuario.
        $link = $this->listsEmpty();
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $actual_curriculum = Curriculum::where('user_id', '=', $user_id)->get();

        // Guardaremos el curriculum en la sesión antes de guardarlo en la BD.
        if(empty($request->session()->get('curriculum'))) {
            $curriculum = $actual_curriculum->first();
            $request->session()->put('curriculum', $curriculum);
        }else {
            $curriculum = $request->session()->get('curriculum');
        }

        // No podemos usar back() porque si hay un error en la validación, se sobreescribe la URL 
        // anterior. La mejor forma que encontré de solucionar esto fue establecer la URL a la que se 
        // regresará por defecto según la pestaña que tengamos abierta.
        $request->session()->put('previous_url', 'curricula.edit');

        $curriculum = $request->session()->get('curriculum');

        return view('cv.edit.step1', compact('curriculum'));
    }

    public function edit2(Request $request) {   
        $user_id = Auth::user()->id;

        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        $link = $this->listsEmpty();
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $request->session()->put('previous_url', 'curricula.edit2');

        $curriculum = $request->session()->get('curriculum');

        return view('cv.edit.step2', compact('curriculum'));
    }
    
    public function edit3(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }
        $link = $this->listsEmpty('extracurricular_courses');
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $curriculum = $request->session()->get('curriculum');        

        $request->session()->put('previous_url', 'curricula.edit3');

        $technical_extracurricular_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', true)->get();
        $extracurricular_teaching_courses = ExtracurricularCourse::where('user_id', '=', $user_id)->
                                                    where('es_curso_tecnico', '=', false)->get();
        
        return view('cv.edit.step3', 
                    compact('curriculum', 
                            'technical_extracurricular_courses', 
                            'extracurricular_teaching_courses'));
    }

    public function edit4(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        $link = $this->listsEmpty();
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $curriculum = $request->session()->get('curriculum');

        $request->session()->put('previous_url', 'curricula.edit4');

        return view('cv.edit.step4', 
                    compact('curriculum'));
    }

    public function edit5(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }

        $link = $this->listsEmpty('subjects');
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $curriculum = $request->session()->get('curriculum');

        $request->session()->put('previous_url', 'curricula.edit5');

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        return view('cv.edit.step5', 
                    compact('curriculum', 'subjects'));
    }

    public function edit6(Request $request) {  
        $user_id = Auth::user()->id;

        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }
        $link = $this->listsEmpty('pe');
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }
        
        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        $curriculum = $request->session()->get('curriculum');

        $request->session()->put('previous_url', 'curricula.edit6');

        return view('cv.edit.step6', 
                    compact('curriculum', 'previous_exp'));
    }

    public function edit7(Request $request) {  
        $user_id = Auth::user()->id;
        
        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        elseif(count(Curriculum::where('user_id', '=', $user_id)->get()) == 0) {
            return redirect(route('home'))->with('status', 'Aún no ha capturado su curriculum.')
                                          ->with('status_color', 'danger');
        }
        $link = $this->listsEmpty('sd');
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $sd_aca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', true)->get();
        $sd_naca = SupportingDocument::where('user_id', '=', $user_id)->
                                  where('es_documento_academico', '=', false)->get();

        $curriculum = $request->session()->get('curriculum');

        $request->session()->put('previous_url', 'curricula.edit7');

        return view('cv.edit.step7', 
                    compact('curriculum', 'sd_aca', 'sd_naca'));
    }

    /**
     * Actualiza el curriculum.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CurriculumFormRequest $request, $id) {
        if(Gate::denies('editar-cv')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }
        
        $link = $this->listsEmpty();
        if($link) {
            return redirect($link)->with('status', 'Esta sección no debe quedar vacía')
                                  ->with('status_color', 'danger');
        }

        $validatedData = $request->validated();
        // Si cambiamos la imagen de perfil es necesario este caso, pues tenemos que borrar la imagen
        // antigua y poner la nueva, de otra manera gastaríamos espacio en el sistema de archivos.
        if($request->input('formNum') == 1) {
            if($request->file('fotografia') ) {
                $hashName = $request->file('fotografia')->hashName();

                if($request->session()->get('curriculum'))
                {
                    $oldHashName = $request->session()->get('curriculum')->fotografia;
                    if($oldHashName) {
                        Storage::delete(['public/images/'.$oldHashName]);
                    }
                }
                
                $path = $request->file('fotografia')->store('public/images');
                $validatedData['fotografia'] = $hashName;
            }
        }

        $cv = Curriculum::findOrFail($id);
        $cv->update($validatedData);
        $request->session()->put('curriculum', $cv);

        return redirect(route($request->session()->get('previous_url')))
                                 ->with('status', 'Información actualizada con éxito.')
                                 ->with('status_color', 'success');
    }

    /**
     * TERMINAN MÉTODOS EDIT----------------------------------------------------------------------
     * */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    /**
     * Muestran el curriculum bajo el id. 
     * Cada show-i muestra el formulario i.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {   
        $curriculum = Curriculum::find($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step1', compact('curriculum'));    
    }

    public function show2($id) {
        $curriculum = Curriculum::find($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step2', compact('curriculum')); 
    
    }

    public function show3($id) {
        $curriculum = Curriculum::find($id);

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
        $curriculum = Curriculum::find($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        return view('cv.show.step4', compact('curriculum')); 
    }

    public function show5($id) {
        $curriculum = Curriculum::find($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }
        $user_id = $curriculum->user_id;

        $subjects = Subject::where('user_id', '=', $user_id)->get();

        return view('cv.show.step5', compact('curriculum', 'subjects')); 
    }

    public function show6($id) {
        $curriculum = Curriculum::find($id);

        if( !$this->isUsersCurriculum($curriculum) && Gate::denies('mostrar-cvs')) {
            return redirect(route('home'))->with('status', 'No tiene permisos para realizar esta acción')
                                          ->with('status_color', 'danger');
        }

        $user_id = $curriculum->user_id;

        $previous_exp = PreviousExperience::where('user_id', '=', $user_id)->get();

        return view('cv.show.step6', compact('curriculum', 'previous_exp')); 
    }

    public function show7($id) {
        $curriculum = Curriculum::find($id);

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
     * TERMINAN MÉTODOS SHOW ----------------------------------------------------------------------
     * */

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
}
