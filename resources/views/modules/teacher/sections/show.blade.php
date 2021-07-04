@extends('modules.teacher.group_layout')

@section('title', "$section - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Informacje o sekcji</h1>
    <h2 class="subtitle">{{ $section }}</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2"
               href="{{route('teacher.groups.sections.edit', [$group, $section])}}">Edytuj</a>
            <form action="{{route('teacher.groups.sections.destroy', [$group, $section])}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger py-2 w-100" type="submit">Usuń</button>
            </form>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">O sekcji</h5>

        <p class="mb-0">
            Pozycja: {{$section->order}}
        </p>
        <p class="mb-0">
            Temat: {{$section->name}}
        </p>
        <p class="mb-0">
            Opublikowana: @if($section->published_at){{ $section->published_at }} @else nie @endif
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Opis</h5>
        <div>{!! $section->description !!}</div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Pliki</h5>
    </section>
    @forelse($section->files as $sectionFile)
        <div class="d-flex">
            <a href="{{route('file.show', [$sectionFile, $sectionFile->filename])}}">{{$sectionFile}}</a>
            <form
                action="{{route('file.destroy', $sectionFile)}}"
                method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger" type="submit">Usuń</button>
            </form>
        </div>
    @empty
        <p>Brak plików.</p>
    @endforelse


    <section class="section">
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $section->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $section->updated_at }}</p>
    </section>
@endsection




