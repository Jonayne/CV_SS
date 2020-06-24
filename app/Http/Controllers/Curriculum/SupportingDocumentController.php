<?php

namespace App\Http\Controllers\Curriculum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CurriculumFormRequest;
use App\SupportingDocument;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SupportingDocumentController extends Controller {

    protected $nombres_docs = ['Título', 'Cédula profesional', 'Historial académico',
                                'Comprobante de curso técnico', 'Comprobante de curso de formación docente',
                                '(Proyecto SEP) Comprobante por impartir curso de la SEP',
                                'Constancia de situación fiscal', 'CURP', 'IFE', 
                                '(Personal de la UNAM) Último talón de pago'];
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

        

        return view('supporting_document.create', 
                        ['sd' => new SupportingDocument(), 
                          'nombres_docs' => $this->nombres_docs]);
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

        $es_documento_academico = in_array($validation['nombre'], ['Título', 'Cédula profesional', 
                                                                   'Historial académico', 'Comprobante de curso técnico', 
                                                                   'Comprobante de curso de formación docente', 
                                                                   '(Proyecto SEP) Comprobante por impartir curso de la SEP']);

        $validation = Arr::add($validation, 'es_documento_academico', $es_documento_academico);

        if($request->file('documento') ) {
            $hashName = $request->file('documento')->hashName();
            
            $path = $request->file('documento')->store('public/supporting_documents');
            $validation['documento'] = $hashName;
        }
       
        SupportingDocument::create($validation);
        
        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))->with('status', 'El documento probatorio fue guardado con éxito.')
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

        $sd = SupportingDocument::findOrFail($id);

        $nombres_docs = $this->nombres_docs;
        
        return view('supporting_document.edit', compact('sd', 'nombres_docs'));
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

        $validation = $request->validated();
        $sd = SupportingDocument::findOrFail($id);

        if($request->file('documento')) {
            $oldHashName = $sd->documento;
            if($oldHashName) {
                Storage::delete(['public/supporting_documents/'.$oldHashName]);
            }

            $hashName = $request->file('documento')->hashName();
            
            $path = $request->file('documento')->store('public/supporting_documents');
            $validation['documento'] = $hashName;
        }

        $validation['es_documento_academico'] = in_array($validation['nombre'], ['Título', 'Cédula profesional', 
                                                                   'Historial académico', 'Comprobante de curso técnico', 
                                                                   'Comprobante de curso de formación docente', 
                                                                   '(Proyecto SEP) Comprobante por impartir curso de la SEP']);

        $sd->update($validation);

        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))
                         ->with('status', 'El documento probatorio fue actualizado con éxito.')
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
        
        $sd = SupportingDocument::findOrFail($id);
        
        $oldHashName = $sd->documento;
        if($oldHashName) {
            Storage::delete(['public/supporting_documents/'.$oldHashName]);
        }
        $sd->delete();

        return redirect()->route('curricula.capture', $request->session()->get('previous_url'))->
                                        with('status', 'El documento probatorio fue eliminado con éxito.')
                                        ->with('status_color', 'success');
    }

    // Función auxiliar para determinar si este usuario está permitido
    // para modificar el elemento bajo este id.
    private function isOwner($id) {
        $user_id = Auth::user()->id;
        $subject_user_id = SupportingDocument::findOrFail($id)->user_id;

        if($user_id == $subject_user_id) {
            return true;
        }

        return false;
    }
}
