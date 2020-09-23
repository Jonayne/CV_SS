<nav class="navbar navbar-dark navbar-expand-lg shadow-sm" style="background-color: rgba(64, 11, 187, 0.692)">

    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            <b>{{ config('app.name') }}</b>
        </a>
        <ul class="nav nav-pills">
            @auth
                <li><a class="nav-link btn btn-danger btn-sm" href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Cerrar sesión</a></li>  
            @endauth     
        </ul>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>