<div class="container">
    <nav class="navbar navbar-light navbar-expand-lg bg-primary shadow-sm">
        <ul class="nav nav-pills nav-fill justify-content-center">
            <li class="nav-item">
                <a href="{{route('curricula.edit', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit') ? 'active' : ''}}">
                    <b>Datos personales</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.edit2', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit2') ? 'active' : ''}}">
                <b>Grados académico y carrera</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.edit3', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit3') ? 'active' : ''}}">
                <b>Cursos extracurriculares</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.edit4', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit4') ? 'active' : ''}}">
                <b>Certificaciones obtenidas</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.edit5', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit5') ? 'active' : ''}}">
                <b>Lista de temas a impartir</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.edit6', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit6') ? 'active' : ''}}">
                <b>Experiencia profesional previa</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.edit7', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.edit7') ? 'active' : ''}}">
                <b>Documentos probatorios</b></a></li>  
        </ul>
    </nav>
</div>   
