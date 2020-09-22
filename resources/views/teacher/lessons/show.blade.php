@extends('teacher.layout')

@section('content')
    <h2>Lekcja {{$lesson->group->course->name}} gr.{{$lesson->group->number}} ({{$lesson->group->type->label}})</h2>

    <h2>{{$lesson->date}}</h2>
    <h2>{{$lesson->title}}</h2>
    <h2>{{$lesson->is_active}}</h2>

@endsection
