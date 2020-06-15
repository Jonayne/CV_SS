@extends('layout')

@section('title', 'Inicio')

@section('content')
    <div class="container text-black py-2">
    <h1 class="text-secondary text-center"><strong>Bienvenido(a), <p class="font-italic">{{ formatName(auth()->user()) }}<p></strong></h1>
    
    {{-- Si tiene permisos para capturar un CV. --}}
    @can('capturar-cv')
        {{-- Revisamos si ya capturó su CV, si es así, la agregamos a la vista. --}}
        <div class="text-center mt-4">
            @if(auth()->user()->curriculum)
                @if (auth()->user()->curriculum->status == 'en_proceso')
                    <h2 class="alert alert-secondary font-italic mt-5"> Su currículum sigue en proceso de captura </h2>
                    <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.capture1') }}">
                        Seguir capturando mi currículum
                    </a>
                @else
                    <h2 class="alert alert-success font-italic mt-5"> Su currículum está capturado </h2>
                    <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.show1', auth()->user()->curriculum) }}">
                        Ir a mi currículum
                    </a>
                @endif
            @else
                <h2 class="alert alert-danger font-italic mt-5"> Su currículum no se ha sido registrado </h2>
                <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.capture1') }}">
                    Capturar currículum
                </a>
            @endif
        </div>
    @endcan
    
    {{-- Si tiene permisos para buscar un CV. --}}
    @can('buscar-profesor')
        <div class="text-center mt-5">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('buscar_profesor.index') }}">
                Buscar Currículum
            </a>
        </div>
    @endcan

    {{-- Si puede registrar a un usuario     --}}
    @can('registrar-usuario')
        <div class="text-center mt-5">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('registrar_usuario.index') }}">
                Registrar a un usuario
            </a>
        </div>
    @endcan

</div>
@endsection
