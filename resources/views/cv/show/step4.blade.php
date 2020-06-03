@extends('layout')

@section('title', 'Certificaciones obtenidas')

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
                <div class="text-center">
                    <a class="btn btn-info btn-lg" href="{{route('curricula.edit',$curriculum->id)}}">Editar CV</a>
                </div>
            @endif
        </div>
    </fieldset>
    
@endsection
