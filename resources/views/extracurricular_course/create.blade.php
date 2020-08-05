@extends('layout')

@section('title', 'Registrar curso extracurricular')

@section('content')
    <h1 class="text-secondary text-center">Registrar curso extracurricular</h1>
    <hr>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('extracurricular_courses.store') }}" onsubmit='$("#formNum").attr("disabled", "true")'>

        @include('extracurricular_course.form', ['btnTxt' => 'Guardar'])
        @php
            $random_token = Str::random(32);
            session()->put('random_token', $random_token);
        @endphp
        <input type="hidden" id="unique_token" name="unique_token" value="{{$random_token}}">

    </form>
@endsection