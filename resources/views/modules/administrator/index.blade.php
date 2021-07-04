@extends('layout')

@section('title', "Moduł administratora - Eduplatform.pl")

@section('content')
    <h1 class="title">Moduł administratora</h1>

    <section class="section">
        <h5 class="subtitle-sm">Szybkie akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2" href="{{ route('administrator.users.create') }}">Dodaj użytkownika</a>
            <a class="btn btn-primary py-2" href="{{ route('administrator.terms.create') }}">Dodaj semestr</a>
            <a class="btn btn-primary py-2" href="{{ route('administrator.faculties.create') }}">Dodaj wydział</a>
            <a class="btn btn-primary py-2" href="{{ route('administrator.courses.create') }}">Dodaj kurs</a>
            <a class="btn btn-primary py-2" href="{{ route('administrator.groups.create') }}">Dodaj grupę</a>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Ostatnio dodani użytkownicy</h5>

        <ul>
            @forelse ($lastCreatedUsers as $lastCreatedUser)
                <li>
                    <a href="{{ route('administrator.users.show', $lastCreatedUser) }}">
                        {{ $lastCreatedUser }} - {{ $lastCreatedUser->created_at }}
                    </a>
                </li>
            @empty
                <li class="list-unstyled">Nie znaleziono użytkowników.</li>
            @endforelse
        </ul>
    </section>
@endsection
