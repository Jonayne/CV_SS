@csrf 
<div class="container bg-primary text-black py-2">
    <div class="form-group">
        <label class="required" for="nombre_tema">Nombre del tema/curso a impartir</label>
        <input type="text" id="nombre_tema" name="nombre_tema" class="form-control" value="{{ old('nombre_tema', $subject->nombre_tema)}}">
        <br>

        <label class="required" for="version">Versión del tema</label>
        <input type="text" id="version" name="version" class="form-control" value="{{ old('version', $subject->version)}}">
        <br>

        <label class="required" for="nivel">Nivel</label>
        <select class="form-control" name="nivel" id="nivel">
            @if (( old('nivel',$subject->nivel)) == 'Básico')
                    <option value="Básico" selected>Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                    <option value="Especializado">Especializado</option>
            @elseif(( old('nivel',$subject->nivel)) == 'Intermedio')
                    <option value="Básico">Básico</option>
                    <option value="Intermedio" selected>Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                    <option value="Especializado">Especializado</option>
            @elseif(( old('nivel',$subject->nivel)) == 'Avanzado')
                    <option value="Básico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado" selected>Avanzado</option>
                    <option value="Especializado">Especializado</option>
            @elseif(( old('nivel',$subject->nivel)) == 'Especializado')
                    <option value="Básico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                    <option value="Especializado" selected>Especializado</option>
            @else
                    <option value="">Seleccionar...</option>
                    <option value="Básico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                    <option value="Especializado">Especializado</option>
            @endif
        </select>
    
        <br>

        <label class="required" for="sistema_operativo">Sistema operativo</label>
        <select class="form-control" name="sistema_operativo" id="sistema_operativo">
            @if (( old('nivel',$subject->sistema_operativo)) == 'Windows')
                    <option value="Windows" selected>Windows</option>
                    <option value="MacOS">MacOS</option>
                    <option value="Linux">Linux</option>
                    <option value="Unix">Unix</option>
            @elseif(( old('nivel',$subject->sistema_operativo)) == 'MacOS')
                    <option value="Windows">Windows</option>
                    <option value="MacOS" selected>MacOS</option>
                    <option value="Linux">Linux</option>
                    <option value="Unix">Unix</option>
            @elseif(( old('nivel',$subject->sistema_operativo)) == 'Linux')
                    <option value="Windows">Windows</option>
                    <option value="MacOS">MacOS</option>
                    <option value="Linux" selected>Linux</option>
                    <option value="Unix">Unix</option>
            @elseif(( old('nivel',$subject->sistema_operativo)) == 'Unix')
                    <option value="Windows">Windows</option>
                    <option value="MacOS">MacOS</option>
                    <option value="Linux">Linux</option>
                    <option value="Unix" selected>Unix</option>
            @else
                    <option value="">Seleccionar...</option>
                    <option value="Windows">Windows</option>
                    <option value="MacOS">MacOS</option>
                    <option value="Linux">Linux</option>
                    <option value="Unix">Unix</option>
            @endif
        </select>
        <br><br>
        <div class="text-center">
            <a class="btn btn-dark btn-lg" href="{{route('curricula.capture',session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
            &nbsp;
            <input type="hidden" id="formNumVal" name="formNumVal" value="5">
            <button class="btn btn-success btn-lg" name="formNum" id="formNum" type="submit"> {{ $btnTxt }} </button>
        </div>  
    </div>
</div>
