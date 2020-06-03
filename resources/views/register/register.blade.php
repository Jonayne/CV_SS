@extends('layout')

@section('title', 'Registar usuario')

@section('content')
    <h1 class="text-secondary text-center">Registrar usuario</h1>
    @include('partials.form_errors')
    
    <form method="POST" action="{{ route('registrar_usuario.registerUser') }}">
        @csrf 

        <div class="container bg-primary text-black py-4">
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="nombre"><b>Nombre</b></label>
                <div class="col-md-6">
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="ap_paterno"><b>Apellido Paterno</b></label>
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
                <label class="col-md-4 col-form-label text-md-right" for="email"><b>Email</b></label>
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email')}}">
                </div>

            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="password"><b>Contraseña</b></label>
                <div class="col-md-6">
                    <input type="password" id="password" name="password" class="form-control" value="{{ old('password')}}">               
                </div>
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right"><b>Confirmar contraseña</b></label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="form-group row">
                <label for="role" class="col-md-4 col-form-label text-md-right"><b>Rol del usuario</b></label>
                <div class="col-md-6">
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
                    </select>
                </div>
            </div>

            @can('registrar-encargado-ce')
                <hr>
                <h3 class="text-black text-center text-muted">Sólo al registrar a encargados(as) del Área de Control Escolar</h3><br>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right" for="sede"><b>Sede</b></label>
                    <div class="col-md-6">
                        <input type="text" id="sede" name="sede" class="form-control" value="{{ old('sede') }}">
                    </div>
                </div>
            @endcan
            
            <hr>
            <div class="text-center">
                <button class="btn btn-success btn-lg mt-2" type="submit"> Registrar </button>
            </div>
        </div>
    </form>
@endsection
