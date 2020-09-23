@extends('teacher.layout')

@section('content')
    <h2>{{$lesson->group->course->name}} gr.{{$lesson->group->number}} ({{$lesson->group->type->label}})</h2>

    @empty($lesson->title)
        <form action="{{route('teacher.lessons.edit', $lesson->id)}}" method="GET">
            <button type="submit" name="action" value="plan" class="btn btn-success">Zaplanuj lekcję</button>
            <button type="submit" name="'action" value="create" class="btn btn-warning">Stwórz lekcję</button>
        </form>
    @endempty
    @isset($lesson->title)
        <form action="{{route('teacher.lessons.update', $lesson->id)}}" method="POST">
            @method('PUT')
            @csrf
            @if(!$lesson->is_active)
                <button type="submit" name="action" value="publish" class="btn btn-warning">Opublikuj lekcję</button>
            @endif
            <button type="submit" name="action" value="clear" class="btn btn-danger">Wyczyść lekcję</button>
        </form>
    @endisset

    <h2>Data: {{$lesson->date}}</h2>
    <h2>Numer: {{$lesson->number}}</h2>
    <h2>Temat: {{$lesson->title}}</h2>
    <h2>Temat: {{$lesson->description}}</h2>
    <h2>Aktywna? {{$lesson->is_active}}</h2>

@endsection
