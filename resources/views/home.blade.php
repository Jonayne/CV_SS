@extends('layout')

@section('title', 'Inicio')

@section('content')
    <div class="container-fluid">
    <h1 class="text-secondary text-center"><strong>Bienvenido(a), <p class="font-italic">{{ formatName(auth()->user()) }}<p></strong></h1>
    
    {{-- Si tiene permisos para capturar un CV. --}}
    @can('capturar-cv')
        {{-- Revisamos si ya capturó su CV, si es así, la agregamos a la vista. --}}
        <div class="text-center mt-4">
            @if(auth()->user()->curriculum)
                @if (auth()->user()->curriculum->status == 'en_proceso')
                    <h2 class="text-secondary text-weigh-bold font-italic mt-5"> Aún no termina de capturar su CV </h2>
                    <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.capture1') }}">
                        Seguir capturando mi CV
                    </a>
                @else
                    <h2 class="text-secondary text-weigh-bold font-italic mt-5"> Su CV está capturado </h2>
                    <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.show', auth()->user()->curriculum) }}">
                        Ir a mi Curriculum
                    </a>
                @endif
            @else
                <h2 class="text-secondary text-weigh-bold font-italic mt-5"> Su CV aún no ha sido registrado </h2>
                <a class="btn btn-primary btn-lg text-dark mt-5" href="{{ route('curricula.capture1') }}">
                    Capturar Curriculum
                </a>
            @endif
        </div>
    @endcan
    
    {{-- Si tiene permisos para buscar un CV. --}}
    @can('buscar-profesor')
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('buscar_profesor.index') }}">
                Buscar CV
            </a>
        </div>
    @endcan

    {{-- Si puede registrar a un usuario     --}}
    @can('registrar-usuario')
        <div class="text-center mt-4">
            <a class="btn btn-primary btn-lg text-dark" href="{{ route('registrar_usuario.index') }}">
                Registrar a un usuario
            </a>
        </div>
    @endcan

</div>
@endsection
