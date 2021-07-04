@extends('layout')
@section('title', "$faculty - Eduplatform.pl")

@section('content')

        <h1 class="title mb-1">Informacje o wydziale</h1>
        <h2 class="subtitle">{{ $faculty }}</h2>

        <section class="section">
            <h5 class="subtitle-sm">Akcje</h5>

            <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2" href="{{route('administrator.faculties.edit', $faculty)}}">Edytuj</a>
            <form action="{{ route('administrator.faculties.destroy', $faculty) }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger py-2 w-100" type="submit">Usuń</button>
            </form>
            </div>
        </section>

        <section class="section">
            <h5 class="subtitle-sm">O wydziale</h5>

            <p class="mb-0">
                Kod:
                {{ $faculty->code }}
            </p>
        </section>

        <section class="section">
            <h5 class="subtitle-sm">Opis</h5>
            <div>
                @if($faculty->description)
                    {!! $faculty->description !!}
                @else
                    Brak opisu.
                @endif
            </div>
        </section>

        <section class="section">
            <h5 class="subtitle-sm">Kursy przypisane do wydziału</h5>

            <ul>
                @forelse($faculty->courses()->get() as $course)
                    <li>
                        <a href="{{ route('administrator.courses.show', $course->id) }}">{{ $course }} </a>
                    </li>
                @empty
                    <p>Brak kursów przypisanych do wydziału.</p>
                @endforelse
            </ul>
        </section>

        <section class="section">
            <h5 class="subtitle-sm">Inne informacje</h5>

            <p class="mb-0">Data utworzenia: {{ $faculty->created_at }}</p>
            <p class="mb-0">Data ostatniej aktualizacji: {{ $faculty->updated_at }}</p>
        </section>

@endsection
