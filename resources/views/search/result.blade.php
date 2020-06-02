@extends('layout')

@section('title', 'Resultado de búsqueda')

@section('content')

    <h1 class="text-secondary text-center">Resultado de la búsqueda</h1>

    <div class="container bg-primary text-black py-4">
        <h5 class="text-black text-center">Su filtración: 
            <ul>
                @if ($nombre)
                        <li> Nombre: <b> {{$nombre}} </b></li>
                @endif
                @if ($correo)
                    <li> Correo: <b> {{$correo}} </b></li>
                @endif 
            </ul>
        </h5>
        <ul class="list-group">
            @forelse ($result as $user)
                @if ($user->curriculum)
                    <a class="list-group-item list-group-item-light list-group-item-action" href="{{route('curricula.show', $user->curriculum->id)}}">
                        Nombre: <strong>{{formatName($user)}} </strong><br>
                        Email: <strong>{{$user->email}}</strong><br>
                        Curriculum: <span class="text-info"><strong> CAPTURADO </strong></span>
                    </a>
                @else
                    <a class="list-group-item list-group-item-light list-group-item-action disabled" href="#">
                        Nombre: <strong>{{formatName($user)}} </strong><br>
                        Email: <strong>{{$user->email}}</strong><br>
                        Curriculum: <span class="text-danger"><strong> NO CAPTURADO </strong></span>
                    </a>
                @endif
                <hr>
            @empty
                <li class="list-group-item border-0 mb-3 shadow-sm list-group-item-danger text-center">
                    No se encontró ninguna coincidencia para su búsqueda
                </li>
            @endforelse
            <hr>
        </ul>
        <a href="{{ route('buscar_profesor.index') }}" class="btn btn-primary btn-lg">
            Regresar y hacer otra búsqueda
        </a>

    </div>

@endsection
