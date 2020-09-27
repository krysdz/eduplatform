@extends('teacher.layout')

@section('content')
    <div>
    <h2 class="title is-2">Sekcja nauczyciela</h2>
    <h3 class="title is-3">Zajęcia ({{$today}})</h3>

        @foreach($lessons as $lesson)
            <h3>
                <a href="{{route('teacher.lessons.show', $lesson->id)}}">{{$loop->iteration}}. {{$lesson->group->course->name}} gr.{{$lesson->group->number}} ({{$lesson->group->type->label}}</a>)
            </h3>
        @endforeach

    </div>
@endsection
