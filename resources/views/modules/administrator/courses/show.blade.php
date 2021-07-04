@extends('layout')
@section('title', "$course - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Informacje o kursie</h1>
    <h2 class="subtitle">{{ $course }}</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2" href="{{ route('administrator.courses.edit', $course) }}">Edytuj</a>

            <form action="{{ route('administrator.courses.destroy', $course) }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger py-2 w-100" type="submit">Usuń</button>
            </form>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">O kursie</h5>

        <p class="mb-0">
            Kod:
            {{ $course->code }}
        </p>
        <p class="mb-0">
            Koordynator:
            <a href="{{ route('administrator.users.show', $course->coordinator_id) }}">{{ $course->coordinator }}</a>
        </p>
        <p class="mb-0">
            Wydział:
            <a href="{{ route('administrator.faculties.show', $course->faculty_id) }}">{{ $course->faculty }}</a>
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Opis</h5>
        <div>
            @if($course->description)
                {!! $course->description !!}
            @else
                Brak opisu.
            @endif
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Grupy przypisane do kursu</h5>

        <ul>
            @forelse ($course->groups as $group)
                <li>
                    <a href="{{ route('administrator.groups.show', $group->id) }}">{{ $group }}</a>
                    <span class="badge bg-dark">{{ $group->term }}</span>
                </li>
            @empty
                <p>Brak grup przypisanych do kursu.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $course->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $course->updated_at }}</p>
    </section>
@endsection
