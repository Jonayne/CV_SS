@extends('layout')

@section('title', 'Captura de CV - Paso 7')

@section('content')
    <h1 class="text-secondary text-center">Documentos probatorios</h1>
    <hr>
    @include('cv.create.partials.nav')
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
                @forelse ($sd_aca as $sd)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre de documento:</b>
                        <span class="text-info font-weight-bold">
                             {{$sd->nombre}}
                        </span>
                        <br>
                        <span class="text-info font-weight-bold">
                            <a class="btn btn-info" href="/storage/supporting_documents/{{$sd->documento}}">Documento</a>
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
                @forelse ($sd_naca as $sd)
                    <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-primary">
                        <b>Nombre de documento:</b>
                        <span class="text-info font-weight-bold">
                             {{$sd->nombre}}
                        </span>
                        <br>
                        <span class="text-info font-weight-bold">
                            <a class="btn btn-info" href="/storage/supporting_documents/{{$sd->documento}}">Documento</a>
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
            <form action="{{route('curricula.store')}}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg mt-4">Capturar CV</button>
            </form>
        </div>
    </div>

@endsection
