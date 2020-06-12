@extends('layout')

@section('title', 'Documentos probatorios')

@section('content')
    <h1 class="text-secondary text-center">Documentos probatorios&nbsp;
        <svg class="bi bi-file-post" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
            <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-7z"/>
            <path fill-rule="evenodd" d="M4 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </h1>
    <hr>
    @include('cv.show.partials.nav')
    <br>
    @include('partials.form_errors')

    <div class="container bg-primary text-black py-3">
        <div class="text-center">

            <h3>Documentos probatorios académicos</h3>
            <ul class="list-group list-group-flush">
                @forelse ($sd_aca as $sd)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre de documento:</b>
                        <span class="text-info font-weight-bold">
                             {{$sd->nombre}}
                        </span>
                        <br>
                        <span class="text-info font-weight-bold">
                            <a class="btn btn-link text-secondary text-weigh-bold" href="/storage/supporting_documents/{{$sd->documento}}">Ir al Documento</a>
                        </span>
                        <br>

                        <b>Tipo de documento: </b>
                        <span class="text-info font-weight-bold">
                            
                            @if ($sd->es_documento_academico)
                                Académico
                            @else
                                Personal
                            @endif
                        </span>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No hay documentos probatorios académicos registrados
                    </li>
                @endforelse
            </ul>

            <hr>

            <h3> Documentos probatorios personales </h3>
            <ul class="list-group list-group-flush">
                @forelse ($sd_naca as $sd)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre de documento:</b>
                        <span class="text-info font-weight-bold">
                             {{$sd->nombre}}
                        </span>
                        <br>
                        <span class="text-info font-weight-bold">
                            <a class="btn btn-link text-secondary text-weigh-bold" href="/storage/supporting_documents/{{$sd->documento}}">Ir al Documento</a>
                        </span>
                        <br>

                        <b>Tipo de documento: </b>
                        <span class="text-info font-weight-bold">
                            
                            @if ($sd->es_documento_academico)
                                Académico
                            @else
                                Personal
                            @endif
                        </span>
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No hay documentos probatorios personales registrados
                    </li>
                @endforelse
            </ul>
            <br>
        </div>
            @if ($curriculum->user_id == auth()->user()->id)
                <div class="text-center">
                        <a class="btn btn-info btn-lg" href="{{route('curricula.capture7')}}">Editar CV</a>
                </div>
            @endif
    </div>

@endsection
