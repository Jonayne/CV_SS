@extends('layout')

@section('title', 'Editar certificación')

@section('content')
    <h1 class="text-secondary text-center">Editar certificación</h1>
    @include('partials.form_errors')
    
    <form method="POST" action=" {{route('certifications.update', $certification)}} ">
        @method('PATCH')
        
        @include('certification.form', ['btnTxt' => 'Actualizar'])
    </form>
@endsection