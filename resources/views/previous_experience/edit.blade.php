@extends('layout')

@section('title', 'Editar experiencia profesional')

@section('content')
    <h1 class="text-secondary text-center">Editar experiencia profesional previa</h1>
    @include('partials.form_errors')
    
    <form method="POST" action=" {{route('previous_experiences.update', $pe)}} ">
        @method('PATCH')
        
        @include('previous_experience.form', ['btnTxt' => 'Actualizar'])
    </form>
@endsection