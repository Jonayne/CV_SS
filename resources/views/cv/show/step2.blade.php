@extends('layout')

@section('title', 'Datos académicos')

@section('content')
    <h1 class="text-secondary text-center">Grado académico y carrera</h1>
    <hr>
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')

    <div class="container bg-primary text-black py-3">
        <fieldset disabled="disabled">
                <div class="form-group">
                        <label for="estudios_grado_maximo_estudios">Grado máximo de estudios</label>
                        <input type="text" name="estudios_grado_maximo_estudios" id="estudios_grado_maximo_estudios" class="form-control" placeholder="Grado máximo de estudios" 
                        value="{{$curriculum->estudios_grado_maximo_estudios}}">
                        <br>
                        <label for="estudios_escuela">Escuela</label>
                        <input type="text" name="estudios_escuela" id="estudios_escuela" class="form-control" placeholder="Escuela" 
                        value="{{$curriculum->estudios_escuela}}">
                        <br>
                        <label for="estudios_carrera">Carrera</label>
                        <input type="text" name="estudios_carrera" id="estudios_carrera" class="form-control" placeholder="Carrera" 
                        value="{{$curriculum->estudios_carrera}}">
                        <br>
                        <label for="estudios_estatus">Estatus</label>
                        <input type="text" name="estudios_estatus" id="estudios_estatus" class="form-control" placeholder="Estatus" 
                        value="{{$curriculum->estudios_estatus}}">
                        <br>
                        <label for="estudios_documento_obtenido">Documento obtenido</label>
                        <input type="text" name="estudios_documento_obtenido" id="estudios_documento_obtenido" class="form-control" placeholder="Documento obtenido" 
                        value="{{$curriculum->estudios_documento_obtenido}}">
                        <br>
                        <label for="cedula_profesional">Cédula profesional</label>
                        <input type="text" name="cedula_profesional" id="cedula_profesional" class="form-control" placeholder="Cédula profesional" 
                        value="{{$curriculum->cedula_profesional}}">
                </div>

        </fieldset>
        @if ($curriculum->user_id == auth()->user()->id)
                <div class="text-center">
                        <a class="btn btn-info btn-lg" href="{{route('curricula.capture2')}}">Editar CV</a>
                </div>
        @endif
       </div>

@endsection
