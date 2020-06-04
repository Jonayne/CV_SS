@extends('layout')

@section('title', 'Captura de CV - Paso 4')

@section('content')
    <h1 class="text-secondary text-center">Certificaciones obtenidas</h1>
    <hr>
    @include('cv.create.partials.nav')
    <br>
    @include('partials.form_errors')

    <form action="/capturar_cv_certificaciones_obtenidas" method="POST">
        @csrf
        <div class="container bg-primary text-black py-3">
            <label for="certificaciones_obtenidas">Escriba en el área de texto las certificaciones que ha obtenido:</label>
            <textarea class="form-control" id="certificaciones_obtenidas" name="certificaciones_obtenidas">{{ old('certificaciones_obtenidas', session()->get('curriculum.certificaciones_obtenidas')) }}</textarea>
            <br><br>
            <button type="submit" name="formNum" value="4" class="btn btn-primary btn-lg">Siguiente</button>
        </div>
    
    </form>
    
@endsection
