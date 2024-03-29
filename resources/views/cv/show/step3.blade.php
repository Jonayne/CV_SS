@extends('layout')

@section('title', 'Cursos extracurriculares')

@section('content')
    <h1 class="text-secondary text-center">Cursos extracurriculares&nbsp;
        <svg class="bi bi-pen" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.707 13.707a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391L10.086 2.5a2 2 0 0 1 2.828 0l.586.586a2 2 0 0 1 0 2.828l-7.793 7.793zM3 11l7.793-7.793a1 1 0 0 1 1.414 0l.586.586a1 1 0 0 1 0 1.414L5 13l-3 1 1-3z"/>
                <path fill-rule="evenodd" d="M9.854 2.56a.5.5 0 0 0-.708 0L5.854 5.855a.5.5 0 0 1-.708-.708L8.44 1.854a1.5 1.5 0 0 1 2.122 0l.293.292a.5.5 0 0 1-.707.708l-.293-.293z"/>
                <path d="M13.293 1.207a1 1 0 0 1 1.414 0l.03.03a1 1 0 0 1 .03 1.383L13.5 4 12 2.5l1.293-1.293z"/>
        </svg>
    </h1>
    <hr>
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')
    @can('descargar-cv')
                @include('cv.show.partials.download_cv')
    @endcan
    <div class="container bg-primary text-black py-3">
        <div class="text-center">
            <br>
            <h3>Cursos técnicos</h3>
            <ul class="list-group list-group-flush">
                @forelse ($element['curso_tecnico'] as $course)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                            <b>Nombre:</b>
                            <span class="text-info font-weight-bold">
                                {{ $course->nombre_curso }}
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

                @forelse ($element['curso_docente'] as $course)
                    
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre:</b>
                        <span class="text-info font-weight-bold">
                             {{ $course->nombre_curso }}
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
                                <a class="btn btn-info btn-lg" href="{{route('curricula.capture', array( 3))}}">Editar CV</a>
                        </div>
        @else
                @can('editar-cualquier-usuario')
                        <div class="text-center">
                                <a class="btn btn-info btn-lg" href="{{route('curricula.capture', array( 3))}}">Editar CV</a>
                        </div>
                        @php
                        session()->put('admin_prof_edit', $curriculum->user_id);
                    @endphp
                @endcan
        @endif
    </div>
@endsection