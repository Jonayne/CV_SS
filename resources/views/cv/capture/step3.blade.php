@extends('layout')

@section('title', 'Cursos extracurriculares')

@section('content')
    <h1 class="text-secondary text-center">Cursos extracurriculares</h1>
    <hr>
    @include('cv.capture.partials.cv_status')
    <hr>
    @include('cv.capture.partials.nav')
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
                            </span><br><br>
                            <div class="btn-group">
                                <a class="btn btn-outline-info btn-sm" href="{{route('extracurricular_courses.edit', $course)}}">
                                    Editar
                                </a>
                                &nbsp;
                                <form method="POST" action="{{route('extracurricular_courses.destroy', $course)}}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                                </form>  
                            </div>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        Aún no hay cursos técnicos registrados
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
                        <br><br>
                        <div class="btn-group">
                            <a class="btn btn-outline-info btn-sm" href="{{route('extracurricular_courses.edit', $course)}}">
                                Editar
                            </a>
                            &nbsp;
                            <form method="POST" action="{{route('extracurricular_courses.destroy', $course)}}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                            </form>  
                        </div>
                    </li>
                @empty

                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        Aún no hay cursos de formación docente registrados
                    </li>
                @endforelse
            </ul>
            <hr>
            <a class="btn btn-success btn-lg" href="{{route('extracurricular_courses.create')}}">
                Agregar curso
            </a>
        </div>
        <hr>
        <div class="text-center">
            <div class="btn-group">
                    <a href={{route('home')}} class="btn btn-outline-danger btn-lg mt-3 mr-5">Salir</a>
                    <a type="submit" href="/capturar_cv_certificaciones_obtenidas" class="btn btn-primary btn-lg mt-3">Siguiente</a>
            </div>
        </div>
        
    </div>
@endsection