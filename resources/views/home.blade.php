@extends('layout')

@section('title', 'Inicio')

@section('content')
    <div class="container-fluid">
    <h1 class="text-secondary text-center"><strong>Bienvenido(a), <p class="font-italic">{{ formatName(auth()->user()) }}<p></strong></h1>
    
    {{-- Si tiene permisos para capturar una CV. --}}
    @can('capturar-cv')
        {{-- Revisamos si ya capturó su CV, si es así, la agregamos a la vista. --}}
        <div class="text-center mt-4">
            @if(auth()->user()->curriculum)
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('curricula.show', auth()->user()->curriculum->id) }}">
                Ir a mi CURRICULUM
            </a>
            @else
                <p> ¡Todavía no ha capturado su CV! </p>
                <a class="btn btn-primary btn-lg text-dark" href="{{ route('curricula.create') }}">
                    CAPTURAR CV
                </a>
            @endif
        </div>
    @endcan
    
    {{-- Si tiene permisos para buscar una CV. --}}
    @can('buscar-profesor')
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('buscar_profesor.index') }}">
                Buscar CV
            </a>
        </div>
    @endcan

    {{-- Si puede registrar a un profesor --}}
    @can('registrar-profesor')
        <div class="text-center mt-4">
            <button class="btn btn-primary btn-lg text-dark" type="submit">
                Registrar profesor
            </button>
        </div>
    @endcan

    {{-- Si puede registrar a un encargado de CE --}}
    @can('registrar-encargado-ce')
        <div class="text-center mt-4">
            <button class="btn btn-primary btn-lg text-dark" type="submit">
                Registrar encargado de Control escolar
            </button>
        </div>
    @endcan
</div>
@endsection
