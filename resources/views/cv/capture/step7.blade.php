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
    @include('cv.capture.partials.cv_status')
    <hr>
    @include('cv.capture.partials.nav')
    <br>
    @include('partials.form_errors')

    <div class="container bg-primary text-black py-3">
        <div class="text-center">

            <h3>Documentos probatorios académicos</h3>
            <p> Por anexar, copias de:</p>
            <ul>
                <li><b>Título</b></li>
                <li><b>Cédula profesional o historial académico</b></li>
                <li><b>Comprobantes de cursos técnicos</b></li>
                <li><b>Comprobantes de cursos de formación docente</b></li>
            </ul>
            <ul class="list-group list-group-flush">
                @forelse ($element as $sd)
                    @if($sd->es_documento_academico)
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
                            <br><br>

                            <div class="btn-group">
                                <a class="btn btn-outline-info btn-sm" name="formNum" value="7" href="{{route('supporting_documents.edit', $sd)}}">
                                    Editar
                                </a>
                                &nbsp;
                                <form method="POST" action="{{route('supporting_documents.destroy', $sd)}}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                                </form>  
                            </div> 
                        </li>
                    @endif
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No ha subido documentos probatorios académicos
                    </li>
                @endforelse
            </ul>

            <hr>

            <h3> Documentos probatorios personales </h3>
            <p> Por anexar, copias de:</p>
            <ul>
                <li><b>Constancia de situación fiscal</b></li>
                <li><b>CURP</b></li>
                <li><b>IFE</b></li>
                
                <li><b> (Personal de la UNAM) Último talón de pago</b></li>
            </ul>
            <ul class="list-group list-group-flush">
                @forelse ($element as $sd)
                    @if(!$sd->es_documento_academico)
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
                            <br><br>
                            <div class="btn-group">
                                <a class="btn btn-outline-info btn-sm" name="formNum" value="7" href="{{route('supporting_documents.edit', $sd)}}">
                                    Editar
                                </a>
                                &nbsp;
                                <form method="POST" action="{{route('supporting_documents.destroy', $sd)}}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                                </form>  
                            </div>   
                        </li>
                    @endif
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No ha subido documentos probatorios personales
                    </li>
                @endforelse
            </ul>
            <hr>
            <a class="btn btn-success btn-lg" name="formNum" value="7" href="{{route('supporting_documents.create')}}">
                Subir documento probatorio
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
