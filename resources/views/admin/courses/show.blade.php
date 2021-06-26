@extends('admin.layout')
@section('title', "$course - Eduplatform.pl")


@section('content')

    <div class="content">
        <h1 class="title mt-4">Informacje o kursie</h1>
        <h2 class="subtitle is-1 pb-5">{{$course}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('admin.courses.edit', $course)}}">Edytuj</a>
            <form class="is-inline" action="{{route('admin.courses.destroy', $course)}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">O kursie:</p>
        <p>Kod: {{$course->code}}</p>
        <p>Koordynator: <a href="{{route('admin.users.show', $course->coordinator)}}">{{$course->coordinator}}</a></p>
        <p>Wydział: <a href="{{route('admin.faculties.show', $course->faculty)}}">{{$course->faculty}}</a></p>
        <p>Opis:</p>
        <p>{!! $course->description !!}</p>

        <p class="title is-4">Grupy przypisane do kursu:</p>

        <ul>
            @forelse($course->groups()->get() as $group)
                <li>
                    <a href="{{ route('admin.groups.show', $group) }}">{{ $group }} </a>
                    <span class="tag is-dark">{{ $group->term }}</span>
                </li>
            @empty
                <p>Brak grup przypisanych do kursu.</p>
            @endforelse
        </ul>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$course->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$course->updated_at}}</p>

    </div>

@endsection
