@extends('layout')

@section('title', 'Lista de temas a impartir')

@section('content')
    <h1 class="text-secondary text-center">Lista de temas a impartir</h1>
    <hr>
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')
    <div class="container bg-primary text-black py-3">
        <div class="text-center">
            <br>
            <ul class="list-group list-group-flush">
                @forelse ($subjects as $subject)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                            {{-- <span class="font-weight-bold">
                                Nombre: {{ $subject->nombre }}
                            </span> ??????? --}}
                            <b>Versión:</b>
                            <span class="text-info font-weight-bold">
                                 {{ $subject->version }}
                            </span>
                            <br>
                            <b>Nivel:</b>
                            <span class="text-info font-weight-bold">
                                 {{ $subject->nivel }}
                            </span>
                            <br>
                            <b>Sistema operativo:</b>
                            <span class="text-info font-weight-bold">
                                 {{ $subject->sistema_operativo }}
                            </span>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        Lista de temas vacía
                    </li>
                @endforelse
            </ul>
        </div>
        @if ($curriculum->user_id == auth()->user()->id)
            <div class="text-center">
                    <a class="btn btn-info btn-lg" href="{{route('curricula.capture5')}}">Editar CV</a>
            </div>
        @endif
    </div>
    <br>


@endsection