@extends('teacher.group_layout')

@section('title', "$lesson - Eduplatform.pl")

@section('group_content')
    <div class="content">
        <h1 class="title">Informacje o lekcji</h1>
        <h2 class="subtitle pb-5">{{$lesson->scheduledLesson->date}} {{$lesson->scheduledLesson->start_time}} - {{$lesson->scheduledLesson->end_time}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('teacher.groups.lessons.edit', [$group, $lesson])}}">Edytuj</a>
{{--            <form class="is-inline" action="{{route('admin.terms.destroy', $term->id)}}" method="POST">--}}
{{--                @method('DELETE')--}}
{{--                @csrf--}}
{{--                <button class="button is-danger" type="submit">Usuń</button>--}}
{{--            </form>--}}
        </div>

        <p class="title is-4">O lekcji:</p>
        <p>Numer: {{$lesson->number}}</p>
        <p>Temat: {{$lesson->name}}</p>
        <p>Grupa: {{$lesson->scheduledLesson->group}} </p>
        <p>Nauczyciel: {{$lesson->scheduledLesson->teacher}} </p>

        <p class="title is-4">Czas i miejsce:</p>
        <p>Data: {{$lesson->scheduledLesson->date}}</p>
        <p>Godziny trwania: {{$lesson->scheduledLesson->start_time}} - {{$lesson->scheduledLesson->end_time}}</p>
        <p>Sala: {{$lesson->scheduledLesson->room_name}}</p>
        <p>Wydział: {{$lesson->scheduledLesson->group->course->faculty}}</p>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$lesson->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$lesson->updated_at}}</p>

    </div>
@endsection
