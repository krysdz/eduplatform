@extends('teacher.group_layout')

@section('title', "$section - Eduplatform.pl")

@section('group_content')
    <div class="content">
        <h1 class="title">Informacje o sekcji</h1>
        <h2 class="subtitle pb-5">{{$section->name}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('teacher.groups.sections.edit', [$group, $section])}}">Edytuj</a>
            <form class="is-inline" action="{{route('teacher.groups.sections.destroy', [$group, $section])}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">O sekcji:</p>
        <p>Pozycja: {{$section->order}}</p>
        <p>Temat: {{$section->name}}</p>
        <p>Lekcja: @if($section->lesson_id){{$section->lesson->scheduledLesson->date}} @else brak @endif</p>
        <p>Opublikowana: @if($section->published_at)tak @else nie @endif</p>
        <p>Grupa: {{$group}} </p>

        <p class="title is-4">Opis:</p>
        <div>{!! $section->description !!}</div>

        <p class="title is-4">Pliki:</p>
        @forelse($section->sectionFiles as $sectionFile)
            <a href="{{route('teacher.groups.sections.files.show', [$group, $section, $sectionFile->file->id, $sectionFile->file->filename])}}">{{$sectionFile->file->filename}}</a>
        @empty
            <p>Brak plików w sekcji.</p>
        @endforelse

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$section->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$section->updated_at}}</p>

    </div>
@endsection
