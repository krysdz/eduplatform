<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <a class="navbar-brand" href="{{route('index')}}">Eduplatform</a>
            @yield('menu')
        </ul>

        @auth
            <span class="navbar-text">Witaj {{Auth::user()->first_name}}</span>
            <a class="nav-link" href="{{route('logout')}}">Wyloguj</a>
        @endauth

        @guest
            <a class="nav-link" href="/login">Zaloguj</a>
        @endguest
    </div>
    </div>
</nav>
<div class="container">
    @include('flash::message')
    @yield('content')

</div>
</body>
</html>
