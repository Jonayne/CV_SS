@extends('layout')

@section('title', 'Registrar tema a impartir')

@section('content')
    <h1 class="text-secondary text-center">Registrar tema a impartir</h1>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('subjects.store') }}" onsubmit='$("#formNum").attr("disabled", "true")'>

        @include('subject.form', ['btnTxt' => 'Guardar'])
        @php
            $random_token = Str::random(32);
            session()->put('random_token', $random_token);
        @endphp
        <input type="hidden" id="unique_token" name="unique_token" value="{{$random_token}}">
    </form>
@endsection