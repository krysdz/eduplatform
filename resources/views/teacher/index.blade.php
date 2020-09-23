@extends('teacher.layout')

@section('content')
    <h1>Sekcja nauczyciela</h1>
    <h2>Zajęcia ({{$today}})</h2>

        @foreach($lessons as $lesson)
            <h3>
                <a href="{{route('teacher.lessons.show', $lesson->id)}}">{{$loop->iteration}}. {{$lesson->group->course->name}} gr.{{$lesson->group->number}} ({{$lesson->group->type->label}}</a>)
            </h3>
        @endforeach

    <div>
@endsection
