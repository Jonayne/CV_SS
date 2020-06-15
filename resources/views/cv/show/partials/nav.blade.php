<div class="container">
    <nav class="navbar navbar-light navbar-expand-lg bg-primary shadow-sm">
        <ul class="nav nav-pills nav-fill justify-content-center">
            <li class="nav-item">
                <a href="{{route('curricula.show1', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show1') ? 'active' : ''}}">
                    <b>Datos personales</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show2', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show2') ? 'active' : ''}}">
                <b>Grados académico y carrera</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show3', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show3') ? 'active' : ''}}">
                <b>Cursos extracurriculares</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show4', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show4') ? 'active' : ''}}">
                <b>Certificaciones obtenidas</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show5', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show5') ? 'active' : ''}}">
                <b>Lista de temas a impartir</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show6', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show6') ? 'active' : ''}}">
                <b>Experiencia profesional previa</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show7', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.show7') ? 'active' : ''}}">
                <b>Documentos probatorios</b></a></li>
        </ul>
    </nav>
</div>   
