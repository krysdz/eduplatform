<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="d-flex flex-column @yield('body_class', 'min-vh-100')">
    @include('include.header')

    <div class="container">
        @include('include.flash_messages')
        @include('include.form_errors')
    </div>

    @yield('pre_content')

    <div class="flex-fill d-flex flex-column flex-lg-row overflow-hidden">
        @yield('left_sidebar')

        <main class="flex-fill d-flex flex-column overflow-hidden">
            @section('fluid_content')
                <div class="container-md my-4">
                    @yield('content')
                </div>
            @show
        </main>
    </div>

    @include('include.footer')

    <script src="{{ asset('modules/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('modules/fontawesome-free/all.js') }}"></script>
</body>
</html>
