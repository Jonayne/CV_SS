@csrf 
<div class="container bg-primary text-black py-3">
    <div class="form-group">
        <label class="required" for="periodo">Periodo</label>
        <input type="text" id="periodo" name="periodo" class="form-control" value="{{ old('periodo', $pe->periodo)}}" placeholder="(ejemplo) 26 de mayo al 18 de junio de 2019">
        <br>
        <label class="required" for="institucion">Institución</label>
        <input type="text" id="institucion" name="institucion" class="form-control" value="{{ old('institucion', $pe->institucion)}}" placeholder="Institución">
        <br>
        <label class="required" for="cargo">Cargo</label>
        <input type="text" id="cargo" name="cargo" class="form-control" value="{{old('cargo', $pe->cargo)}}" placeholder="Cargo">
        <br>
        <label class="required" for="actividades_principales">Actividades principales</label>
        <textarea id="actividades_principales" class="form-control" name="actividades_principales">{{old('actividades_principales', $pe->actividades_principales)}}</textarea>
        
        @if (isset($curriculum->proyecto_sep) && $curriculum->proyecto_sep)
            <hr>
            <h3 class="text-secondary text-center font-weight-bold"> Participantes de proyecto SEP </h3>
            <h5 class="text-black text-center font-weight-italic"> Si esta experiencia cuenta como <b>Experiencia en capacitación</b> en algún curso de la SEP,<br> por favor active la siguiente casilla e indique el nombre del curso</h5><br>

            <div class="form-check text-center mb-3">
                <label class="form-check-label">
                        <input type="checkbox" name="sep" id="sep" class="form-check-input"
                             {{old('sep') 
                                || $pe->curso_sep || old('curso_sep') ?  
                                        'checked=true' : ''}}>
                        Esta experiencia cuenta como <b>Experiencia en capacitación</b>
                </label>
            </div>
        
            <label class="required" for="curso_sep">Nombre del curso SEP</label>
            <select class="form-control" name="curso_sep" id="curso_sep">
                @if (!old('curso_sep', $pe->curso_sep))
                    <option value="" selected>Seleccionar</option>
                    @foreach ($nombres_cursos as $item)
                        <option value="{{$item}}"> {{$item}} </option>
                    @endforeach
                @else
                    @foreach ($nombres_cursos as $item)
                        <option value="{{$item}}" 
                        @if (old('curso_sep', $pe->curso_sep) == $item)
                            selected
                        @endif>
                        {{$item}}</option>
                    @endforeach
                @endif
            </select>   
        @endif

        <hr>
    </div>
    <div class="text-center">
        <a class="btn btn-dark btn-lg mt-5 mr-2" href="{{route('curricula.capture',session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
        <input type="hidden" id="formNumVal" name="formNumVal" value="6">
        <button class="btn btn-success btn-lg mt-5" name="formNum" id="formNum" type="submit"> {{ $btnTxt }} </button>
    </div>
</div>

