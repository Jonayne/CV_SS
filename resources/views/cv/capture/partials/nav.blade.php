<div class="container">
    <nav class="navbar navbar-light navbar-expand-lg bg-primary shadow-sm">
        <ul class="nav nav-pills nav-fill justify-content-center">
            <li class="nav-item">
                <a href="{{route('curricula.capture1', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.capture1') ? 'active' : ''}}">
                    <b>Datos personales</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.capture2', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.capture2') ? 'active' : ''}}">
                <b>Grados académico y carrera</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.capture3', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.capture3') ? 'active' : ''}}">
                <b>Cursos extracurriculares</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.capture4', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.capture4') ? 'active' : ''}}">
                <b>Certificaciones obtenidas</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.capture5', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.capture5') ? 'active' : ''}}">
                <b>Lista de temas a impartir</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.capture6', $curriculum->id)}}" 
                class="nav-link {{ Route::is('curricula.capture6') ? 'active' : ''}}">
                <b>Experiencia profesional previa</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.capture7', $curriculum->id)}}"  
                class="nav-link {{ Route::is('curricula.capture7') ? 'active' : ''}}">
                <b>Documentos probatorios</b></a></li>  
        </ul>
    </nav>
</div>   
