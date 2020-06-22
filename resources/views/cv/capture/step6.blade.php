@extends('layout')

@section('title', 'Experiencia profesional previa')

@section('content')
    <h1 class="text-secondary text-center">Experiencia profesional previa&nbsp;
        <svg class="bi bi-building" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M15.285.089A.5.5 0 0 1 15.5.5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5H1a.5.5 0 0 1-.5-.5v-6a.5.5 0 0 1 .418-.493l5.582-.93V3.5a.5.5 0 0 1 .324-.468l8-3a.5.5 0 0 1 .46.057zM7.5 3.846V8.5a.5.5 0 0 1-.418.493l-5.582.93V15h8v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.222l-7 2.624z"/>
            <path fill-rule="evenodd" d="M6.5 15.5v-7h1v7h-1z"/>
            <path d="M2.5 11h1v1h-1v-1zm2 0h1v1h-1v-1zm-2 2h1v1h-1v-1zm2 0h1v1h-1v-1zm6-10h1v1h-1V3zm2 0h1v1h-1V3zm-4 2h1v1h-1V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm-2 2h1v1h-1V7zm2 0h1v1h-1V7zm-4 0h1v1h-1V7zm0 2h1v1h-1V9zm2 0h1v1h-1V9zm2 0h1v1h-1V9zm-4 2h1v1h-1v-1zm2 0h1v1h-1v-1zm2 0h1v1h-1v-1z"/>
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
                @forelse ($element as $pe)
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
            <hr>
            <a class="btn btn-success btn-lg" name="formNum" value="6" href="{{route('previous_experiences.create')}}">
                Registrar experiencia profesional
            </a>
            <br>
        </div>
        <hr>
        <div class="text-center">
            <div class="btn-group">
                    <a href={{route('home')}} class="btn btn-outline-danger btn-lg mt-3">Salir</a>
            </div>
        </div>
    </div>    
@endsection
