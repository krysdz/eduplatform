@extends('app')

@section('navbar')

    <div id="mainNavbar" class="navbar-menu">
        <div class="navbar-start">
            <a href="{{route('teacher.groups.index')}}" class="navbar-item">
                Grupy
            </a>
            <a href="{{route('teacher.timetable.index')}}" class="navbar-item">
                Plan zajęć
            </a>
        </div>
    </div>
@endsection
@section('content')

@endsection
