@extends('teacher.layout')

@section('content')
    <h1>Edytuj sekcję</h1>
    <h2>{{$section->group->course->name}} gr.{{$section->group->number}} ({{$section->group->type->label}})</h2>
    <form action="{{route('teacher.sections.update', $section->id)}}" method="POST">
        @method('PUT')
        @csrf
        <label for="title">Tytuł: </label>
        <input type="text" id="title" name="title" value="{{$section->title}}">

        <label for="position">Pozycja: </label>
        <input type="number" id="position" name="position" value="{{$section->position}}" }}>

        <label for="description">Opis: </label>
        <textarea name="description" id="description" >{{$section->description}}</textarea>

        <button type="submit">Zapisz</button>
        <button type="submit" @if($section->is_active)>Zapisz i ukryj @else name="is_active" value="is_active"> Zapisz i udostępnij @endif</button>
    </form>
@endsection
