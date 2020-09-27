@extends('teacher.group_layout')

@section('content')
    <h3>Id: {{$announcement->id}}</h3>
    <h3>Tytuł: {{$announcement->title}}</h3>
    <h3>Opis</h3>
    <div>{!! $announcement->description !!}</div>
    <h3>Deadline: {{$announcement->deadline}}</h3>
    <h3>Typ: {{$announcement->type->label}}</h3>

@endsection
