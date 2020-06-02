@extends('layout')

@section('title', 'Muestra de CV - Experiencia profesional')

@section('content')
    <h1 class="text-secondary text-center">Experiencia profesional previa</h1>
    <hr>
    @include('cv.show.partials.nav')
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
                        </span><br>

                        <b>Actividades principales:</b>
                        <p class=" p-2 mb-2 text-info font-weight-bold text-center text-break">
                            {{ $pe->actividades_principales }} 
                        </p>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No hay experiencias profesionales previas registradas
                    </li>
                @endforelse
            </ul>
            <br>
        </div>
        @if ($curriculum->user_id == auth()->user()->id)
            <a class="btn btn-primary" href="{{route('curricula.edit',$curriculum->id)}}">Editar CV</a>
        @endif
    </div>    
@endsection
