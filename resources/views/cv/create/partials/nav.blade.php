<div class="container">
    <nav class="navbar navbar-light navbar-expand-lg bg-primary shadow-sm">
        <ul class="nav nav-pills nav-fill justify-content-center">
            <li class="nav-item">
                <a href="/capturar_cv_datos_personales" 
                class="nav-link {{ Route::is('curricula.create') ? 'active' : ''}}">
                    <b>Datos personales</b></a></li>
            <li class="nav-item">
                <a href="/capturar_cv_datos_academicos" 
                class="nav-link {{ Route::is('curricula.create2') ? 'active' : ''}}
                {{ session()->get('disabledList.create2_disabled') }}">
                <b>Grados académico y carrera</b></a></li>
            <li class="nav-item">
                <a href="/capturar_cv_cursos_extracurriculares" 
                class="nav-link {{ Route::is('curricula.create3') ? 'active' : ''}}
                {{ session()->get('disabledList.create3_disabled') }}">
                <b>Cursos extracurriculares</b></a></li>
            <li class="nav-item">
                <a href="/capturar_cv_certificaciones_obtenidas" 
                class="nav-link {{ Route::is('curricula.create4') ? 'active' : ''}}
                {{ session()->get('disabledList.create4_disabled') }}">
                <b>Certificaciones obtenidas</b></a></li>
            <li class="nav-item">
                <a href="/capturar_cv_lista_de_temas" 
                class="nav-link {{ Route::is('curricula.create5') ? 'active' : ''}}
                {{ session()->get('disabledList.create5_disabled') }}">
                <b>Lista de temas a impartir</b></a></li>
            <li class="nav-item">
                <a href="/capturar_cv_experiencia_previa" 
                class="nav-link {{ Route::is('curricula.create6') ? 'active' : ''}}
                {{ session()->get('disabledList.create6_disabled') }}">
                <b>Experiencia profesional previa</b></a></li>
            <li class="nav-item">
                <a href="/capturar_cv_documentos_probatorios" 
                class="nav-link {{ Route::is('curricula.create7') ? 'active' : ''}}
                {{ session()->get('disabledList.create7_disabled') }}">
                <b>Documentos probatorios</b></a></li>  
        </ul>
    </nav>
</div>   
