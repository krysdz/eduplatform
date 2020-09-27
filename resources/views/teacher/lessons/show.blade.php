@extends('teacher.group_layout')

@section('content')
    @include('teacher.lessons.buttons')

    <h2>Data: {{$lesson->date}}</h2>
    <h2>Numer: {{$lesson->number}}</h2>
    <h2>Temat: {{$lesson->title}}</h2>
    <h2>Stworzona {{$lesson->is_active}}</h2>
@endsection
