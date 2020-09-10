@extends('layout')

@section('title', 'Actualizar usuario')

@section('content')
    <h1 class="text-secondary text-center">Actualizar "Categoría de Pago" de usuario.</h1>
    @include('partials.form_errors')
    
    <form method="POST" action=" {{route('actualizar_cat_pago.saveCatPago', $user->id)}} ">
        @method('PATCH')
        
        @csrf 
        <div class="container bg-primary text-black py-2">
            <div class="form-group">
                <label class="required" for="categoria_de_pago">Categoría de Pago</label>
                <select class="form-control" name="categoria_de_pago" id="categoria_de_pago">
                    @if (!old('categoria_de_pago', $user->categoria_de_pago))
                        <option value="" selected>Seleccionar...</option>
                        @foreach ($cat_pago_list as $item)
                            <option value="{{$item}}"> {{$item}} </option>
                        @endforeach
                    @else
                        @foreach ($cat_pago_list as $item)
                            <option value="{{$item}}" 
                            @if (old('categoria_de_pago', $user->categoria_de_pago) == $item)
                                selected
                            @endif>
                            {{$item}}</option>
                        @endforeach
                    @endif
                </select>
                <hr>
                <br>
                <div class="text-center">
                    <a class="btn btn-dark btn-lg mr-5" href="{{ url()->previous() }}"> Regresar </a>
                    <button class="btn btn-success btn-lg" name="update_cat" id="update_cat" type="submit"> Actualizar </button>
                </div>  
            </div>
        </div>
    </form>
@endsection