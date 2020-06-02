@extends('layout')

@section('title', 'Editar curso extracurricular')

@section('content')
    <h1 class="text-secondary text-center">Editar curso extracurricular</h1>
    <hr>
    @include('partials.form_errors')
    
    <form method="POST" action=" {{route('extracurricular_courses.update', $course)}} ">
        @method('PATCH')
        
        @include('extracurricular_course.form', ['btnTxt' => 'Actualizar'])
    </form>
@endsection