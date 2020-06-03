@extends('layout')

@section('title', 'Cursos extracurriculares')

@section('content')
    <h1 class="text-secondary text-center">Cursos extracurriculares</h1>
    <hr>
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')
    <div class="container bg-primary text-black py-3">
        <div class="text-center">
            <br>
            <h3>Cursos técnicos</h3>
            <ul class="list-group list-group-flush">
                @forelse ($technical_extracurricular_courses as $course)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                            <b>Nombre:</b>
                            <span class="text-info font-weight-bold">
                                {{ $course->nombre }}
                            </span>
                            <br>
                            <b>Año:</b>
                            <span class="text-info font-weight-bold">
                                {{ $course->anio }}
                            </span>
                            <br>
                            <b>Documento obtenido:</b>
                            <span class="text-info font-weight-bold">
                                {{ $course->documento_obtenido }}
                            </span>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No hay cursos técnicos registrados
                    </li>
                @endforelse
            </ul>
            <hr>
            <h3>Cursos de formación docente</h3>
            <ul class="list-group list-group-flush">

                @forelse ($extracurricular_teaching_courses as $course)
                    
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre:</b>
                        <span class="text-info font-weight-bold">
                             {{ $course->nombre }}
                        </span>
                        <br>
                        <b>Año:</b>
                        <span class="text-info font-weight-bold">
                             {{ $course->anio }}
                        </span>
                        <br>
                        <b>Documento obtenido:</b>
                        <span class="text-info font-weight-bold">
                             {{ $course->documento_obtenido }}
                        </span>
                    </li>
                @empty

                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No hay cursos de formación docente registrados
                    </li>
                @endforelse
            </ul>
            <hr>
        </div>
        @if ($curriculum->user_id == auth()->user()->id)
            <div class="text-center">
                <a class="btn btn-info btn-lg" href="{{route('curricula.edit',$curriculum->id)}}">Editar CV</a>
            </div>
        @endif
    </div>
@endsection