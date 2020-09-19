@extends('app')

@section('menu')
    <li class="navbar-nav mr-auto">
        <a class="nav-link" href="{{route('admin.users.index')}}">Użytkownicy</a>
    </li>
    <li class="navbar-nav mr-auto">
        <a class="nav-link" href="{{route('admin.terms.index')}}">Semestry</a>
    </li>
    <li class="navbar-nav mr-auto">
        <a class="nav-link" href="{{route('admin.faculties.index')}}">Wydziały</a>
    </li>
    <li class="navbar-nav mr-auto">
        <a class="nav-link" href="{{route('admin.courses.index')}}">Kursy</a>
    </li>
@endsection
@section('content')
<h1>Sekcja administratora</h1>
<div>

</div>
<div>

@endsection
