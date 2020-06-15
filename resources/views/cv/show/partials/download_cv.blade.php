<form action="{{route('curricula.downloadCV', $curriculum->id)}}" method="POST">
    @csrf
    <div class="container bg-primary text-black py-3">
        <h4 class="text-center text-secondary">Uso exclusivo de Control Escolar</h4><br>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" 
                    for="categoria_de_pago">Categoría de pago</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="categoria_de_pago" 
                        placeholder="{{ old('categoria_de_pago')}}" name="categoria_de_pago">
            </div>
        </div>
        <div class="form-group row">
            <label class="required col-md-4 col-form-label text-md-right" 
                    for="formato_curriculum">Formato de currículum</label>
            <div class="col-md-6">
                <select class="form-control" name="formato_curriculum" id="formato_curriculum">
                    @if (( old('formato_curriculum')) == 'curriculum_SEP')
                            <option value="curriculum_SEP" selected>Formato curriculum SEP</option>
                            <option value="FORMATO_CV-CE">Formato curriculum CE</option>
                    @elseif(( old('formato_curriculum')) == 'FORMATO_CV-CE')
                            <option value="curriculum_SEP">UNAM</option>
                            <option value="FORMATO_CV-CE" selected>Externo</option>
                    @else
                            <option value="" selected>Seleccionar</option>
                            <option value="curriculum_SEP">Formato curriculum SEP</option>
                            <option value="FORMATO_CV-CE">Formato curriculum CE</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="required col-md-4 col-form-label text-md-right" 
                    for="formato_descarga">Formato de descarga</label>
            <div class="col-md-6">
                <select class="form-control" name="formato_descarga" id="formato_descarga">
                    @if (( old('formato_descarga')) == 'docx')
                            <option value="docx" selected>Word</option>
                            <option value="pdf">PDF</option>
                    @elseif(( old('formato_descarga')) == 'pdf')
                            <option value="docx">Word</option>
                            <option value="pdf" selected>PDF</option>
                    @else
                            <option value="" selected>Seleccionar</option>
                            <option value="docx">Word</option>
                            <option value="pdf">PDF</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" name="formNum" value="download" class="btn btn-outline-secondary btn-lg mt-3">
                Descargar curriculum
            </a>
        </div>
    </div>
</form>
<br>
