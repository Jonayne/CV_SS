@extends('layout')

@section('title', 'Registrar curso extracurricular')

@section('content')
    <h1 class="text-secondary text-center">Registrar curso extracurricular</h1>
    <hr>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('extracurricular_courses.store') }}">

        @include('extracurricular_course.form', ['btnTxt' => 'Guardar'])

    </form>
@endsection