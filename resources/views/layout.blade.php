<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title', config('app.name'))</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <script src="{{ mix('/js/app.js') }}" defer></script>
    </head>

    <body>
        <div id="app" class="d-flex flex-column h-screen justify-content-between">
            <header>
                @include('partials.nav')
                @include('partials.session_status')
            </header>

            <main class="py-4">
                @yield('content')
            </main>
            
            <footer class="footer text-center">
                <div class="container alert">
                    <a class="text-warning font-weight-bold" href="https://www.tic.unam.mx/avisosprivacidad/"> Avisos de privacidad | Portal TIC UNAM </a>
                </div>
            </footer>
        </div>
    </body>
</html>