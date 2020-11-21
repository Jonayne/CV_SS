@csrf 
<div class="container bg-primary text-black py-2">
    <br>
    <h3 class="text-danger text-center">Recuerde que sólo se aceptan documentos probatorios con <strong>formato PDF o imágenes</strong></h3>
    <br>
    <div class="form-group">
        <label class="required" for="nombre_doc">Documento</label>
        <select class="form-control" name="nombre_doc" id="nombre_doc">
            @if (!old('nombre_doc', $sd->nombre_doc))
                <option value="" selected>Seleccionar</option>
                @foreach ($nombres_docs as $item)
                    <option value="{{$item}}"> {{$item}} </option>
                @endforeach
            @else
                @foreach ($nombres_docs as $item)
                    <option value="{{$item}}" 
                    @if (old('nombre_doc', $sd->nombre_doc) == $item)
                        selected
                    @endif>
                    {{$item}}</option>
                @endforeach
            @endif
        </select>

        <br>

        @if ($sd->documento)
            <input type="hidden" name="edit" id="edit" value="true">

            <a class="btn btn-secondary" href="/storage/supporting_documents/{{$sd->documento}}">Documento actual</a>
            <br>
            <label for="documento">Reemplazar documento</label>
            <input type="file" id="documento" class="form-control-file" name="documento"> 
        @else
            <label class="required" for="documento">Subir documento</label>  
            <input type="file" id="documento" class="form-control-file" name="documento">  
        @endif

        <br><br>
        <div class="text-center">
            <a class="btn btn-dark btn-lg" href="{{route('curricula.capture',session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
            &nbsp;
            <input type="hidden" id="formNumVal" name="formNumVal" value="7">
            <button class="btn btn-success btn-lg" name="formNum" id="formNum" type="submit"> {{ $btnTxt }} </button>
        </div>

    </div>
</div>
