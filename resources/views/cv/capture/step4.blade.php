@extends('layout')

@section('title', 'Certificaciones obtenidas')

@section('content')
    <h1 class="text-secondary text-center">Certificaciones obtenidas&nbsp;
        <svg class="bi bi-layers" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3.188 8L.264 9.559a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882L12.813 8l-1.063.567L14.438 10 8 13.433 1.562 10 4.25 8.567 3.187 8z"/>
            <path fill-rule="evenodd" d="M7.765 1.559a.5.5 0 0 1 .47 0l7.5 4a.5.5 0 0 1 0 .882l-7.5 4a.5.5 0 0 1-.47 0l-7.5-4a.5.5 0 0 1 0-.882l7.5-4zM1.563 6L8 9.433 14.438 6 8 2.567 1.562 6z"/>
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
                @forelse ($element as $cert)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <br>
                        
                        <b>Modalidad:</b>
                        <span class="text-info font-weight-bold">
                                {{ $cert->modalidad }}
                        </span>
                        <br>

                        <b>Nombre de la certificación:</b> 
                        <span class="text-info font-weight-bold">
                            {{ $cert->nombre }}
                        </span>
                        <br>

                        <b>Institución emisora:</b>
                        <span class="text-info font-weight-bold">
                                {{ $cert->institucion_emisora }}
                        </span>
                        <br><br>

                        <div class="btn-group">
                            <a class="btn btn-outline-info btn-sm mr-2" name="formNum" value="4" href="{{route('certifications.edit', $cert)}}">
                                Editar
                            </a>

                            <form method="POST" action="{{route('certifications.destroy', $cert)}}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                            </form>  
                        </div>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No ha registrado certificaciones aún
                    </li>
                @endforelse
            </ul>
            <hr>
            <a class="btn btn-success btn-lg" name="formNum" value="4" href="{{route('certifications.create')}}">
                Registrar certificación
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
