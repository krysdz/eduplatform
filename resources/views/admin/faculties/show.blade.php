@extends('admin.layout')
@section('title', "$faculty - Eduplatform.pl")

@section('content')

    <div class="content">
        <h1 class="title mt-4">Informacje o wydziale</h1>
        <h2 class="subtitle is-1 pb-5">{{$faculty}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('admin.faculties.edit', $faculty)}}">Edytuj</a>
            <form class="is-inline" action="{{route('admin.faculties.destroy', $faculty)}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">O wydziale:</p>
        <p>Kod: {{$faculty->code}}</p>
        <p>Opis:</p>
        <p>{!! $faculty->description !!}</p>

        <p class="title is-4">Kursy przypisane do wydziału:</p>

        <ul>
            @forelse($faculty->courses()->get() as $course)
                <li>
                    <a href="{{ route('admin.courses.show', $course) }}">{{ $course }} </a>
                </li>
            @empty
                <p>Brak kursów przypisanych do wydziału.</p>
            @endforelse
        </ul>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$faculty->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$faculty->updated_at}}</p>

    </div>
@endsection
