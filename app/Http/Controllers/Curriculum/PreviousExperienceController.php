<?php

namespace App\Http\Controllers\Curriculum;

use App\Curriculum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CurriculumFormRequest;
use App\PreviousExperience;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PreviousExperienceController extends Controller {   

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if(Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }
        $user_id = Auth::user()->id;
        $curriculum = Curriculum::select('proyecto_sep')->where('user_id', '=', $user_id)->
                                    where('proyecto_sep', '=', true)->get()->first();

        return view('previous_experience.create', 
                        ['pe' => new PreviousExperience(),
                        'curriculum' => $curriculum,
                        'nombres_cursos' => $this->lista_nombres_cursos_sep]);
    
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

        $random_token = $request->session()->get('random_token');
        if($random_token && !empty($random_token) && (hash_equals($request->unique_token, $random_token))) {
            $request->session()->forget('random_token');
            $user_id = Auth::user()->id;
            $validation = Arr::add($request->validated(), 'user_id', $user_id);
            $validation['periodo'] = " " . $validation['periodo'];
            PreviousExperience::create($validation);
        }
        
        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))
                                                ->with('status', 'La experiencia profesional previa fue guardada con éxito.')
                                                     ->with('status_color', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if(!$this->isOwner($id) || Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $user_id = Auth::user()->id;
        $pe = PreviousExperience::findOrFail($id);
        $curriculum = Curriculum::select('proyecto_sep')->where('user_id', '=', $user_id)->
                                    where('proyecto_sep', '=', true)->get()->first();
        $nombres_cursos = $this->lista_nombres_cursos_sep;
        return view('previous_experience.edit', compact('pe', 'curriculum', 'nombres_cursos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, CurriculumFormRequest $request) {
        if(!$this->isOwner($id) || Gate::denies('capturar-cv')) {
            return redirect()->route('home')->with('status', 'No tiene permisos para realizar esta acción.')
                                          ->with('status_color', 'danger');
        }

        $course = PreviousExperience::findOrFail($id);
        $course->update($request->validated());

        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))
                                    ->with('status', 'La experiencia profesional previa fue actualizada con éxito.')
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
        
        $course = PreviousExperience::findOrFail($id);
        $course->delete();

        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))
                                            ->with('status', 'La experiencia profesional previa fue eliminada con éxito.')
                                                     ->with('status_color', 'success');
    }

    // Función auxiliar para determinar si este usuario está permitido
    // para modificar el elemento bajo este id.
    private function isOwner($id) {
        $user_id = Auth::user()->id;
        $pe_user_id = PreviousExperience::findOrFail($id)->user_id;

        if($user_id == $pe_user_id) {
            return true;
        }

        return false;
    }

}
