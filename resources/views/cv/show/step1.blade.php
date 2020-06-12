@extends('layout')

@section('title', 'Datos personales')

@section('content')

        <h1 class="text-secondary text-center">
                Datos personales&nbsp;
                <svg class="bi bi-person-lines-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                </svg>
        </h1>
        <hr>
        @include('cv.show.partials.nav')
        <br>
        @include('partials.form_errors')
        <div class="container bg-primary text-black py-3">
                <fieldset disabled="disabled">
                        <div class="form-group">
                                <div class="col-md-3 col-sm-3" style="margin-left:auto; margin-right:auto">
                                        <img style="width: 100%" src="/storage/images/{{$curriculum->fotografia}}">
                                </div>
                        </div>  
                        <hr>
                        <div class="form-group form-row">
                                <div class="col-md-4">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre"
                                                value="{{$curriculum->nombre}}">
                                </div>
                                <div class="col-md-4">
                                        <label for="apellido_paterno">Apellido paterno</label>
                                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Ap. paterno"
                                                value="{{$curriculum->apellido_paterno}}">
                                </div>
                                <div class="col-md-4">
                                        <label for="apellido_materno">Apellido materno</label>
                                        <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Ap. materno"
                                                value="{{$curriculum->apellido_materno}}">
                                </div>
                        </div>
                        <hr>
                        <div class="form-group">
                                <div class="form-row">
                                        <div class="col-md-8">
                                                <label for="domicilio_calle">Calle</label>
                                                <input type="text" name="domicilio_calle" id="domicilio_calle" class="form-control" placeholder="Calle" 
                                                        value="{{$curriculum->domicilio_calle}}">
                                        </div>
                                        <div class="col-md-2">
                                                <label for="domicilio_num_ext">Número exterior</label>
                                                <input type="text" name="domicilio_num_ext" id="domicilio_num_ext" class="form-control" placeholder="Núm. exterior" 
                                                value="{{$curriculum->domicilio_num_ext}}">
                                        </div>
                                        <div class="col-md-2">
                                                <label for="domicilio_num_int">Número interior</label>
                                                <input type="text" name="domicilio_num_int" id="domicilio_num_int" class="form-control" placeholder="Núm. interior" 
                                                value="{{$curriculum->domicilio_num_int}}">
                                        </div>
                                </div>
                                <br>
                                <div class="form-row">
                                        <div class="col-md-4">
                                                <label for="domicilio_colonia">Colonia</label>
                                                <input type="text" name="domicilio_colonia" id="domicilio_colonia" class="form-control" placeholder="Colonia" 
                                                value="{{$curriculum->domicilio_colonia}}">
                                        </div>
                                        <div class="col-md-4">
                                                <label for="domicilio_cp">Código Postal</label>
                                                <input type="text" name="domicilio_cp" id="domicilio_cp" class="form-control" placeholder="C.P" 
                                                value="{{$curriculum->domicilio_cp}}">
                                        </div>
                                        <div class="col-md-4">
                                                <label for="domicilio_delegacion">Delegación o Municipio</label>
                                                <input type="text" name="domicilio_delegacion" id="domicilio_delegacion" class="form-control" placeholder="Delegación/Municipio" 
                                                value="{{$curriculum->domicilio_delegacion}}">
                                        </div>        
                                </div>
                        </div>
                        <hr>
                        <div class="form-group">
                                <div class="form-row">
                                        <div class="col-md-3">
                                                <label for="tel_casa">Teléfono de casa</label>
                                                <input type="text" name="tel_casa" id="tel_casa" class="form-control" placeholder="Tél. casa" 
                                                value="{{$curriculum->tel_casa}}">
                                        </div>
                                        <div class="col-md-3">   
                                                <label for="tel_oficina">Teléfono de oficina</label>
                                                <input type="text" name="tel_oficina" id="tel_oficina" class="form-control" placeholder="Tél. oficina" 
                                                value="{{$curriculum->tel_oficina}}">
                                        </div>
                                        <div class="col-md-3">     
                                                <label for="tel_recado">Teléfono de recados</label>
                                                <input type="text" name="tel_recado" id="tel_recado" class="form-control" placeholder="Tél. recados" 
                                                value="{{$curriculum->tel_recado}}">
                                        </div>
                                        <div class="col-md-3">     
                                                <label for="celular">Teléfono celular</label>      
                                                <input type="text" name="celular" id="celular" class="form-control" placeholder="Tél. celular" 
                                                value="{{$curriculum->celular}}">
                                        </div>
                                </div>
                        </div>
                        <hr>
                        <div class="form-group form-row">
                                <div class="col-md-4">  
                                        <label for="email_personal">Email personal</label>
                                        <input type="email" name="email_personal" id="email_personal" class="form-control" placeholder="Email personal" 
                                        value="{{$curriculum->email_personal}}">
                                </div>
                                <div class="col-md-4">  
                                        <label for="email_cursos_linea">Email para cursos en línea</label>
                                        <input type="email" name="email_cursos_linea" id="email_cursos_linea" class="form-control" placeholder="Email para cursos en línea" 
                                        value="{{$curriculum->email_cursos_linea}}">
                                </div>
                                <div class="col-md-4">        
                                        <label for="twitter">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Twitter" 
                                        value="{{$curriculum->twitter}}">
                                </div>
                        </div>        
                        <hr>
                        <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                <input type="date" name="fecha_nacimiento"  id="fecha_nacimiento" class="form-control text-center" 
                                value="{{$curriculum->fecha_nacimiento}}">
                        </div>        
                        <hr>
                        <div class="form-group form-row">
                                <div class="col-md-6">  
                                        <label for="disponibilidad_horario">Disponibilidad de horario</label>
                                        <input type="text" name="disponibilidad_horario" id="disponibilidad_horario" class="form-control" placeholder="Disponibilidad de horario" 
                                        value="{{$curriculum->disponibilidad_horario}}">
                                </div>
                                <div class="col-md-6">  
                                        <label for="dias_disponibles">Días disponibles</label>
                                        <input type="text" name="dias_disponibles" id="dias_disponibles" class="form-control" placeholder="Días disponibles" 
                                        value="{{$curriculum->dias_disponibles}}">
                                </div>
                        </div>
                        <hr>
                        <div class="form-group">
                                <label for="nacionalidad">Nacionalidad</label>
                                <input type="text" name="nacionalidad" id="nacionalidad" class="form-control" placeholder="Nacionalidad" 
                                value="{{$curriculum->nacionalidad}}">
                                <br>
                                <div class="form-row">
                                        <div class="col-md-6">
                                                <label for="rfc">RFC con homoclave</label>     
                                                <input type="text" name="rfc" id="rfc" class="form-control" placeholder="RFC" 
                                                value="{{$curriculum->rfc}}">
                                        </div>
                                        <div class="col-md-6">   
                                                <label for="curp">CURP</label>
                                                <input type="text" name="curp" id="curp" class="form-control" placeholder="CURP" 
                                                value="{{$curriculum->curp}}">
                                        </div>
                                </div>
                                <br>
                                <label for="num_ife">Número IFE</label>
                                <input type="text" name="num_ife" id="num_ife" class="form-control" placeholder="Núm. IFE" 
                                value="{{$curriculum->num_ife}}">
                                <br>
                                <div class="form-row">
                                        <div class="col-md-6">  
                                                <label for="num_proveedor_UNAM">Número de proveedor de la UNAM (sólo si entrega factura)</label>
                                                <input type="text" name="num_proveedor_UNAM" id="num_proveedor_UNAM" class="form-control" placeholder="Núm. de proveedor de la UNAM" 
                                                value="{{$curriculum->num_proveedor_UNAM}}">
                                        </div>
                                        <div class="col-md-6">       
                                                <label for="num_autorizacion_de_impresion">Número de autorización de impresión (SICOFI)</label>
                                                <input type="text" name="num_autorizacion_de_impresion" id="num_autorizacion_de_impresion" class="form-control" placeholder="Núm. de autorización de impresión" 
                                                value="{{$curriculum->num_autorizacion_de_impresion}}">
                                        </div>
                                </div>
                                <label for="tipo_contratacion">Tipo de contratación</label>
                                <select class="form-control" name="tipo_contratacion" id="tipo_contratacion">
                                @if (($curriculum->tipo_contratacion) == 'UNAM')
                                        <option value="UNAM" selected>UNAM</option>
                                        <option value="Externo">Externo</option>
                                @elseif(($curriculum->tipo_contratacion) == 'Externo')
                                        <option value="UNAM">UNAM</option>
                                        <option value="Externo" selected>Externo</option>
                                @else
                                        <option value="" selected>Escoger...</option>
                                        <option value="UNAM">UNAM</option>
                                        <option value="Externo">Externo</option>
                                @endif
                                </select>
                                <br>
                                
                                <label for="ocupacion_actual">Ocupación actual</label>
                                <input type="text" name="ocupacion_actual" id="ocupacion_actual" class="form-control" placeholder="Ocupación actual" 
                                value="{{$curriculum->ocupacion_actual}}">
                                
                                <hr>
                                
                                <label for="registro_secretaria_de_trabajo_y_prevision_social">Registro ante la Secretaría del Trabajo y Previsión Social</label>
                                <input type="text" name="registro_secretaria_de_trabajo_y_prevision_social" id="registro_secretaria_de_trabajo_y_prevision_social" class="form-control" placeholder="Registro ante la STPS" 
                                value="{{$curriculum->registro_secretaria_de_trabajo_y_prevision_social}}">
                                
                                <label for="cursos_impartir_sdpc">Cursos a Impartir para el SDPC (Nombre del curso SEP)</label>
                                <input type="text" name="cursos_impartir_sdpc" id="cursos_impartir_sdpc" class="form-control" placeholder="Nombres de cursos a impartir para el SDPC" 
                                value="{{$curriculum->cursos_impartir_sdpc}}">
                        </div>
                        <hr>
                </fieldset>
                @if ($curriculum->user_id == auth()->user()->id)
                <div class="text-center">
                        <a class="btn btn-info btn-lg" href="{{route('curricula.capture1')}}">Editar CV</a>
                </div>
                @endif
        </div>
@endsection
