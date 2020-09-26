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
                <span class="navbar-text">Witaj {{Auth::user()->fullName}}</span>
                <a class="nav-link" href="{{route('logout')}}">Wyloguj</a>
            @endauth

            @guest
                <a class="nav-link" href="/login">Zaloguj</a>
            @endguest
        </div>
    </nav>

{{--    <div class="container">--}}
    <div>
        @include('flash::message')
        @include('include.app.errors')

        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('node_modules/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector:'#textarea',
            language: 'pl',
            plugins: [
                'advlist autolink link lists charmap hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                'table emoticons paste help'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link | ' +
                'forecolor backcolor emoticons | help',
            menubar: 'edit view insert format tools table help',
            width: 900,
            height: 300
        });
    </script>
</body>
</html>
