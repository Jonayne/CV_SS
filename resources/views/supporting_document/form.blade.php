@csrf 
<div class="container bg-primary text-black py-2">
    <div class="form-group">
        <label class="required" for="nombre">Nombre del documento</label>
        <input type="text" id="nombre" class="form-control" name="nombre" value="{{ old('nombre', $sd->nombre)}}">
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
        <br>

        <label class="required" for="es_documento_academico">Tipo de documento</label>
        <select id="es_documento_academico" name="es_documento_academico" class="form-control">
            @if(!isset($sd->es_documento_academico))
                <option value="" selected>Escoger...</option>
                <option value="true">Documento probatorio académico</option>
                <option value="false">Documento probatorio personal</option>
            @elseif($sd->es_documento_academico)
                <option value="true" selected>Documento probatorio académico</option>
                <option value="false">Documento probatorio personal</option>
            @else
                <option value="true">Documento probatorio académico</option>
                <option value="false" selected>Documento probatorio personal</option>
            @endif
        </select>
        <br><br>
        <div class="text-center">
            <a class="btn btn-dark btn-lg" href="{{route('curricula.capture',session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
            &nbsp;
            <button class="btn btn-success btn-lg" name="formNum" value="7" type="submit"> {{ $btnTxt }} </button>
        </div>

    </div>
</div>
