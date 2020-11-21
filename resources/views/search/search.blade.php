@extends('layout')

@section('title', 'Buscar profesor')

@section('content')
    <h1 class="text-secondary text-center">
        @can('editar-cualquier-usuario') Lista y búsqueda de usuarios @elsecan('buscar-profesor') Búsqueda de profesor @endcan &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
      </svg> </h1>

    <div class="alert alert-info container">
        <h5 class="text-secondary">Con la búsqueda, usted podrá:</h5>
            <h5 class="text-info">
                <ul>
                    @can('editar-cualquier-usuario')
                        <li>Encontrar usuarios para:</li>
                        <ul>
                            <li>Modificar currículum (en caso de profesores).</li>
                            <li>Modificar datos de alta de usuarios.</li>
                            <li>Deshabilitar / Habilitar usuarios.</li>
                        </ul>
                    @elsecan('buscar-profesor')
                        <li>Ver y descargar curriculum de profesores. Además de modificar su categoría de pago.</li>
                     @endcan 
                    
                </ul>
            </h5>
    </div>

    @if ($errors->first())
        <hr>
        <div class="container text-center alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        <hr>
    @endif
    @can('editar-cualquier-usuario')
        <form method="GET" action="{{ route('buscar_profesor.indexUser') }}">
            <div class="container bg-primary text-black py-4">
                <div class="form-group">
                    
                    <h3 class="text-secondary text-center font-weight-bold"> Datos de búsqueda generales </h3>
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $nombre) }}" placeholder="Nombre del usuario">
                    <br>

                    <label for="correo">Email</label>
                    <input type="text" id="correo" name="correo" class="form-control" value="{{ old('correo', $correo)}}" placeholder="Email personal">
                    <br>

                    <label for="rol_usuario">Rol de usuario</label>
                    <select class="form-control" name="rol_usuario" id="rol_usuario">
                        @if (!old('rol_usuario', $rol_usuario))
                            <option value="" selected>Todos los roles</option>
                            <option value="admin"> Administradores</option>
                            <option value="control_escolar"> Control Escolar </option>
                            <option value="profesor"> Profesores </option>
                        @elseif(old('rol_usuario', $rol_usuario) == "admin")
                            <option value="">Todos los roles</option>
                            <option value="admin" selected> Administradores</option>
                            <option value="control_escolar"> Control Escolar </option>
                            <option value="profesor"> Profesores </option>
                        @elseif(old('rol_usuario', $rol_usuario) == "control_escolar")
                            <option value="">Todos los roles</option>
                            <option value="admin"> Administradores</option>
                            <option value="control_escolar" selected> Control Escolar </option>
                            <option value="profesor"> Profesores </option>
                        @elseif(old('rol_usuario', $rol_usuario) == "profesor")
                            <option value="">Todos los roles</option>
                            <option value="admin"> Administradores</option>
                            <option value="control_escolar"> Control Escolar </option>
                            <option value="profesor" selected> Profesores </option>
                        @endif
                    </select>
                    <br>

                    <label for="sede">Sede</label>
                    <select class="form-control" name="sede" id="sede">
                        @if (!old('sede', $sede))
                            <option value="" selected>Todas</option>
                            @foreach ($sede_list as $item)
                                <option value="{{$item}}"> {{$item}} </option>
                            @endforeach
                        @else
                            <option value="" selected>Todas</option>
                            @foreach ($sede_list as $item)
                                <option value="{{$item}}" 
                                @if (old('sede', $sede) == $item)
                                    selected
                                @endif>
                                {{$item}}</option>
                            @endforeach
                        @endif
                    </select>
                    <br>

                    <label for="status_user">Estatus</label>
                    <select class="form-control" name="status_user" id="status_user">
                        @if (!old('status_user', $status_user))
                            <option value="" selected>Usuarios habilitados y deshabilitados</option>
                            <option value=true> Usuarios habilitados </option>
                            <option value=false> Usuarios deshabilitados </option>
                        @elseif(old('status_user', $status_user) == true)
                            <option value="">Usuarios habilitados y deshabilitados</option>
                            <option value=true selected> Usuarios habilitados </option>
                            <option value=false> Usuarios deshabilitados </option>
                        @elseif(old('status_user', $status_user) == false)
                            <option value="">Usuarios habilitados y deshabilitados</option>
                            <option value=true> Usuarios habilitados </option>
                            <option value=false selected> Usuarios deshabilitados </option>
                        @endif
                    </select>
                    <br>

                    <hr>
                    <h3 class="text-secondary text-center font-weight-bold"> Datos exclusivos de profesores </h3>
                    <label for="rfc">RFC</label>
                    <input type="text" id="rfc" name="rfc" class="form-control" value="{{ old('rfc', $rfc)}}" placeholder="RFC">
                    <br>

                    <label for="curp">CURP</label>
                    <input type="text" id="curp" name="curp" class="form-control" value="{{ old('curp', $curp)}}" placeholder="CURP">
                    <br>
                    
                    <label for="categoria_de_pago">Categoría de Pago</label>
                    <select class="form-control" name="categoria_de_pago" id="categoria_de_pago">
                        @if (!old('categoria_de_pago', $categoria_de_pago))
                            <option value="" selected>Ninguno</option>
                            @foreach ($cat_pago_list as $item)
                                <option value="{{$item}}"> {{$item}} </option>
                            @endforeach
                        @else
                            <option value="" selected>Ninguno</option>
                            @foreach ($cat_pago_list as $item)
                                <option value="{{$item}}" 
                                @if (old('categoria_de_pago', $categoria_de_pago) == $item)
                                    selected
                                @endif>
                                {{$item}}</option>
                            @endforeach
                        @endif
                    </select>
                    <br>

                </div>
                <hr>
                <div class="text-center">
                    <button class="btn btn-secondary btn-lg mt-1 mb-4" type="submit"> Filtrar </button>
                    <br>
                    <a class="btn btn-dark btn" href="{{ route('buscar_profesor.indexUser', array('cls')) }}"> Limpiar campos </a>
                </div>    
            </div>
        </form>
        <hr>

        <div class="container bg-primary text-black py-4">
            <h2 class="text-center">Usuarios registrados en el sistema</h2>

            <ul class="list-group">
                @forelse ($users_list as $usuario)
                    <li class="list-group-item list-group-item-light list-group-item-action">
                        Nombre: <strong>{{formatName($usuario)}}</strong><br>
                        Email: <strong>{{$usuario->email}}</strong><br>
                        Rol: <strong>{{$usuario->nombre_rol == 'admin' ? 'Administrador' 
                                                : ($usuario->nombre_rol == 'control_escolar' ? 'Control Escolar' : 'Profesor')}}</strong><br>
                        Estatus: <strong>{{$usuario->habilitado == true ? 'Habilitado' 
                                            : 'Deshabilitado'}}</strong><br>
                        <hr>
                        <div class="text-center">
                            <a class="btn btn-outline-secondary btn-sm mr-5" 
                                href="{{route('registrar_usuario.indexUpdateUser', 
                                            array('id'=>$usuario->id_user))}}">
                                Editar datos de usuario
                            </a>
                            @if ($usuario->categoria_de_pago)
                                <a class="btn btn-outline-info btn-sm mr-5" href="{{route('actualizar_cat_pago.indexCatPago', array('id'=>$usuario->id_user, 'backPage'=>'result'))}}">
                                    Actualizar Categoría de Pago
                                </a>
                            @elseif(!$usuario->categoria_de_pago && $usuario->nombre_rol == "profesor")
                                <a class="btn btn-outline-info btn-sm" href="{{route('actualizar_cat_pago.indexCatPago', array('id'=>$usuario->id_user, 'backPage'=>'result'))}}">
                                    <strong>(Este profesor no tiene su categoría de pago registrada)</strong><br> Registrar Categoría de Pago
                                </a>
                            @endif
                            @if ($usuario->id_curriculum && $usuario->status && $usuario->status != "en_proceso" )
                                <a href="{{route('curricula.show', array('id'=>$usuario->id_curriculum, 'formNum'=>1))}}" class="btn btn-outline-success btn-sm"> Ver currículum </a>
                            @endif
                            {{-- checar que onda con esto para que los admins puedan modificar los cvs. zzzz x_x --}}
                        </div>
                    </li>
                    <hr>
                @empty
                <hr>
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger text-center">
                        No se encontraron usuarios cuyos datos concuerden con su búsqueda. 
                        <br>
                        <br>Verifique que los filtros introducidos sean correctos. Tome en cuenta acentos.<br>
                    </li>
                @endforelse
                <hr>
            </ul>
        </div>
    @elsecan('buscar-profesor')
        <form method="GET" action="{{ route('buscar_profesor.searchOnDBProf') }}">
            <div class="container bg-primary text-black py-4">
                <div class="form-group">

                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $nombre) }}" placeholder="Nombre del profesor">
                    <br>

                    <label for="correo">Email</label>
                    <input type="text" id="correo" name="correo" class="form-control" value="{{ old('correo', $correo)}}" placeholder="Email personal">
                    <br>

                    <label for="rfc">RFC</label>
                    <input type="text" id="rfc" name="rfc" class="form-control" value="{{ old('rfc', $rfc)}}" placeholder="RFC">
                    <br>

                    <label for="curp">CURP</label>
                    <input type="text" id="curp" name="curp" class="form-control" value="{{ old('curp', $curp)}}" placeholder="CURP">
                    <br>
                    
                    <label for="categoria_de_pago">Categoría de Pago</label>
                    <select class="form-control" name="categoria_de_pago" id="categoria_de_pago">
                        @if (!old('categoria_de_pago', $categoria_de_pago))
                            <option value="" selected>Ninguno</option>
                            @foreach ($cat_pago_list as $item)
                                <option value="{{$item}}"> {{$item}} </option>
                            @endforeach
                        @else
                            <option value="" selected>Ninguno</option>
                            @foreach ($cat_pago_list as $item)
                                <option value="{{$item}}" 
                                @if (old('categoria_de_pago', $categoria_de_pago) == $item)
                                    selected
                                @endif>
                                {{$item}}</option>
                            @endforeach
                        @endif
                    </select>
                    <br>
                </div>
                <hr>
                <div class="text-center">
                    <button class="btn btn-secondary btn-lg mt-1 mb-4" type="submit"> Buscar </button>
                    <br>
                    <a class="btn btn-dark btn" href="{{ route('buscar_profesor.index', array('cls')) }}"> Limpiar campos </a>
                </div>    
            </div>
        </form>
    @endcan
    
@endsection
