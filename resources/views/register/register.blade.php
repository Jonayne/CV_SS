@extends('layout')

@section('title', 'Registar usuario')

@section('content')
    <h1 class="text-secondary text-center">@can('editar-cualquier-usuario') Registrar Usuario @elsecan('registrar-profesor') Registrar Instructor @endcan &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
        <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
      </svg></h1>
    @include('partials.form_errors')
    
    <form method="POST" action="{{ route('registrar_usuario.registerUser') }}" onsubmit='$("#formNum").attr("disabled", "true")'>
        @csrf 
        @php
            $random_token = Str::random(32);
            session()->put('random_token', $random_token);
        @endphp
        <input type="hidden" id="unique_token" name="unique_token" value="{{$random_token}}">
        
        <div class="container bg-primary text-black py-4">
            <h6 class="text-right required font-italic"> Campos obligatorios: </h6>
            <hr>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="nombre"><b>Nombre</b></label>
                <div class="col-md-6">
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="ap_paterno"><b>Apellido Paterno</b></label>
                <div class="col-md-6">
                    <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" value="{{ old('ap_paterno') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="ap_materno"><b>Apellido Materno</b></label>
                <div class="col-md-6">
                    <input type="text" id="ap_materno" name="ap_materno" class="form-control" value="{{ old('ap_materno') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="email"><b>Email</b></label>
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email')}}">
                </div>

            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="password"><b>Contraseña</b></label>
                <div class="col-md-6">
                    <input type="password" id="password" name="password" class="form-control" value="{{ old('password')}}">               
                </div>
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right required"><b>Confirmar contraseña</b></label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right required"><b>Rol del usuario</b></label>
                <div class="col-md-6">
                    @can('editar-cualquier-usuario') 
                        <select class="form-control" name="role" id="role">
                            @can('registrar-profesor')
                                @if (old('role') == 'profesor' )
                                    <option value="profesor" selected>Profesor</option>
                                @else
                                    <option value="profesor">Profesor</option>
                                @endif
                            @endcan
                            @can('registrar-encargado-ce')
                                @if (old('role') == 'control_escolar' )
                                    <option value="control_escolar" selected>Encargado(a) del Área de Control Escolar</option>
                                @else
                                    <option value="control_escolar">Encargado(a) del Área de Control Escolar</option>
                                @endif
                            @endcan
                            @can('registrar-admin')
                                @if (old('role') == 'admin' )
                                    <option value="admin" selected>Administrador</option>
                                @else
                                    <option value="admin">Administrador</option>
                                @endif
                            @endcan
                        </select>
                    @elsecan('registrar-profesor') 
                        <input type="hidden" id="role" name="role" value="profesor">
                        <input type="text" class="form-control" value="Profesor" disabled>
                    @endcan
                    
                </div>
            </div>
            <hr>
            <h3 class="text-black text-center text-muted">Sólo obligatorio al registrar Profesores</h3><br>
            <div class="form-group row">
                <label for="cat_pago" class="col-md-4 col-form-label text-md-right required"><b>Categoría de Pago </b></label>
                <div class="col-md-6">
                    <select class="form-control" name="cat_pago" id="cat_pago">
                        @if (!old('cat_pago'))
                            <option value="" selected>Ninguno</option>
                            @foreach ($cat_pago_list as $item)
                                <option value="{{$item}}"> {{$item}} </option>
                            @endforeach
                        @else
                            <option value="" >Ninguno</option>
                            @foreach ($cat_pago_list as $item)
                                <option value="{{$item}}" 
                                @if (old('cat_pago') == $item)
                                    selected
                                @endif>
                                {{$item}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="form-check row">
                <label for="cat_pago_despues" class="col-md-4 col-form-label text-md-right form-check-label">
                    <small>Alternativamente, puede <b>introducir<br> después la Categoría de Pago</small>
                    <input type="checkbox" name="cat_pago_despues" id="cat_pago_despues" class="form-check-input col-md-6"
                    {{ (old('cat_pago_despues') ||
                        old('cat_pago_despues') === true) ? 'checked=true' : ''}}></label>
            </div>
            
            @can('registrar-encargado-ce')
                <hr>
                <h3 class="text-black text-center text-muted">Sólo obligatorio al registrar encargados(as) del Área de Control Escolar</h3><br>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right required" for="sede"><b>Sede</b></label>
                    <div class="col-md-6">
                        <select class="form-control" name="sede" id="sede">
                            @if (!old('sede'))
                                <option value="" selected>Ninguna</option>
                                @foreach ($sede_list as $item)
                                    <option value="{{$item}}"> {{$item}} </option>
                                @endforeach
                            @else
                                @foreach ($sede_list as $item)
                                    <option value="{{$item}}" 
                                    @if (old('sede') == $item)
                                        selected
                                    @endif>
                                    {{$item}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            @endcan
            
            <hr>
            <div class="text-center">
                <input type="hidden" id="formNumVal" name="formNumVal" value="register">
                <button class="btn btn-success btn-lg mt-2" id="formNum" name="formNum" type="submit"> Registrar </button>
            </div>
        </div>
    </form>
@endsection
