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
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')
    @can('descargar-cv')
                @include('cv.show.partials.download_cv')
    @endcan
    <div class="container bg-primary text-black py-3">
        <fieldset disabled="disabled">
        
            <h3 class="text-black"> Certificaciones que ha obtenido </h3>
            <textarea class="form-control" id="certificaciones_obtenidas" name="certificaciones_obtenidas">{{$curriculum->certificaciones_obtenidas}}</textarea>
            <br><br>
        </fieldset>
        @if ($curriculum->user_id == auth()->user()->id)
            <div class="text-center">
                <a class="btn btn-info btn-lg" href="{{route('curricula.capture4')}}">Editar CV</a>
            </div>
        @endif
    </div>
    
@endsection
