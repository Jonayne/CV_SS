<form action="{{route('curricula.downloadCV', $curriculum->id)}}" method="POST">
    @csrf
    <div class="container bg-primary text-black py-3">
        <h4 class="text-center text-secondary">Uso exclusivo de Control Escolar</h4><br>
        @if (!($usuario->categoria_de_pago))
            <div class="alert alert-info text-center">
                <h5 class="text-secondary">Parece que este profesor aún no tiene registrada su <b>Categoría de Pago</b>.</h5>
                <a class="btn btn-outline-info btn-sm" href="{{route('actualizar_cat_pago.indexCatPago', array('id'=>$usuario->id, 'backPage'=>'download_cv'))}}">
                    Registrar Categoría de Pago
                </a>
            </div>
        @else
            <input type="hidden" id="categoria_de_pago" name="categoria_de_pago" value="{{$usuario->categoria_de_pago}}">
            <div class="form-group row">
                <label class="required col-md-4 col-form-label text-md-right" 
                        for="formato_curriculum">Formato de currículum</label>
                <div class="col-md-6">
                    <select class="form-control" name="formato_curriculum" id="formato_curriculum">
                        @if (( old('formato_curriculum')) == 'curriculum_SEP')
                                <option value="curriculum_SEP" selected>Formato curriculum SEP {{$curriculum->proyecto_sep ? '' : '(Este profesor no participa en el proyecto SEP)'}}</option>
                                <option value="FORMATO_CV_CE">Formato curriculum CE</option>
                        @elseif(( old('formato_curriculum')) == 'FORMATO_CV_CE')
                                <option value="curriculum_SEP">Formato curriculum SEP {{$curriculum->proyecto_sep ? '' : '(Este profesor no participa en el proyecto SEP)'}}</option>
                                <option value="FORMATO_CV_CE" selected>Formato curriculum CE</option>
                        @else
                                <option value="" selected>Seleccionar</option>
                                <option value="curriculum_SEP">Formato curriculum SEP {{$curriculum->proyecto_sep ? '' : '(Este profesor no participa en el proyecto SEP)'}}</option>
                                <option value="FORMATO_CV_CE">Formato curriculum CE</option>
                        @endif
                    </select>
                </div>
            </div>
                
            <div class="text-center">
                <hr>
                <input type="hidden" id="formNumVal" name="formNumVal" value="download">
                @can('editar-cualquier-usuario')
                    <a class="btn btn-outline-dark mb-2 mt-1" href="{{ route('buscar_profesor.indexUser', 
                        array('nombre' => session('searchDataList.nombre'),
                            'correo' => session('searchDataList.correo'),
                            'rfc' => session('searchDataList.rfc'),
                            'curp' => session('searchDataList.curp'),
                            'categoria_de_pago' => session('searchDataList.categoria_de_pago'),
                            'rol_usuario' => session('searchDataList.rol_usuario'),
                            'sede' => session('searchDataList.sede'),
                            'status_user' => session('searchDataList.status_user'))) }}"> Regresar a la lista de usuarios </a>
                @elsecan('buscar-profesor') 
                    <a class="btn btn-outline-dark mb-2 mt-1" href="{{ route('buscar_profesor.searchOnDBProf', 
                        array('nombre' => session('searchDataList.nombre'),
                            'correo' => session('searchDataList.correo'),
                            'rfc' => session('searchDataList.rfc'),
                            'curp' => session('searchDataList.curp'),
                            'categoria_de_pago' => session('searchDataList.categoria_de_pago'))) }}"> Regresar a la búsqueda </a>
                @endcan
                <br>
                <button type="submit" class="btn btn-outline-secondary btn-lg mt-3" aria-describedby="pdf_help_block">
                    Descargar curriculum 
                </button>
                <small id="pdf_help_block" class="form-text">
                    <a class="text-danger" href="{{route('curricula.helpPDF')}}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-diamond" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
                        <path d="M5.25 6.033h1.32c0-.781.458-1.384 1.36-1.384.685 0 1.313.343 1.313 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.007.463h1.307v-.355c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.326 0-2.786.647-2.754 2.533zm1.562 5.516c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                    ¿Cómo obtener la versión PDF de este documento? 
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-question-diamond" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
                        <path d="M5.25 6.033h1.32c0-.781.458-1.384 1.36-1.384.685 0 1.313.343 1.313 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.007.463h1.307v-.355c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.326 0-2.786.647-2.754 2.533zm1.562 5.516c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg></a>
                </small>
            </div>
        @endif
    </div>
</form>
<br>
