@extends('teacher.layout')

@section('content')
    <h2>{{$section->group->course->name}} gr.{{$section->group->number}} ({{$section->group->type->label}})</h2>

    @include('teacher.sections.buttons')

    <h2>Tytuł: {{$section->title}}</h2>
    <h2>Pozycja: {{$section->position}}</h2>
    <h2>Opis: {!! $section->description !!}</h2>
    <h2>Lekcja: @if($section->lesson_id) {{$section->lesson->number}} @else brak @endif</h2>
    <h2>Aktywna? {{$section->is_active}}</h2>

    <h2>Pliki</h2>
    <ul>
        @foreach($files as $file)
            <li><a href="{{route('teacher.sections.files.show', ['sectionId' => $section->id, 'fileName' => $file])}}">{{$file}}</a></li>
        @endforeach
    </ul>

@endsection
