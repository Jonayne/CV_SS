@extends('layout')

@section('title', 'Resultado de búsqueda')

@section('content')

    <h1 class="text-secondary text-center">Resultado de la búsqueda</h1>

    <div class="container bg-primary text-black py-4">
        <h5 class="text-black text-center">Con filtros: 
            <ul>
                @if ($nombre)
                    <li> Nombre: <b> {{$nombre}} </b></li>
                @endif
                @if ($correo)
                    <li> Correo: <b> {{$correo}} </b></li>
                @endif
                @if ($curp)
                    <li> CURP: <b> {{$curp}} </b></li>
                @endif
                @if ($rfc)
                    <li> RFC: <b> {{$rfc}} </b></li>
                @endif 
                @if ($categoria_de_pago)
                    <li> Categoría de Pago: <b> {{$categoria_de_pago}} </b></li>
                @endif
            </ul>
        </h5>
        <ul class="list-group">
            @forelse ($result as $usuario)
                @if ($usuario->id_curriculum)
                        @if (($usuario->status) == 'en_proceso')
                            <li class="list-group-item list-group-item-light list-group-item-action">
                                Nombre registrado: <strong>{{formatName($usuario)}}</strong><br>
                                Email registrado: <strong>{{$usuario->email}}</strong><br>
                                Estado del currículum: <span class="text-danger"><strong> EN PROCESO DE CAPTURA </strong></span>
                                <hr>
                                <div class="text-center">
                                    <a class="btn btn-outline-info btn-sm" href="{{route('actualizar_cat_pago.indexCatPago', $usuario->id_user)}}">
                                        Actualizar Categoría de Pago
                                    </a>
                                </div>
                            </li>
                        @else
                            <li class="list-group-item list-group-item-light list-group-item-action">
                                Nombre completo: <strong>{{formatName($usuario)}}</strong><br>
                                Email personal: <strong>{{$usuario->email}}</strong><br>
                                CURP: <strong>{{$usuario->curp}}</strong><br>
                                RFC: <strong>{{$usuario->rfc}}</strong><br>
                                Estado del currículum: <span class="text-info"><strong> CAPTURADO </strong></span>
                                <hr>
                                <div class="text-center">
                                    <a class="btn btn-outline-info btn-sm mr-5" href="{{route('actualizar_cat_pago.indexCatPago', $usuario->id_user)}}">
                                        Actualizar Categoría de Pago
                                    </a>
                                    <a href="{{route('curricula.show', array($usuario->id_curriculum, 1))}}" class="btn btn-outline-success btn-sm"> Ver currículum </a>
                                </div>
                            </li>
                        @endif                 
                @else
                    <a class="list-group-item list-group-item-light list-group-item-action disabled" href="#">
                        Email registrado: <strong>{{$usuario->email}}</strong><br>
                        Estado del currículum: <span class="text-danger"><strong> NO CAPTURADO </strong></span>
                    </a>
                @endif
                    
                    <hr>
            @empty
                <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger text-center">
                    No se encontraron coincidencias para su búsqueda. 

                    <br>Verifique que los filtros de su búsqueda sean correctos. (Tome en cuenta acentos)<br>
                        También es posible que el profesor aún no haya registrado su currículum.
                </li>
            @endforelse
            <hr>
        </ul>
        <div class="text-center">
            <a href="{{ route('buscar_profesor.index') }}" class="btn btn-secondary btn-lg">
                Regresar y hacer otra búsqueda
            </a>
        </div>        

    </div>

@endsection
