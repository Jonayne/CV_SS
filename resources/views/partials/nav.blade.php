<nav class="navbar navbar-dark navbar-expand-lg shadow-sm" style="background-color: rgba(64, 11, 187, 0.692)">

    <div class="container py-2">

        <a class="navbar-brand" href="{{ route('home') }}">
            <b>{{ config('app.name') }}</b>
        </a>
        
        <ul class="nav nav-pills justify-content-center">
            @auth
                @can('buscar-profesor')
                    <li class="nav-item"><a class="btn btn-primary btn text-dark mr-5" @can('editar-cualquier-usuario') href="{{ route('buscar_profesor.indexUser') }}" 
                        @elsecan('buscar-profesor') href="{{ route('buscar_profesor.index') }}"> @endcan
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                        </svg> - @can('editar-cualquier-usuario')Ver lista de usuarios @elsecan('buscar-profesor') Buscar a profesor @endcan 
                    </a></li>
                @endcan
            
                {{-- Si puede registrar a un usuario --}}
                @can('registrar-usuario')
                    <li class="nav-item"><a class="btn btn-primary btn text-dark mr-5" href="{{ route('registrar_usuario.index') }}">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                        </svg> - Registrar nuevo usuario
                    </a></li>
                @endcan
        </ul>
        <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link btn btn-danger btn-sm" href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Cerrar sesión</a></li>  
            @endauth

        </ul>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>