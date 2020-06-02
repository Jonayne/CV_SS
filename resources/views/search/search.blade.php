@extends('layout')

@section('title', 'Buscar profesor')

@section('content')
    <h1 class="text-secondary text-center">Búsqueda de profesor</h1>
    @include('partials.form_errors')
    
    <form method="POST" action="{{ route('buscar_profesor.searchOnDB') }}">
        @csrf 

        <div class="container bg-primary text-black py-4">
            <div class="form-group">

                <label for="name">Nombre del profesor</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                <br>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email')}}">
                <br><br>
            </div>
            <div class="text-center">
                <button class="btn btn-info btn-lg" type="submit"> Buscar </button>
            </div>
        </div>
    </form>
@endsection
