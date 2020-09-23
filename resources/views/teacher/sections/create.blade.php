@extends('teacher.layout')

@section('content')
    <h1>Dodaj sekcję</h1>
    <h2>{{$group->course->name}} gr.{{$group->number}} ({{$group->type->label}})</h2>
    <form action="{{route('teacher.groups.sections.store', $group->id)}}" method="POST">
        @csrf
        <label for="title">Tytuł: </label>
        <input type="text" id="title" name="title">

        <label for="position">Pozycja: </label>
        <input type="number" id="position" name="position">

        <label for="description">Opis: </label>
        <textarea name="description" id="description"></textarea>

        <button type="submit" name="is_active">Dodaj</button>
        <button type="submit" name="is_active" value="is_active">Dodaj i udostępnij</button>
    </form>
@endsection
