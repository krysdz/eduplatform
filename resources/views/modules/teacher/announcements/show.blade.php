@extends('modules.teacher.group-layout')

@section('title', "$announcement - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Informacje o ogłoszeniu</h1>
    <h2 class="subtitle">{{$announcement}}</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2"
               href="{{route('teacher.groups.announcements.edit', [$group, $announcement])}}">Edytuj</a>
            <form action="{{route('teacher.groups.announcements.destroy', [$group, $announcement])}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger py-2 w-100" type="submit">Usuń</button>
            </form>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">O ogłoszeniu</h5>

        <p class="mb-0">
            Tytuł: {{$announcement->title}}
        </p>
        <p class="mb-0">
            Data: {{$announcement->mark_at}}
        </p>
        <p class="mb-0">
            Typ: {{ $announcement->type->description }}
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Treść</h5>

        <div>{!! $announcement->description !!}</div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $announcement->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $announcement->updated_at }}</p>
    </section>


@endsection
