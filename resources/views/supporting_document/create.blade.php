@extends('layout')

@section('title', 'Registrar documento probatorio...')

@section('content')
    <h1 class="text-secondary text-center">Subir nuevo documento probatorio</h1>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('supporting_documents.store') }}" enctype="multipart/form-data" onsubmit='$("#formNum").attr("disabled", "true")'>

        @include('supporting_document.form', ['btnTxt' => 'Guardar'])
        @php
            $random_token = Str::random(32);
            session()->put('random_token', $random_token);
        @endphp
        <input type="hidden" id="unique_token" name="unique_token" value="{{$random_token}}">
    </form>
@endsection