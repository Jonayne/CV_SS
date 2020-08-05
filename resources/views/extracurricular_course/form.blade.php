@csrf

<div class="container bg-primary text-black py-2">
    <div class="form-group">
        <label class="required" for="nombre_curso">Nombre del curso</label>
        <input type="text" name="nombre_curso" id="nombre_curso" class="form-control" value="{{ old('nombre_curso', $course->nombre_curso)}}">
        <br>
        <label class="required" for="anio">Año del curso</label>
        <input type="text" name="anio" id="anio"  class="form-control" value="{{ old('anio', $course->anio)}}">
        <br>
        <label class="required" for="documento_obtenido">Documento obtenido</label>
        <input type="text" name="documento_obtenido" id="documento_obtenido" class="form-control" value="{{old('documento_obtenido', $course->documento_obtenido)}}">
        <br>
        <label class="required" for="es_curso_tecnico">Tipo de curso</label>
        <select name="es_curso_tecnico" id="es_curso_tecnico" class="form-control">
            @if(!isset($course->es_curso_tecnico))
                <option value="" selected>Escoger...</option>
                <option value="true">Curso técnico</option>
                <option value="false">Curso de formación docente</option>
            @elseif ($course->es_curso_tecnico)
                <option value="true" selected>Curso técnico</option>
                <option value="false">Curso de formación docente</option>
            @else
                <option value="true">Curso técnico</option>
                <option value="false" selected>Curso de formación docente</option>
            @endif

        </select><br><br>
        <div class="text-center">
            <a class="btn btn-dark btn-lg" href="{{route('curricula.capture',session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
            &nbsp;
            <input type="hidden" id="formNumVal" name="formNumVal" value="3">
            <button class="btn btn-success btn-lg" id="formNum" name="formNum" type="submit"> {{ $btnTxt }} </button>
        </div>
    </div>
</div>
