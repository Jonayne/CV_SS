@extends('layout')

@section('title', 'Buscar profesor')

@section('content')
    <h1 class="text-secondary text-center">Búsqueda de profesor &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
      </svg> </h1>
    @if ($errors->first())
        <hr>
        <div class="container text-center alert-danger">
            <ul>
                <li>{{ $errors->first() }}</li>
            </ul>
        </div>
        <hr>
    @endif
    
    <form method="POST" action="{{ route('buscar_profesor.searchOnDB') }}">
        @csrf 

        <div class="container bg-primary text-black py-4">
            <div class="form-group">

                <label for="name">Nombre del profesor</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                <br>

                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" value="{{ old('email')}}">
                <br>

                <label for="rfc">RFC</label>
                <input type="text" id="rfc" name="rfc" class="form-control" value="{{ old('rfc')}}">
                <br>

                <label for="curp">CURP</label>
                <input type="text" id="curp" name="curp" class="form-control" value="{{ old('curp')}}">
                <br>
                
                <br>
            </div>
            <div class="text-center">
                <button class="btn btn-info btn-lg" type="submit"> Buscar </button>
            </div>
        </div>
    </form>
@endsection
