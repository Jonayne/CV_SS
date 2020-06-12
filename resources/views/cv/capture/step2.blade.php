@extends('layout')

@section('title', 'Datos académicos')

@section('content')
    <h1 class="text-secondary text-center">Grado académico y carrera&nbsp;
        <svg class="bi bi-book-half" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 0 0 7.5 2.5v11a.5.5 0 0 0 .854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 0 0-.799-.34 12.96 12.96 0 0 0-2.073-.609zM15 2.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.387-.023-3.426.56V2.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0 1 15 2.82z"/>
                <path fill-rule="evenodd" d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 0 1 8.5 2.5v11a.5.5 0 0 1-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 0 1 0 13.5v-11a.5.5 0 0 1 .276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 0 1 .22-.103 12.958 12.958 0 0 1 2.7-.869z"/>
        </svg>
    </h1>
    <hr>
    @include('cv.capture.partials.cv_status')
    <hr>
    @include('cv.capture.partials.nav')
    <br>
    @include('partials.form_errors')


    <form action="{{route('curricula.update', $curriculum)}}" method="POST">
        @csrf @method('PATCH')
        <div class="container bg-primary text-black py-2">
                <div class="form-group">
                        <label class="required" for="estudios_grado_maximo_estudios">Grado máximo de estudios</label>
                        <input type="text" name="estudios_grado_maximo_estudios" id="estudios_grado_maximo_estudios" class="form-control" placeholder="Grado máximo de estudios" 
                                value="{{ old('estudios_grado_maximo_estudios', $curriculum->estudios_grado_maximo_estudios) }}">
                        <br>
                        <label class="required" for="estudios_escuela">Escuela</label>
                        <input type="text" name="estudios_escuela" id="estudios_escuela" class="form-control" placeholder="Escuela" 
                                value="{{ old('estudios_escuela', $curriculum->estudios_escuela) }}">
                        <br>
                        <label class="required" for="estudios_carrera">Carrera</label>
                        <input type="text" name="estudios_carrera" id="estudios_carrera" class="form-control" placeholder="Carrera" 
                                value="{{ old('estudios_carrera', $curriculum->estudios_carrera) }}">
                        <br>
                        <label class="required" for="estudios_estatus">Estatus</label>
                        <input type="text" name="estudios_estatus" id="estudios_estatus" class="form-control" placeholder="Estatus" 
                                value="{{ old('estudios_estatus', $curriculum->estudios_estatus) }}">
                        <br>
                        <label class="required" for="estudios_documento_obtenido">Documento obtenido</label>
                        <input type="text" name="estudios_documento_obtenido" id="estudios_documento_obtenido" class="form-control" placeholder="Documento obtenido" 
                                value="{{ old('estudios_documento_obtenido', $curriculum->estudios_documento_obtenido) }}">
                        <br>
                        <label class="required" for="cedula_profesional">Cédula profesional</label>
                        <input type="text" name="cedula_profesional" id="cedula_profesional" class="form-control" placeholder="Cédula profesional" 
                                value="{{ old('cedula_profesional', $curriculum->cedula_profesional) }}">
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
