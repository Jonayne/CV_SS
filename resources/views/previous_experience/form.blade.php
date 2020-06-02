@csrf 
<div class="container bg-primary text-black py-3">
    <div class="form-group">
        <label for="periodo">Periodo</label>
        <input type="text" id="periodo" name="periodo" class="form-control" value="{{ old('periodo', $pe->periodo)}}">
        <br>
        <label for="institucion">Institución</label>
        <input type="text" id="institucion" name="institucion" class="form-control" value="{{ old('institucion', $pe->institucion)}}">
        <br>
        <label for="cargo">Cargo</label>
        <input type="text" id="cargo" name="cargo" class="form-control" value="{{old('cargo', $pe->cargo)}}">
        <br>
        <label for="actividades_principales">Actividades principales</label>
        <textarea id="actividades_principales" class="form-control" name="actividades_principales">{{old('actividades_principales', $pe->actividades_principales)}}</textarea>
    </div>
    <div class="text-center">
        <a class="btn btn-dark btn-lg" href="{{route(session()->get('previous_url'))}}"> Cancelar </a>
        &nbsp;
        <button class="btn btn-success btn-lg" name="formNum" value="6" type="submit"> {{ $btnTxt }} </button>
    </div>
</div>

