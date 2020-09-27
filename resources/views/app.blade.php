<!DOCTYPE html>
<html lang="pl" style="height: 100%">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="is-flex" style="flex-direction: column; min-height: 100vh;">

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="{{route('index')}}">
            Eduplatform
        </a>

        <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    @yield('navbar')

    <div class="navbar-end">
        @guest
            <div class="navbar-item">
                <a href="/login" class="button is-primary">
                    <strong>Zaloguj</strong>
                </a>
            </div>
        @endguest
        @auth
            <a href=# class="navbar-item">
                Witaj {{Auth::user()->fullName}}
            </a>
            <div class="navbar-item">
                <a href="{{route('logout')}}" class="button is-light">
                    Wyloguj
                </a>
            </div>

        @endauth
    </div>
</nav>


<div class="is-flex" style="flex: 1 0 auto">
    @yield('vertical_nav')

    <div class="container">
        @include('flesh_messages')
{{--        @include('flash::message')--}}
        @include('include.app.errors')
        <div class="section">
            @yield('content')
        </div>
    </div>
</div>

<footer class="footer">
    <div class="content has-text-centered">
        <p>
            <strong>Eduplatform</strong> by Krystian Dziewa.
        </p>
        <p>
            Internetowa platforma wspomagania nauczania
        </p>
    </div>
</footer>

<script src="{{ asset('node_modules/tinymce/tinymce.min.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
