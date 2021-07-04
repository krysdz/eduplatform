@extends('layout')
@section('title', "$term - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">Informacje o semestrze</h1>
    <h2 class="subtitle">{{ $term }} @if($term->checkIsActive()) <span class="badge bg-primary">Bieżący semestr</span> @endif</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2" href="{{ route('administrator.terms.edit', $term) }}">Edytuj</a>

            <form action="{{ route('administrator.terms.destroy', $term) }}" method="POST">
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
            {{ $term->code }}
        </p>
        <p class="mb-0">
            Data rozpoczęcia:
            {{ $term->start_date }}
        </p>
        <p class="mb-0">
            Data zakończenia zajęć:
            {{ $term->end_classes_date }}
        </p>
        <p class=mb-0>
            Data zakończenia:
            {{ $term->end_date }}
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Grupy przypisane do semestru</h5>

        <ul>
            @forelse($term->groups()->get() as $group)
                <li>
                    <a href="{{ route('administrator.groups.show', $group) }}">{{ $group }} </a>
                </li>
            @empty
                <p>Brak grup przypisanych do semestru.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $term->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $term->updated_at }}</p>
    </section>


@endsection
