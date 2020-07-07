@extends('layout')

@section('title', 'Inicio')

@section('content')
    
    <div class="container alert alert-secondary text-center">
        <h1 class="text-secondary text-center"><strong>Bienvenido(a), <p class="font-italic">{{ formatName(auth()->user()) }}<p></strong></h1>
    </div>
    <div class="container text-black py-5">
    {{-- Si tiene permisos para capturar un CV. --}}
    @can('capturar-cv')
        {{-- Revisamos si ya capturó su CV, si es así, la agregamos a la vista. --}}
        <div class="text-center mt-4">
            @if(auth()->user()->curriculum)
                @if (auth()->user()->curriculum->status == 'en_proceso')
                    <h2 class="alert alert-secondary font-italic mt-5"> Su currículum sigue en proceso de captura </h2>
                    <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.capture', 1) }}">
                        Seguir capturando mi currículum
                    </a>
                @else
                    <h2 class="alert alert-success font-italic mt-5"> Su currículum se encuentra capturado </h2>
                    <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.show', array(auth()->user()->curriculum, 1)) }}">
                        Ir a mi currículum
                    </a>
                @endif
            @else
                <h2 class="alert alert-danger font-italic mt-5"> Su currículum no está registrado </h2>
                <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.capture', 1) }}">
                    Capturar currículum
                </a>
            @endif
        </div>
    @endcan
    
    {{-- Si tiene permisos para buscar un CV. --}}
    @can('buscar-profesor')
        <div class="text-center mt-5">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('buscar_profesor.index') }}">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                  </svg> - Buscar currículum
            </a>
        </div>
    @endcan

    {{-- Si puede registrar a un usuario --}}
    @can('registrar-usuario')
        <div class="text-center mt-5">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('registrar_usuario.index') }}">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                    <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                  </svg> - Registrar a un usuario
            </a>
        </div>
    @endcan

</div>
@endsection
