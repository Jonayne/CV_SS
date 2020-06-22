@extends('layout')

@section('title', 'Lista de temas a impartir')

@section('content')
    <h1 class="text-secondary text-center">Lista de temas a impartir&nbsp;
        <svg class="bi bi-list-ul" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
        </svg>
    </h1>
    <hr>
    @include('cv.capture.partials.cv_status')
    <hr>
    @include('cv.capture.partials.nav')
    <br>
    @include('partials.form_errors')
    <div class="container bg-primary text-black py-3">
        <div class="text-center">
            <br>
            <ul class="list-group list-group-flush">
                @forelse ($element as $subject)
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
                            <br><br>
                            <div class="btn-group">
                                <a class="btn btn-outline-info btn-sm" name="formNum" value="5" href="{{route('subjects.edit', $subject)}}">
                                    Editar
                                </a>
                                &nbsp;
                                <form method="POST" action="{{route('subjects.destroy', $subject)}}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                                </form>  
                            </div>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        La lista de temas es vacía
                    </li>
                @endforelse
            </ul>
            <hr>
            <a class="btn btn-success btn-lg"  name="formNum" value="5" href="{{route('subjects.create')}}">
                Agregar tema
            </a>
        </div>
        <hr>
        <div class="text-center">
            <div class="btn-group">
                    <a href={{route('home')}} class="btn btn-outline-danger btn-lg mt-3">Salir</a>
            </div>
        </div>

    </div>
    <br>


@endsection