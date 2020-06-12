@extends('layout')

@section('title', 'Certificaciones obtenidas')

@section('content')
    <h1 class="text-secondary text-center">Certificaciones obtenidas&nbsp;
        <svg class="bi bi-layers" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3.188 8L.264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l-1.063.567L14.438 10 8 13.433 1.562 10 4.25 8.567 3.187 8z"/>
            <path fill-rule="evenodd" d="M7.765 1.559a.5.5 0 0 1 .47 0l7.5 4a.5.5 0 0 1 0 .882l-7.5 4a.5.5 0 0 1-.47 0l-7.5-4a.5.5 0 0 1 0-.882l7.5-4zM1.563 6L8 9.433 14.438 6 8 2.567 1.562 6z"/>
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
        <div class="container bg-primary text-black py-3">
            <label class="required" for="certificaciones_obtenidas">Escriba en el área de texto las certificaciones que ha obtenido:</label>
            <textarea class="form-control" id="certificaciones_obtenidas" name="certificaciones_obtenidas">{{ old('certificaciones_obtenidas', $curriculum->certificaciones_obtenidas) }}</textarea>
            <br><br>
            <div class="text-center">
                <div class="btn-group">
                        <a href={{route('home')}} class="btn btn-outline-danger btn-lg mx-5">Salir</a>
                        <button type="submit" name="formNum" value="4" class="btn btn-info btn-lg mx-5">Guardar cambios</button>        
                </div>
            </div>
        </div>
    
    </form>
    
@endsection
