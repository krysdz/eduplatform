@extends('teacher.group_layout')

@section('title', "$announcement - Eduplatform.pl")

@section('group_content')
    <div class="content">
        <h1 class="title">Informacje o ogłoszeniu</h1>
        <h2 class="subtitle pb-5">{{$announcement}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('teacher.groups.announcements.edit', [$group, $announcement])}}">Edytuj</a>
            <form class="is-inline" action="{{route('teacher.groups.announcements.destroy', [$group, $announcement])}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">O ogłoszeniu:</p>
        <p>Tytuł: {{$announcement->title}}</p>
        <p>Data: {{$announcement->mark_at}}</p>
        <p>Typ: {{\App\Enums\AnnouncementType::getDescription($announcement->type)}}</p>
        <p>Grupa: {{$group}} </p>

        <p class="title is-4">Treść:</p>
        <div>{!! $announcement->description !!}</div>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$announcement->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$announcement->updated_at}}</p>

    </div>
@endsection
