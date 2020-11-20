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
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')
    @can('descargar-cv')
                @include('cv.show.partials.download_cv')
    @endcan
    <div class="container bg-primary text-black py-3">
        <div class="text-center">
            <br>
            <ul class="list-group list-group-flush">
                @forelse ($element as $cert)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Modalidad:</b>
                        <span class="text-info font-weight-bold">
                             {{ $cert->modalidad }}
                        </span>
                        <br>

                        <b>Nombre de la certificación:</b> 
                        <span class="text-info font-weight-bold">
                            {{ $cert->nombre_cert }}
                        </span>
                        <br>

                        <b>Institución emisora:</b>
                        <span class="text-info font-weight-bold">
                             {{ $cert->institucion_emisora }}
                        </span>
                        <br>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No se han registrado certificaciones aún
                    </li>
                @endforelse
            </ul>
            <br>
        </div>
        @if ($curriculum->user_id == auth()->user()->id)
                        <div class="text-center">
                                <a class="btn btn-info btn-lg" href="{{route('curricula.capture', array( 4))}}">Editar CV</a>
                        </div>
        @else
                @can('editar-cualquier-usuario')
                        <div class="text-center">
                                <a class="btn btn-info btn-lg" href="{{route('curricula.capture', array( 4))}}">Editar CV</a>
                        </div>
                        @php
                        session()->put('admin_prof_edit', $curriculum->user_id);
                    @endphp
                @endcan
        @endif
    </div>
    
@endsection
