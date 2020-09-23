@extends('teacher.layout')

@section('content')
    <h1>@if($action === 'plan') Zaplanuj @elseif($action === 'create') Stwórz @elseif($action === 'edit') Edytuj @endif lekcję</h1>
    <h2>{{$lesson->group->course->name}} gr.{{$lesson->group->number}} ({{$lesson->group->type->label}})</h2>
    <form action="{{route('teacher.lessons.update', $lesson->id)}}" method="POST">
        @method('PUT')
        @csrf
        <label for="start_date">Data: </label>
        <input type="date" id="date" name="date" value="{{$lesson->date}}">

        <label for="title">Temat: </label>
        <input type="text" id="title" name="title" value="{{$lesson->title}}">

        <label for="number">Numer: </label>
        <input type="text" id="number" name="number" value="{{$lesson->number}}">

        @if($action === 'create' || ($action === 'edit' && $lesson->is_active) )
            <input type="hidden" id="is_active" name="is_active" value="is_active">
        @endif

        <button type="submit">Zapisz</button>
    </form>
@endsection
