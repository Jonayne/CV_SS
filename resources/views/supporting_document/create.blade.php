@extends('layout')

@section('title', 'Registrar documento probatorio...')

@section('content')
    <h1 class="text-secondary text-center">Subir nuevo documento probatorio</h1>
    @include('partials.form_errors')

    <form method="POST" action="{{ route('supporting_documents.store') }}" enctype="multipart/form-data">

        @include('supporting_document.form', ['btnTxt' => 'Guardar'])

    </form>
@endsection