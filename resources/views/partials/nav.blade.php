<nav class="navbar navbar-light navbar-expand-lg bg-primary shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            <b>{{ config('app.name') }}</b>
        </a>
        <ul class="nav nav-pills">
            @auth
                <li><a class="nav-link btn btn-outline-danger btn-sm" href="#" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    Cerrar sesión</a></li>  
            @endauth     
        </ul>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>