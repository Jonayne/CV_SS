@extends('layout')

@section('title', 'Buscar profesor')

@section('content')
    <h1 class="text-secondary text-center">Búsqueda de profesor &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
      </svg> </h1>

    <div class="alert alert-info container">
        <h5 class="text-secondary text-center">Con la búsqueda de profesores, usted podrá:</h5>
        <h5 class="text-info text-center">
            <ul>
                <li>Ver y descargar su curriculum.</li>
                <li>Actualizar su Categoría de Pago.</li>
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
    
    <form method="GET" action="{{ route('buscar_profesor.searchOnDB') }}">
        <div class="container bg-primary text-black py-4">
            <div class="form-group">

                <label for="nombre">Nombre del profesor</label>
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
@endsection
