@extends('teacher.layout')

@section('content')
    <h2>{{$announcement->group->course->name}} gr.{{$announcement->group->number}} ({{$announcement->group->type->label}})</h2>

    <h3>Id: {{$announcement->id}}</h3>
    <h3>Tytuł: {{$announcement->title}}</h3>
    <h3>Opis</h3>
    <div>{!! $announcement->description !!}</div>
    <h3>Deadline: {{$announcement->deadline}}</h3>
    <h3>Typ: {{$announcement->type->label}}</h3>

@endsection
