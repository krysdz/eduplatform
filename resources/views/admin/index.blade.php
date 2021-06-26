@extends('admin.layout')

@section('title', "Moduł administratora - Eduplatform.pl")

@section('content')
    <div class="content">
        <h1 class="title mt-4">Moduł administratora</h1>

        <p class="title is-4">Szybkie akcje:</p>

        <div class="buttons">
            <a class="button is-info is-normal" href="{{route('admin.users.create')}}">Dodaj użytkownika</a>
            <a class="button is-info is-normal" href="{{route('admin.terms.create')}}">Dodaj semestr</a>
            <a class="button is-info is-normal" href="{{route('admin.faculties.create')}}">Dodaj wydział</a>
            <a class="button is-info is-normal" href="{{route('admin.courses.create')}}">Dodaj kurs</a>
            <a class="button is-info is-normal" href="{{route('admin.groups.create')}}">Dodaj grupę</a>
        </div>

        <p class="title is-4">Ostatnio zaktualizowani użytkownicy:</p>
        <ul>
            @foreach($lastUpdatedUsers as $lastUpdatedUser)
                <li><a href="{{route('admin.users.show', $lastUpdatedUser)}}">{{$lastUpdatedUser}} - {{$lastUpdatedUser->updated_at}}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
