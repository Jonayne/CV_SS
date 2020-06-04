@csrf 
<div class="container bg-primary text-black py-2">
    <div class="form-group">
        <label for="version">Versión del tema</label>
        <input type="text" id="version" name="version" class="form-control" value="{{ old('version', $subject->version)}}">
        <br>

        <label for="nivel">Nivel</label>
        <input type="text" id="nivel" name="nivel" class="form-control" value="{{ old('nivel', $subject->nivel)}}">
        <br>

        <label for="sistema_operativo">Sistema operativo</label>
        <input type="text" id="sistema_operativo" class="form-control" name="sistema_operativo" value="{{old('sistema_operativo', $subject->sistema_operativo)}}">
        <br><br>
        <div class="text-center">
            <a class="btn btn-dark btn-lg" href="{{route(session()->get('previous_url') ?? 'home')}}"> Cancelar </a>
            &nbsp;
            <button class="btn btn-success btn-lg" name="formNum" value="5" type="submit"> {{ $btnTxt }} </button>
        </div>  
    </div>
</div>
