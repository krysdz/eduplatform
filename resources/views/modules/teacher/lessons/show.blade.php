@extends('modules.teacher.group_layout')

@section('title', "$lesson - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Informacje o lekcji</h1>
    <h2 class="subtitle">{{$lesson->scheduledLesson->date}} {{$lesson->scheduledLesson->start_time}}
        - {{$lesson->scheduledLesson->end_time}}</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2"
               href="{{route('teacher.groups.lessons.edit', [$group, $lesson])}}">Edytuj</a>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">O lekcji</h5>

        <p class="mb-0">
            Numer: {{$lesson->number}}
        </p>
        <p class="mb-0">
            Temat: {{$lesson->name}}
        </p>
        <p class="mb-0">
            Grupa: {{$lesson->scheduledLesson->group}}
        </p>
        <p class="mb-0">
            Nauczyciel: {{$lesson->scheduledLesson->teacher}}
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Czas i miejsce</h5>

        <p class="mb-0">
            Data: {{$lesson->scheduledLesson->date}}
        </p>
        <p class="mb-0">
            Godziny trwania: {{$lesson->scheduledLesson->start_time}} - {{$lesson->scheduledLesson->end_time}}
        </p>
        <p class="mb-0">
            Sala: {{$lesson->scheduledLesson->room_name}}
        </p>
        <p class="mb-0">
            Wydział: {{$lesson->scheduledLesson->group->course->faculty}}
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $lesson->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $lesson->updated_at }}</p>
    </section>
@endsection
