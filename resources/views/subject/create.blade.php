@extends('layout')

@section('title', 'Registrar tema a impartir')

@section('content')
    <h1 class="text-secondary text-center">Registrar tema a impartir</h1>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('subjects.store') }}">

        @include('subject.form', ['btnTxt' => 'Guardar'])

    </form>
@endsection