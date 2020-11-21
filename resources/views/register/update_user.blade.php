@extends('layout')

@section('title', 'Editar usuario')

@section('content')
    <h1 class="text-secondary text-center"> Editar Usuario
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
          </svg>
    </h1>
    @include('partials.form_errors')
    
    <form method="POST" action="{{ route('registrar_usuario.updateUser', $user->id) }}" onsubmit='$("#formNum").attr("disabled", "true")'>
        @csrf @method('PATCH')
        
        <div class="container bg-primary text-black py-4">
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="nombre"><b>Nombre</b></label>
                <div class="col-md-6">
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="apellido_paterno"><b>Apellido Paterno</b></label>
                <div class="col-md-6">
                    <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" value="{{ old('apellido_paterno', $user->apellido_paterno) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right" for="apellido_materno"><b>Apellido Materno</b></label>
                <div class="col-md-6">
                    <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" value="{{ old('apellido_materno', $user->apellido_materno) }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="email"><b>Email</b></label>
                <div class="col-md-6">
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email)}}">
                </div>

            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right required" for="password"><b>Nueva contraseña</b></label>
                <div class="col-md-6">
                    <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">               
                </div>
            </div>
            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right required"><b>Confirmar nueva contraseña</b></label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="form-group row">
            <label for="role" class="col-md-4 col-form-label text-md-right required"><b>Rol del usuario</b></label>
                <div class="col-md-6">
                    <select class="form-control" name="role" id="role">
                        @can('registrar-profesor')
                            @if (old('role', $user->roles[0]->nombre_rol) == 'profesor' )
                                <option value="profesor" selected>Profesor</option>
                            @else
                                <option value="profesor">Profesor</option>
                            @endif
                        @endcan
                        @can('registrar-encargado-ce')
                            @if (old('role', $user->roles[0]->nombre_rol) == 'control_escolar' )
                                <option value="control_escolar" selected>Encargado(a) del Área de Control Escolar</option>
                            @else
                                <option value="control_escolar">Encargado(a) del Área de Control Escolar</option>
                            @endif
                        @endcan
                        @can('registrar-admin')
                            @if (old('role', $user->roles[0]->nombre_rol) == 'admin' )
                                <option value="admin" selected>Administrador</option>
                            @else
                                <option value="admin">Administrador</option>
                            @endif
                        @endcan
                    </select>
                </div>
            </div>

            <div class="form-group row">
            <label for="habilitado" class="col-md-4 col-form-label text-md-right required"><b>Estatus</b></label>
                <div class="col-md-6">
                    <select class="form-control" name="habilitado" id="habilitado">
                        @if(old('habilitado', $user->habilitado) == true)
                            <option value=true selected> Usuario habilitado </option>
                            <option value=false> Usuario deshabilitado </option>
                        @elseif(old('habilitado', $user->habilitado) == false)
                            <option value=true> Usuario habilitado </option>
                            <option value=false selected> Usuario deshabilitado </option>
                        @endif
                    </select>
                </div>
            </div>
            
            @can('registrar-encargado-ce')
                <hr>
                <h3 class="text-black text-center text-muted">Exclusivo de encargados(as) del Área de Control Escolar</h3><br>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right required" for="sede"><b>Sede</b></label>
                    <div class="col-md-6">
                        <select class="form-control" name="sede" id="sede">
                            @if (!old('sede', $user->sede))
                                <option value="" selected>Ninguna</option>
                                @foreach ($sede_list as $item)
                                    <option value="{{$item}}"> {{$item}} </option>
                                @endforeach
                            @else
                            <option value="" selected>Ninguna</option>
                                @foreach ($sede_list as $item)
                                    <option value="{{$item}}" 
                                    @if (old('sede', $user->sede) == $item)
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
                <input type="hidden" id="formNumVal" name="formNumVal" value="update">
                <input type="hidden" id="formUserId" name="formUserId" value="{{$user->id}}">
                <button class="btn btn-secondary btn-lg mt-2" id="formNum" name="formNum" type="submit"> Guardar cambios </button>
            </div>
        </div>
    </form>
@endsection
