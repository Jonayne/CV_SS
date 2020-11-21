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
            <h6 class="text-right font-italic required"> Documentos obligatorios </h6>
            <h6 class="text-right font-italic"> Documentos subidos <span class="text-secondary"> &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
            </svg> </h6>
            <h6 class="text-center font-italic"> La obligatoriedad de los documentos por anexar varía según la información capturada hasta el momento. <br>
                                                Por favor asegúrese de llenar esta sección hasta el final. </h6>
            <hr>
            <h2 class="text-secondary">Sólo se aceptan documentos probatorios con <strong>formato PDF o imágenes</strong></h2>
            <hr>
            <h3>Documentos probatorios académicos</h3>
            <p> Por anexar, copias de:</p>
            <ul>
                @forelse ($element['supportingDocumentAca'] as $sda)
                        <li>
                            @if ($sda['Obligatorio'] == true)
                                <span class="required"> {{$sda['nombre_doc']}} </span>
                            @else
                                <span> {{$sda['nombre_doc']}} </span>
                            @endif
                            @if ($sda['Subido'] == true)
                                    <span class="text-secondary"> &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
                                    </svg> </span>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                            Algo salió mal...
                        </li>
                @endforelse
            </ul>
            <ul class="list-group list-group-flush">
                @forelse ($element['academicos'] as $sd)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre de documento:</b>
                        <span class="text-info font-weight-bold">
                            {{$sd->nombre_doc}}
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
                            <a class="btn btn-outline-info btn-sm" href="{{route('supporting_documents.edit', $sd)}}">
                                Editar
                            </a>
                            &nbsp;
                            <form method="POST" action="{{route('supporting_documents.destroy', $sd)}}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                            </form>  
                        </div> 
                    </li>                    
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
                @forelse ($element['supportingDocumentPers'] as $sda)
                        <li>
                            @if ($sda['Obligatorio'] == true)
                                <span class="required"> {{$sda['nombre_doc']}} </span>
                            @else
                                <span> {{$sda['nombre_doc']}} </span>
                            @endif
                            @if ($sda['Subido'] == true)
                                    <span class="text-secondary"> &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
                                    </svg> </span>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                            Algo salió mal...
                        </li>
                @endforelse
            </ul>
            <ul class="list-group list-group-flush">
                @forelse ($element['personales'] as $sd)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre de documento:</b>
                        <span class="text-info font-weight-bold">
                            {{$sd->nombre_doc}}
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
                            <a class="btn btn-outline-info btn-sm" href="{{route('supporting_documents.edit', $sd)}}">
                                Editar
                            </a>
                            &nbsp;
                            <form method="POST" action="{{route('supporting_documents.destroy', $sd)}}">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"> Eliminar </button>
                            </form>  
                        </div>   
                    </li>
                @empty
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger">
                        No ha subido documentos probatorios personales
                    </li>
                @endforelse
            </ul>
            <hr>
            <a class="btn btn-success btn-lg" href="{{route('supporting_documents.create')}}">
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
