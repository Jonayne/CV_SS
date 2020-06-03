@extends('layout')

@section('title', 'Captura de CV - Paso 5')

@section('content')
    <h1 class="text-secondary text-center">Lista de temas a impartir</h1>
    <hr>
    @include('cv.create.partials.nav')
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
        <a type="submit" href="/capturar_cv_experiencia_previa" class="btn btn-primary btn-lg">Siguiente</a>

    </div>
    <br>


@endsection