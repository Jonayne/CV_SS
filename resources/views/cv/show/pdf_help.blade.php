@extends('layout')

@section('title', 'Exportación a PDF')

@section('content')
    <h1 class="text-secondary text-center">¿Cómo exportar el currículum a formato PDF?&nbsp;
        <svg class="bi bi-book-half" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 0 0 7.5 2.5v11a.5.5 0 0 0 .854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 0 0-.799-.34 12.96 12.96 0 0 0-2.073-.609zM15 2.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.387-.023-3.426.56V2.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0 1 15 2.82z"/>
                <path fill-rule="evenodd" d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 0 1 8.5 2.5v11a.5.5 0 0 1-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 0 1 0 13.5v-11a.5.5 0 0 1 .276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 0 1 .22-.103 12.958 12.958 0 0 1 2.7-.869z"/>
        </svg>
    </h1>

    <div class="container bg-light text-black py-3">
        <p class="h4 mb-1">El proceso a seguir consta de los siguientes pasos:
            <br><small class="text-muted h6">(Pueden variar ligeramente de programa a programa)</small>
        </p>
        <hr>
        <ul class="list-unstyled">
            <li>1 - Descargar el curriculum.</li>
            <li>2 - Abrir el currículum en su programa de edición de textos.</li>
            <li>3 - Dar clic en <b>Archivo</b>.</li>
            <li>4 - Dirigirse a la opción de <b>Exportar</b>.</li>
            <li>5 - Seleccionar el formato de <b>PDF</b>.</li>
                <ul>
                    <li>En Word, tendrá la opción de <b>Crear documento PDF/XPS</b></li>
                    <li>En otros editores, simplemente cambiar el tipo de archivo a <b>PDF</b></li>
                </ul>
            <li>6 - Escoger la ruta de su preferencia, y darle a <b>Guardar</b>.</li>
        </ul>
        <hr>
        <div class="text-center">
            <div class="btn-group">
                    <a href={{ url()->previous() }} class="btn btn-outline-info btn-lg mt-3">Regresar</a>
            </div>
        </div>

    </div>
@endsection
