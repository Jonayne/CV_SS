@extends('layout')

@section('title', 'Editar tema a impartir')

@section('content')
    <h1 class="text-secondary text-center">Editar tema</h1>
    @include('partials.form_errors')
    
    <form method="POST" action=" {{route('subjects.update', $subject)}} ">
        @method('PATCH')
        
        @include('subject.form', ['btnTxt' => 'Actualizar'])
    </form>
@endsection