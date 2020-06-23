<div class="container">
    <nav class="navbar navbar-light navbar-expand-lg bg-primary shadow-sm">
        <ul class="nav nav-pills nav-fill justify-content-center">
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 1))}}" 
                    class="nav-link {{ $formNum == 1 ? 'active' : ''}}">
                    <b>Datos personales</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 2))}}"  
                    class="nav-link {{ $formNum == 2 ? 'active' : ''}}">
                <b>Grados académico y carrera</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 3))}}" 
                    class="nav-link {{ $formNum == 3 ? 'active' : ''}}">
                <b>Cursos extracurriculares</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 4))}}" 
                    class="nav-link {{ $formNum == 4 ? 'active' : ''}}">
                <b>Certificaciones obtenidas</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 5))}}" 
                    class="nav-link {{ $formNum == 5 ? 'active' : ''}}">
                <b>Lista de temas a impartir</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 6))}}" 
                    class="nav-link {{ $formNum == 6 ? 'active' : ''}}">
                <b>Experiencia profesional previa</b></a></li>
            <li class="nav-item">
                <a href="{{route('curricula.show', array($curriculum->id, 7))}}" 
                    class="nav-link {{ $formNum == 7 ? 'active' : ''}}">
                <b>Documentos probatorios</b></a></li>
        </ul>
    </nav>
</div>   
