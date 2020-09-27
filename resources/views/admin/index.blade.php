@extends('app')

@section('navbar')
    <div id="mainNavbar" class="navbar-menu">
        <div class="navbar-start">
            <a href="{{route('admin.users.index')}}" class="navbar-item">
                Użytkownicy
            </a>
        </div>
        <div class="navbar-start">
            <a href="{{route('admin.terms.index')}}" class="navbar-item">
                Semestry
            </a>
        </div>
        <div class="navbar-start">
            <a href="{{route('admin.faculties.index')}}" class="navbar-item">
                Wydziały
            </a>
        </div>
        <div class="navbar-start">
            <a href="{{route('admin.courses.index')}}" class="navbar-item">
                Kursy
            </a>
        </div>
        <div class="navbar-start">
            <a href="{{route('admin.groups.index')}}" class="navbar-item">
                Grupy
            </a>
        </div>
    </div>
@endsection
@section('content')
<h1>Sekcja administratora</h1>
@endsection
