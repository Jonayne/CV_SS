@extends('layout')

@section('title', 'Captura de CV - Paso 6')

@section('content')
    <h1 class="text-secondary text-center">Experiencia profesional previa</h1>
    <hr>
    @include('cv.create.partials.nav')
    <br>
    @include('partials.form_errors')

    <div class="container bg-primary text-black py-3">
        <div class="text-center">
            <br>
            <ul class="list-group list-group-flush">
                @forelse ($previous_exp as $pe)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <br>
                        
                        <b>Periodo:</b>
                        <span class="text-info font-weight-bold">
                             {{ $pe->periodo }}
                        </span>
                        <br>

                        <b>Institución:</b> 
                        <span class="text-info font-weight-bold">
                            {{ $pe->institucion }}
                        </span>
                        <br>
                        <b>Cargo:</b>
                        <span class="text-info font-weight-bold">
                             {{ $pe->cargo }}
                        </span>
                        <br><br>

                        <b>Actividades principales:</b>
                        <p class=" p-2 mb-2 text-info font-weight-bold text-center text-break">
                            {{ $pe->actividades_principales }} 
                        </p>
                        
                        <br>

                        <div class="btn-group">
                            <a class="btn btn-outline-info btn-sm" name="formNum" value="6" href="{{route('previous_experiences.edit', $pe)}}">
                                Editar
                            </a>
                            &nbsp;
                            <form method="POST" action="{{route('previous_experiences.destroy', $pe)}}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                            </form>  
                        </div>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No ha registrado experiencias profesionales previas aún
                    </li>
                @endforelse
            </ul>

            <a class="btn btn-success btn-lg" name="formNum" value="6" href="{{route('previous_experiences.create')}}">
                Registrar experiencia profesional
            </a>
            <br>
        </div>
        <a type="submit" href="/capturar_cv_documentos_probatorios" class="btn btn-primary">Siguiente</a>
    </div>    
@endsection
