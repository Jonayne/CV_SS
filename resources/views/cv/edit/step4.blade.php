@extends('layout')

@section('title', 'Captura de CV - Paso 4')

@section('content')
    <h1 class="text-secondary text-center">Certificaciones obtenidas</h1>
    <hr>
    @include('cv.edit.partials.nav')
    <br>
    @include('partials.form_errors')

    <form action="{{route('curricula.update', $curriculum)}}" method="POST">
        @csrf @method('PATCH')
        <div class="container bg-primary text-black py-2">
            <label for="certificaciones_obtenidas">Escriba en el área de texto las certificaciones que ha obtenido:</label>
            <textarea class="form-control" id="certificaciones_obtenidas" name="certificaciones_obtenidas">{{ old('certificaciones_obtenidas', session()->get('curriculum.certificaciones_obtenidas')) }}</textarea>
            <br><br>
            <div class="text-center">
                <div class="btn-group">
                        <a href={{route('home')}} class="btn btn-danger btn-lg mx-5">Salir</a>
                        <button type="submit" name="formNum" value="4" class="btn btn-info btn-lg mx-5">Guardar cambios</button>        
                </div>
            </div>
        </div>
        
    
    </form>
    
@endsection
