<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use App\ExtracurricularCourse;
use App\Http\Requests\CurriculumFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ExtracurricularCourseController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {   
        $this->middleware('auth');

    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {   
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }
        
        return view('extracurricular_course.create', 
                        ['course' => new ExtracurricularCourse()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CurriculumFormRequest $request) {   
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $user_id = Auth::user()->id;
        $validation = Arr::add($request->validated(), 'user_id', $user_id);
        ExtracurricularCourse::create($validation);
        
        return redirect()->route($request->session()->get('previous_url'))->with('status', 'El curso extracurricular fue guardado con éxito.')
                                                     ->with('status_color', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {   
        if(!$this->isOwner($id) || Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $course = ExtracurricularCourse::findOrFail($id);

        return view('extracurricular_course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update($id, CurriculumFormRequest $request) {      
        if(!$this->isOwner($id) || Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $course = ExtracurricularCourse::findOrFail($id);
        $course->update($request->validated());

        return redirect()->route($request->session()->get('previous_url'))->with('status', 'El curso extracurricular fue actualizado con éxito.')
                                                     ->with('status_color', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {   
        if(!$this->isOwner($id) || Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }
        
        $course = ExtracurricularCourse::findOrFail($id);
        $course->delete();

        return redirect()->route($request->session()->get('previous_url'))->with('status', 'El curso extracurricular fue eliminado con éxito.')
                                                     ->with('status_color', 'success');
    }

    // Función auxiliar para determinar si este usuario está permitido
    // para modificar el elemento bajo este id.
    private function isOwner($id) {
        $user_id = Auth::user()->id;
        $course_user_id = ExtracurricularCourse::findOrFail($id)->user_id;

        if($user_id == $course_user_id) {
            return true;
        }

        return false;
    }

}
