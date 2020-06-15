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
            </ul>
        </h5>
        <ul class="list-group">
            @forelse ($result as $user)
                @if ($user->id)
                        @if (($user->status) == 'en_proceso')
                            <a class="list-group-item list-group-item-light list-group-item-action disabled" href="#">
                                Nombre registrado: <strong>{{formatName($user)}}</strong><br>
                                Email registrado: <strong>{{$user->email}}</strong><br>
                                Estado del currículum: <span class="text-danger"><strong> EN PROCESO DE CAPTURA </strong></span>
                            </a>
                        @else
                            <a class="list-group-item list-group-item-light list-group-item-action" href="{{route('curricula.show1', $user->id)}}">
                                Nombre completo: <strong>{{formatName($user)}}</strong><br>
                                Email personal: <strong>{{$user->email}}</strong><br>
                                CURP: <strong>{{$user->curp}}</strong><br>
                                RFC: <strong>{{$user->rfc}}</strong><br>
                                Estado del currículum: <span class="text-info"><strong> CAPTURADO </strong></span>
                            </a>
                        @endif                 
                @else
                    <a class="list-group-item list-group-item-light list-group-item-action disabled" href="#">
                        Email registrado: <strong>{{$user->email}}</strong><br>
                        Estado del currículum: <span class="text-danger"><strong> NO CAPTURADO </strong></span>
                    </a>
                @endif
                    
                    <hr>
            @empty
                <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger text-center">
                    No se encontraron coincidencias para su búsqueda. 

                    <br>Verifique que los filtros de su búsqueda sean correctos. 
                    Si es el caso, es probable que el profesor aún no haya registrado su currículum.
                    
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
