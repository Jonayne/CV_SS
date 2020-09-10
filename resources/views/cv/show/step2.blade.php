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
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')
    @can('descargar-cv')
                @include('cv.show.partials.download_cv')
    @endcan
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
                        <select class="form-control" name="estudios_estatus" id="estudios_estatus">
                                @if ($curriculum->estudios_estatus == 'pasante')
                                        <option value="pasante" selected>Pasante</option>
                                @else
                                        <option value="pasante">Pasante</option>
                                @endif
                                @if ($curriculum->estudios_estatus == 'titulado' )
                                        <option value="titulado" selected>Titulado(a)</option>
                                @else
                                        <option value="titulado">Titulado(a)</option>
                                @endif
                                @if ($curriculum->estudios_estatus == 'estudiante')
                                        <option value="estudiante" selected>Estudiante</option>
                                @else
                                        <option value="estudiante">Estudiante</option>
                                @endif
                        </select>
                        <br>
                        <label for="estudios_documento_obtenido">Documento obtenido</label>
                        <input type="text" name="estudios_documento_obtenido" id="estudios_documento_obtenido" class="form-control" placeholder="Documento obtenido" 
                        value="{{$curriculum->estudios_documento_obtenido}}">
                        <br>
                        @if ($curriculum->estudios_estatus == "titulado")
                                <label for="cedula_profesional">Cédula profesional</label>
                                <input type="text" name="cedula_profesional" id="cedula_profesional" class="form-control" placeholder="Cédula profesional" 
                                value="{{$curriculum->cedula_profesional}}">
                        @endif
                        
                </div>

        </fieldset>
        @if ($curriculum->user_id == auth()->user()->id)
                <div class="text-center">
                        <a class="btn btn-info btn-lg" href="{{route('curricula.capture', 2)}}">Editar CV</a>
                </div>
        @endif
       </div>

@endsection
