@extends('layout')

@section('title', 'Editar documento probatorio')

@section('content')
    <h1 class="text-secondary text-center">Editar documento probatorio</h1>
    @include('partials.form_errors')
    
    <form method="POST" action="{{route('supporting_documents.update', $sd)}}" enctype="multipart/form-data">
        @method('PATCH')
        
        @include('supporting_document.form', ['btnTxt' => 'Actualizar'])
    </form>
@endsection