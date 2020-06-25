@csrf 
<div class="container bg-primary text-black py-2">
    <div class="form-group">
        <label class="required" for="modalidad">Modalidad</label>
        <input type="text" id="modalidad" name="modalidad" class="form-control" value="{{ old('modalidad', $certification->modalidad)}}">
        <br>

        <label class="required" for="nombre_cert">Nombre de certificación</label>
        <input type="text" id="nombre_cert" name="nombre_cert" class="form-control" value="{{ old('nombre_cert', $certification->nombre_cert)}}">
        <br>

        <label class="required" for="institucion_emisora">Institución emisora</label>
        <input type="text" id="institucion_emisora" class="form-control" name="institucion_emisora" value="{{old('institucion_emisora', $certification->institucion_emisora)}}">
        <br><br>
        <div class="text-center">
            <a class="btn btn-dark btn-lg" href="{{route('curricula.capture',session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
            &nbsp;
            <button class="btn btn-success btn-lg" name="formNum" value="4" type="submit"> {{ $btnTxt }} </button>
        </div>  
    </div>
</div>
