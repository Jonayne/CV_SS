@extends('layout')

@section('title', 'Documentos probatorios')

@section('content')
    <h1 class="text-secondary text-center">Documentos probatorios</h1>
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
                        <a class="btn btn-info btn-lg" href="{{route('curricula.capture7',$curriculum->id)}}">Editar CV</a>
                </div>
            @endif
    </div>

@endsection
