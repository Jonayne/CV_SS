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
        @include('cv.capture.partials.cv_status')
        <hr>
        @include('cv.capture.partials.nav')
        <br>
        @include('partials.form_errors')
        
        <form action="{{route('curricula.update', $curriculum)}}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="container bg-primary text-black py-3">
                        <h6 class="text-right required font-italic"> Campos obligatorios: </h6>
                        <hr>
                        <div class="alert alert-secondary text-center">
                                <svg class="bi bi-person-bounding-box" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                                        <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                        </div>
                        <div class="form-group">
                                @if ($curriculum->fotografia)
                                        <input type="hidden" id='edit' name="edit" value="true">
                                        <div class="col-md-3 col-sm-3" style="margin-left:auto; margin-right:auto">
                                                <img style="width: 100%" src="/storage/images/{{$curriculum->fotografia}}">
                                        </div>
                                        <br>
                                        <label for="fotografia">Cambiar de fotografía</label>
                                        <input type="file" name="fotografia" id="fotografia" class="form-control-file"> 
                                @else
                                        <label class="required" for="fotografia">Fotografía</label>
                                        <input type="file" name="fotografia" id="fotografia" class="form-control-file">  
                                @endif
                        </div>  
                        <hr>

                        <div class="form-group form-row">
                                <div class="col-md-4">
                                        <label class="required" for="nombre">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre"
                                                value="{{ (old('nombre', $curriculum->nombre)) ?? ucfirst(auth()->user()->nombre) }}">
                                </div>
                                <div class="col-md-4">
                                        <label class="required" for="apellido_paterno">Apellido paterno</label>
                                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Ap. paterno"
                                                value="{{ (old('apellido_paterno', $curriculum->apellido_paterno)) ?? ucfirst(auth()->user()->apellido_paterno) }}">
                                </div>
                                <div class="col-md-4">
                                        <label class="required" for="apellido_materno">Apellido materno</label>
                                        <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Ap. materno"
                                                value="{{ (old('apellido_materno', $curriculum->apellido_materno)) ?? ucfirst(auth()->user()->apellido_materno) }}">
                                </div>
                        </div>
                        <hr>
                        <div class="alert alert-secondary text-center">
                                <svg class="bi bi-house-door-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.5 10.995V14.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11c0-.25-.25-.5-.5-.5H7c-.25 0-.5.25-.5.495z"/>
                                        <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                                </svg>
                        </div>
                        <div class="form-group">
                                <div class="form-row">
                                        <div class="col-md-8">
                                                <label class="required" for="domicilio_calle">Calle</label>
                                                <input type="text" name="domicilio_calle" id="domicilio_calle" class="form-control" placeholder="Calle" 
                                                        value="{{ old('domicilio_calle', $curriculum->domicilio_calle)}}">
                                        </div>
                                        <div class="col-md-2">
                                                <label class="required" for="domicilio_num_ext">Número exterior</label>
                                                <input type="text" name="domicilio_num_ext" id="domicilio_num_ext" class="form-control" placeholder="Núm. exterior" 
                                                        value="{{ old('domicilio_num_ext', $curriculum->domicilio_num_ext)}}">
                                        </div>
                                        <div class="col-md-2">
                                                <label for="domicilio_num_int">Número interior</label>
                                                <input type="text" name="domicilio_num_int" id="domicilio_num_int" class="form-control" placeholder="Núm. interior" 
                                                        value="{{ old('domicilio_num_int',$curriculum->domicilio_num_int)}}">
                                        </div>
                                </div>
                                <br>
                                <div class="form-row">
                                        <div class="col-md-4">
                                                <label class="required" for="domicilio_colonia">Colonia</label>
                                                <input type="text" name="domicilio_colonia" id="domicilio_colonia" class="form-control" placeholder="Colonia" 
                                                        value="{{ old('domicilio_colonia',$curriculum->domicilio_colonia)}}">
                                        </div>
                                        <div class="col-md-4">
                                                <label class="required" for="domicilio_cp">Código Postal</label>
                                                <input type="text" name="domicilio_cp" id="domicilio_cp" class="form-control" placeholder="C.P" 
                                                        value="{{ old('domicilio_cp',$curriculum->domicilio_cp)}}">
                                        </div>
                                        <div class="col-md-4">
                                                <label class="required" for="domicilio_delegacion">Delegación o Municipio</label>
                                                <input type="text" name="domicilio_delegacion" id="domicilio_delegacion" class="form-control" placeholder="Delegación/Municipio" 
                                                        value="{{ old('domicilio_delegacion',$curriculum->domicilio_delegacion)}}">
                                        </div>        
                                </div>
                        </div>
                        <hr>
                        <div class="alert alert-secondary text-center">
                                <svg class="bi bi-chat" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                </svg>
                        </div>
                        <div class="form-group">
                                <div class="form-row">
                                        <div class="col-md-3">
                                                <label class="required" for="tel_casa">Teléfono de casa</label>
                                                <input type="text" name="tel_casa" id="tel_casa" class="form-control" placeholder="Tél. casa" 
                                                        value="{{ old('tel_casa',$curriculum->tel_casa)}}">
                                        </div>
                                        <div class="col-md-3">   
                                                <label class="required" for="tel_oficina">Teléfono de oficina</label>
                                                <input type="text" name="tel_oficina" id="tel_oficina" class="form-control" placeholder="Tél. oficina" 
                                                        value="{{ old('tel_oficina',$curriculum->tel_oficina)}}">
                                        </div>
                                        <div class="col-md-3">     
                                                <label class="required" for="tel_recado">Teléfono de recados</label>
                                                <input type="text" name="tel_recado" id="tel_recado" class="form-control" placeholder="Tél. recados" 
                                                        value="{{ old('tel_recado',$curriculum->tel_recado)}}">
                                        </div>
                                        <div class="col-md-3">     
                                                <label class="required" for="celular">Teléfono celular</label>      
                                                <input type="text" name="celular" id="celular" class="form-control" placeholder="Tél. celular" 
                                                        value="{{ old('celular',$curriculum->celular)}}">
                                        </div>
                                </div>
                        </div>
                        <hr>
                        <div class="alert alert-secondary text-center">
                                <svg class="bi bi-envelope-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                </svg>
                        </div>
                        <div class="form-group form-row">
                                <div class="col-md-4">  
                                        <label class="required" for="email_personal">Email personal</label>
                                        <input type="email" name="email_personal" id="email_personal" class="form-control" placeholder="Email personal" 
                                                value="{{ old('email_personal',$curriculum->email_personal ?? auth()->user()->email)}}">
                                </div>
                                <div class="col-md-4">  
                                        <label for="email_cursos_linea">Email para cursos en línea</label>
                                        <input type="email" name="email_cursos_linea" id="email_cursos_linea" class="form-control" placeholder="Email para cursos en línea" 
                                                value="{{ old('email_cursos_linea',$curriculum->email_cursos_linea)}}">
                                </div>
                                <div class="col-md-4">        
                                        <label for="twitter">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" class="form-control" placeholder="Twitter" 
                                                value="{{ old('twitter',$curriculum->twitter)}}">
                                </div>
                        </div>        
                        <hr>
                        <div class="alert alert-secondary text-center">
                                <svg class="bi bi-calendar3" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                        <path fill-rule="evenodd" d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                        </div>
                        <div class="form-group">
                                <label class="required" for="fecha_nacimiento">Fecha de nacimiento</label>
                                <input type="date" name="fecha_nacimiento"  id="fecha_nacimiento" class="form-control text-center" 
                                        value="{{ old('fecha_nacimiento',$curriculum->fecha_nacimiento)}}">
                        </div>        
                        <hr>
                        <div class="form-group form-row">
                                <div class="col-md-6">  
                                        <label class="required" for="disponibilidad_horario">Disponibilidad de horario</label>
                                        <input type="text" name="disponibilidad_horario" id="disponibilidad_horario" class="form-control" placeholder="Disponibilidad de horario" 
                                                value="{{ old('disponibilidad_horario',$curriculum->disponibilidad_horario)}}">
                                </div>
                                <div class="col-md-6">  
                                        <label class="required" for="dias_disponibles">Días disponibles</label>
                                        <input type="text" name="dias_disponibles" id="dias_disponibles" class="form-control" placeholder="Días disponibles" 
                                                value="{{ old('dias_disponibles',$curriculum->dias_disponibles)}}">
                                </div>
                        </div>
                        <hr>
                        <div class="alert alert-secondary text-center">
                                <svg class="bi bi-person" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                </svg>
                        </div>
                        <div class="form-group">
                                <label class="required" for="nacionalidad">Nacionalidad</label>
                                <input type="text" name="nacionalidad" id="nacionalidad" class="form-control" placeholder="Nacionalidad" 
                                        value="{{ old('nacionalidad',$curriculum->nacionalidad)}}">
                                <br>
                                <div class="form-row">
                                        <div class="col-md-6">
                                                <label class="required" for="rfc">RFC con homoclave</label>     
                                                <input type="text" name="rfc" id="rfc" class="form-control" placeholder="RFC" 
                                                        value="{{ old('rfc',$curriculum->rfc)}}">
                                        </div>
                                        <div class="col-md-6">   
                                                <label class="required" for="curp">CURP</label>
                                                <input type="text" name="curp" id="curp" class="form-control" placeholder="CURP" 
                                                        value="{{ old('curp',$curriculum->curp)}}">
                                        </div>
                                </div>
                                <br>
                                <label class="required" for="num_ife">Número IFE</label>
                                <input type="text" name="num_ife" id="num_ife" class="form-control" placeholder="Núm. IFE" 
                                        value="{{ old('num_ife',$curriculum->num_ife)}}">
                                <br>
                                <div class="form-row">
                                        <div class="col-md-6">  
                                                <label for="num_proveedor_UNAM">Número de proveedor de la UNAM (sólo si entrega factura)</label>
                                                <input type="text" name="num_proveedor_UNAM" id="num_proveedor_UNAM" class="form-control" placeholder="Núm. de proveedor de la UNAM" 
                                                        value="{{ old('num_proveedor_UNAM',$curriculum->num_proveedor_UNAM)}}">
                                        </div>
                                        <div class="col-md-6">       
                                                <label for="num_autorizacion_de_impresion">Número de autorización de impresión (SICOFI)</label>
                                                <input type="text" name="num_autorizacion_de_impresion" id="num_autorizacion_de_impresion" class="form-control" placeholder="Núm. de autorización de impresión" 
                                                        value="{{ old('num_autorizacion_de_impresion',$curriculum->num_autorizacion_de_impresion)}}">
                                        </div>
                                </div>
                                <br>
                                <label class="required" for="tipo_contratacion">Tipo de contratación</label>
                                <select class="form-control" name="tipo_contratacion" id="tipo_contratacion">
                                        @if (( old('tipo_contratacion',$curriculum->tipo_contratacion)) == 'UNAM')
                                                <option value="UNAM" selected>UNAM</option>
                                                <option value="Externo">Externo</option>
                                        @elseif(( old('tipo_contratacion',$curriculum->tipo_contratacion)) == 'Externo')
                                                <option value="UNAM">UNAM</option>
                                                <option value="Externo" selected>Externo</option>
                                        @else
                                                <option value="" selected>Escoger...</option>
                                                <option value="UNAM">UNAM</option>
                                                <option value="Externo">Externo</option>
                                        @endif
                                </select>
                                <br>
                                
                                <label class="required" for="ocupacion_actual">Ocupación actual</label>
                                <input type="text" name="ocupacion_actual" id="ocupacion_actual" class="form-control" placeholder="Ocupación actual" 
                                        value="{{ old('ocupacion_actual',$curriculum->ocupacion_actual)}}">
                                
                                <hr>
                                <h3 class="text-secondary text-center font-weight-bold"> Sólo para participantes de proyecto SEP </h3>
                                <div class="form-check text-center mb-3">
                                        <label class="form-check-label">
                                                <input type="checkbox" name="proyecto_sep" id="proyecto_sep" class="form-check-input"
                                                     {{old('proyecto_sep', $curriculum->proyecto_sep) 
                                                        || old('cursos_impartir_sdpc', $curriculum->cursos_impartir_sdpc)
                                                        || old('registro_secretaria_de_trabajo_y_prevision_social', $curriculum->registro_secretaria_de_trabajo_y_prevision_social) ? 
                                                                'checked=true' : ''}}>
                                                Participo en Proyecto SEP
                                        </label>
                                </div>

                                <label for="registro_secretaria_de_trabajo_y_prevision_social">Registro ante la Secretaría del Trabajo y Previsión Social</label>
                                <input type="text" name="registro_secretaria_de_trabajo_y_prevision_social" id="registro_secretaria_de_trabajo_y_prevision_social" class="form-control" placeholder="Registro ante la STPS" 
                                        value="{{ old('registro_secretaria_de_trabajo_y_prevision_social',$curriculum->registro_secretaria_de_trabajo_y_prevision_social)}}">
                                
                                <br>
                                <label class="required" for="cursos_impartir_sdpc">Cursos a Impartir para el SDPC (Nombre del curso SEP)</label> 
                                <select class="form-control" name="cursos_impartir_sdpc[]" id="cursos_impartir_sdpc" aria-describedby="nombre_cursos_help_block" multiple>
                                        @foreach ($element as $curso)
                                            <option value="{{$curso}}"
                                                @if (old('cursos_impartir_sdpc', $curriculum->cursos_impartir_sdpc))
                                                    {{ in_array($curso, old('cursos_impartir_sdpc', explode(',',$curriculum->cursos_impartir_sdpc))) ?
                                                                 'selected' : '' }}
                                                @endif
                                            >{{$curso}}</option>
                                        @endforeach
                                </select>
                                <small id="nombre_cursos_help_block" class="form-text text-muted">TIP: Para seleccionar varios cursos, 
                                        presiona la tecla <b>control (CTRL)</b> al momento de elegir otro curso. </small>
                        </div>
                        <hr>
                        <div class="text-center">
                                <div class="btn-group">
                                        <a href={{route('home')}} class="btn btn-outline-danger btn-lg mx-5">Salir</a>
                                        <button type="submit" name="formNum" value="1" class="btn btn-info btn-lg mx-5">Guardar cambios</button>        
                                </div>
                        </div>
                </div>
        </form>

@endsection
