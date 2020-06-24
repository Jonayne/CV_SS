@csrf 
<div class="container bg-primary text-black py-2">
    <div class="form-group">
        
        <label class="required" for="nombre">Documento</label>
        <select class="form-control" name="nombre" id="nombre">
            @if (!old('nombre', $sd->documento))
                <option value="" selected>Seleccionar</option>
                @foreach ($nombres_docs as $item)
                    <option value="{{$item}}"> {{$item}} </option>
                @endforeach
            @else
                @foreach ($nombres_docs as $item)
                    <option value="{{$item}}" 
                    @if (old('nombre', $sd->documento) == $item)
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
            <button class="btn btn-success btn-lg" name="formNum" value="7" type="submit"> {{ $btnTxt }} </button>
        </div>

    </div>
</div>
