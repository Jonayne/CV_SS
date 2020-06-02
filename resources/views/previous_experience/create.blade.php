@extends('layout')

@section('title', 'Registrar experiencia previa...')

@section('content')
    <h1 class="text-secondary text-center">Registrar experiencia profesional previa</h1>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('previous_experiences.store') }}">

        @include('previous_experience.form', ['btnTxt' => 'Guardar'])

    </form>
@endsection