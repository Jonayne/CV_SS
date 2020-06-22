@extends('layout')

@section('title', 'Registrar certificación')

@section('content')
    <h1 class="text-secondary text-center">Registrar certificación</h1>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('certifications.store') }}">

        @include('certification.form', ['btnTxt' => 'Guardar'])

    </form>
@endsection