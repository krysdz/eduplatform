@extends('admin.layout')
@section('title', "$term - Eduplatform.pl")

@section('content')
    <div class="content">
        <h1 class="title mt-4">Informacje o semestrze</h1>
        <h2 class="subtitle is-1 pb-5">{{$term}} @if($term->checkIsActive()) <span class="tag is-medium is-primary">Bieżący semestr</span> @endif</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('admin.terms.edit', $term->id)}}">Edytuj</a>
            <form class="is-inline" action="{{route('admin.terms.destroy', $term->id)}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">O semestrze:</p>
        <p>Kod: {{$term->code}}</p>
        <p>Data rozpoczęcia: {{$term->start_date}}</p>
        <p>Data zakończenia zajęć: {{$term->end_classes_date}}</p>
        <p>Data zakończenia: {{$term->end_date}}</p>

        <p class="title is-4">Grupy przypisane do semestru:</p>

        <ul>
            @forelse($term->groups()->get() as $group)
                <li>
                    <a href="{{ route('admin.groups.show', $group) }}">{{ $group }} </a>
                </li>
                @empty
                   <p>Brak grup przypisanych do semestru.</p>
            @endforelse
        </ul>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$term->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$term->updated_at}}</p>

    </div>
@endsection
