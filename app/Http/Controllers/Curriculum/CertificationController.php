<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use App\Certification;
use App\Http\Requests\CurriculumFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CertificationController extends Controller {
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
        
        return view('certification.create', 
                        ['certification' => new Certification()]);
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
            Certification::create($validation);
        }
        
        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))->with('status', 'La certificación fue guardada con éxito.')
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

        $certification = Certification::findOrFail($id);

        return view('certification.edit', compact('certification'));
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

        $cert = Certification::findOrFail($id);
        $cert->update($request->validated());

        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))
                                            ->with('status', 'La certificación fue actualizada con éxito.')
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
        
        $cert = Certification::findOrFail($id);
        $cert->delete();

        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))
                                    ->with('status', 'La certificación fue eliminada con éxito.')
                                                     ->with('status_color', 'success');
    }

    // Función auxiliar para determinar si este usuario está permitido
    // para modificar el elemento bajo este id.
    private function isOwner($id) {
        $user_id = Auth::user()->id;
        $certification_user_id = Certification::findOrFail($id)->user_id;

        if($user_id == $certification_user_id) {
            return true;
        }

        return false;
    }
}
