@extends('layout')

@section('title', 'Error 404')

@section('content')
<div class="container bg-light text-black py-3">
    <h1 class="text-danger text-center"><strong>El recurso solicitado no existe</strong>&nbsp;
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-emoji-dizzy" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path fill-rule="evenodd" d="M9.146 5.146a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 1 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 0-.708zm-5 0a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 1 1 .708.708l-.647.646.647.646a.5.5 0 1 1-.708.708L5.5 7.207l-.646.647a.5.5 0 1 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 0-.708z"/>
            <path d="M10 11a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
        </svg>
    </h1>
    <hr>
    
    <div class="text-center">
        <div class="btn-group">
                <a href={{ route('home') }} class="btn btn-info btn-lg mr-5">Ir al Inicio</a>

                <a href={{ url()->previous() }} class="btn btn-info btn-lg">Regresar</a>
        </div>
    </div>
</div>
@endsection
