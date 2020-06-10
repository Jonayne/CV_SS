@extends('layout')

@section('title', 'Datos académicos')

@section('content')
    <h1 class="text-secondary text-center">Grado académico y carrera</h1>
    <hr>
    @include('cv.edit.partials.nav')
    <br>
    @include('partials.form_errors')


    <form action="{{route('curricula.update', $curriculum)}}" method="POST">
        @csrf @method('PATCH')
        <div class="container bg-primary text-black py-3">
                <h2 class="text-secondary font-italic font-weight-bold text-center">No olvide guardar sus cambios antes de continuar</h2>
                <hr>
                <div class="form-group">
                        <label class="required" for="estudios_grado_maximo_estudios">Grado máximo de estudios</label>
                        <input type="text" name="estudios_grado_maximo_estudios" id="estudios_grado_maximo_estudios" class="form-control" placeholder="Grado máximo de estudios" 
                                value="{{ old('estudios_grado_maximo_estudios', session()->get('curriculum.estudios_grado_maximo_estudios')) }}">
                        <br>
                        <label class="required" for="estudios_escuela">Escuela</label>
                        <input type="text" name="estudios_escuela" id="estudios_escuela" class="form-control" placeholder="Escuela" 
                                value="{{ old('estudios_escuela', session()->get('curriculum.estudios_escuela')) }}">
                        <br>
                        <label class="required" for="estudios_carrera">Carrera</label>
                        <input type="text" name="estudios_carrera" id="estudios_carrera" class="form-control" placeholder="Carrera" 
                                value="{{ old('estudios_carrera', session()->get('curriculum.estudios_carrera')) }}">
                        <br>
                        <label class="required" for="estudios_estatus">Estatus</label>
                        <input type="text" name="estudios_estatus" id="estudios_estatus" class="form-control" placeholder="Estatus" 
                                value="{{ old('estudios_estatus', session()->get('curriculum.estudios_estatus')) }}">
                        <br>
                        <label class="required" for="estudios_documento_obtenido">Documento obtenido</label>
                        <input type="text" name="estudios_documento_obtenido" id="estudios_documento_obtenido" class="form-control" placeholder="Documento obtenido" 
                                value="{{ old('estudios_documento_obtenido', session()->get('curriculum.estudios_documento_obtenido')) }}">
                        <br>
                        <label class="required" for="cedula_profesional">Cédula profesional</label>
                        <input type="text" name="cedula_profesional" id="cedula_profesional" class="form-control" placeholder="Cédula profesional" 
                                value="{{ old('cedula_profesional', session()->get('curriculum.cedula_profesional')) }}">
                </div>
                <div class="text-center">
                        <div class="btn-group">
                                <a href={{route('home')}} class="btn btn-outline-danger btn-lg mx-5">Salir</a>
                                <button type="submit" name="formNum" value="2" class="btn btn-info btn-lg mx-5">Guardar cambios</button>        
                        </div>
                </div>
        </div>
    </form>  
@endsection
