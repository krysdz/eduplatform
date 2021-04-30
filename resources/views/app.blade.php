<!DOCTYPE html>
<html lang="pl" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="is-flex is-flex-direction-column min-vh-100">
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="{{ route('index') }}">
                    Eduplatform
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                   data-target="mainNavbar">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            @yield('navbar')

            <div class="navbar-end">
                @guest
                    <div class="navbar-item">
                        <a href="{{ route('login') }}" class="button is-primary">
                            <strong>Zaloguj</strong>
                        </a>
                    </div>
                @endguest
                @auth
                    <a href=# class="navbar-item">
                        Witaj {{ auth()->user() }}
                    </a>
                    <div class="navbar-item">
                        <a href="{{ route('logout') }}" class="button is-light">
                            Wyloguj
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="is-flex-full">
        @yield('vertical_nav')

        <main>
            @yield('upper_content')

            <div class="container is-content-box px-5">
                @include('include.app.flash_messages')
                @include('include.app.form_errors')

                @yield('content')
            </div>
        </main>
    </div>

    <footer class="footer">
        <div class="content has-text-centered">
            <p><strong>Eduplatform</strong> by Krystian Dziewa.</p>
            <p>Internetowa platforma wspomagania nauczania</p>
        </div>
    </footer>

    <script src="{{ asset('node_modules/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
