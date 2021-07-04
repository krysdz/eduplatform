@extends('layout')
@section('title', "$group - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">Informacje o grupie</h1>
    <h2 class="subtitle">{{ $group }}</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2" href="{{route('administrator.groups.edit', $group)}}">Edytuj</a>
            <a class="btn btn-primary py-2" href="{{route('administrator.groups.group_schedules.index', $group)}}">Harmonogramy</a>
            <a class="btn btn-primary py-2" href="{{route('administrator.groups.scheduled_lessons.index', $group)}}">Planowane
                lekcje</a>
            <form action="{{route('administrator.groups.destroy', $group)}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger py-2 w-100" type="submit">Usuń</button>
            </form>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">O grupie</h5>

        <p class="mb-0">
            Kurs:
            <a href="{{route('administrator.courses.show', $group->course)}}">{{$group->course}}</a>
        </p>
        <p class="mb-0">
            Numer:
            {{$group->number}}
        </p>
        <p class="mb-0">
            Typ:
            {{\App\Enums\GroupType::getDescription($group->type)}}
        </p>
        <p class="mb-0">
            Semestr:
            <a href="{{route('administrator.terms.show', $group->term)}}">{{$group->term}}</a>
        </p>
        <p class="mb-0">
            Wydział:
            <a href="{{route('administrator.faculties.show', $group->course->faculty)}}">{{$group->course->faculty}}</a>
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Nauczyciele w grupie ({{$group->teachers()->count()}})</h5>

        <ul>
            @forelse($group->teachers()->sortBy(['last_name'], ['first_name']) as $teacher)
                <li>
                    <a href="{{ route('administrator.users.show', $teacher) }}">{{ $teacher }} </a>
                </li>
            @empty
                <p>Brak nauczycieli przypisanych do grupy.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Studenci w grupie ({{$group->students()->count()}})</h5>

        <ul>
            @forelse($group->students()->sortBy(['last_name'], ['first_name']) as $student)
                <li>
                    <a href="{{ route('administrator.users.show', $student) }}">{{ $student }} </a>
                </li>
            @empty
                <p>Brak studentów przypisanych do grupy.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $group->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $group->updated_at }}</p>
    </section>
@endsection
