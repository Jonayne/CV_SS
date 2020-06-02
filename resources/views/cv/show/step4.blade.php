@extends('layout')

@section('title', 'Muestra de CV - Certificaciones obtenidas')

@section('content')
    <h1 class="text-secondary text-center">Certificaciones obtenidas</h1>
    <hr>
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')

    <fieldset disabled="disabled">
        <div class="container bg-primary text-black py-2">
            <h3 class="text-black"> Certificaciones que ha obtenido </h3>
            <textarea class="form-control" id="certificaciones_obtenidas" name="certificaciones_obtenidas">{{$curriculum->certificaciones_obtenidas}}</textarea>
            <br><br>
            @if ($curriculum->user_id == auth()->user()->id)
                <a class="btn btn-primary" href="{{route('curricula.edit',$curriculum->id)}}">Editar CV</a>
            @endif
        </div>
    </fieldset>
    
@endsection
