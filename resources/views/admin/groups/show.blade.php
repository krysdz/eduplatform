@extends('admin.layout')
@section('title', "$group - Eduplatform.pl")

@section('content')

    <div class="content">
        <h1 class="title mt-4">Informacje o grupie</h1>
        <h2 class="subtitle is-1 pb-5">{{$group}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('admin.groups.edit', $group)}}">Edytuj</a>
            <a class="button is-warning is-normal" href="{{route('admin.groups.group_schedules.index', $group)}}">Harmonogramy</a>
            <a class="button is-warning is-normal" href="{{route('admin.groups.scheduled_lessons.index', $group)}}">Planowane lekcje</a>
            <form class="is-inline" action="{{route('admin.groups.destroy', $group)}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">O kursie:</p>
        <p>Kurs: <a href="{{route('admin.courses.show', $group->course)}}">{{$group->course}}</a></p>
        <p>Numer: {{$group->number}}</p>
        <p>Typ: {{\App\Enums\GroupType::getDescription($group->type)}}</p>
        <p>Semestr: <a href="{{route('admin.terms.show', $group->term)}}">{{$group->term}}</a></p>
        <p>Wydział: <a href="{{route('admin.faculties.show', $group->course->faculty)}}">{{$group->course->faculty}}</a></p>

        <p class="title is-4">Nauczyciele w grupie ({{$group->teachers()->count()}}):</p>

        <ul>
            @forelse($group->teachers() as $teacher)
                <li>
                    <a href="{{ route('admin.users.show', $teacher) }}">{{ $teacher }} </a>
                </li>
            @empty
                <p>Brak nauczycieli przypisanych do grupy.</p>
            @endforelse
        </ul>

        <p class="title is-4">Studenci w grupie ({{$group->students()->count()}}):</p>

        <ul>
            @forelse($group->students() as $student)
                <li>
                    <a href="{{ route('admin.users.show', $student) }}">{{ $student }} </a>
                </li>
            @empty
                <p>Brak studentów przypisanych do grupy.</p>
            @endforelse
        </ul>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$group->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$group->updated_at}}</p>

    </div>
@endsection
