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
                @include('partials/nav')
                @include('partials.session_status')
            </header>

            <main class="py-4">
                @yield('content')
            </main>
            
            <footer class="text-center text-black-50 py-3 shadow">
                {{ config('app.name') }} | Este es el footer {{ date('Y') }}
            </footer>
        </div>
    </body>
</html>