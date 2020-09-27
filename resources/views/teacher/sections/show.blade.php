@extends('teacher.group_layout')

@section('content')
    @include('teacher.sections.buttons')

    <h2>Tytuł: {{$section->title}}</h2>
    <h2>Pozycja: {{$section->position}}</h2>
    <h2>Opis: {!! $section->description !!}</h2>
    <h2>Lekcja: @if($section->lesson_id) {{$section->lesson->number}} @else brak @endif</h2>
    <h2>Aktywna? {{$section->is_active}}</h2>

    <h2>Pliki:</h2>
    <ul>
        @foreach($section->sectionFiles as $sectionFile)
            <li><a href="{{route('teacher.sections.files.show', ['sectionId' => $section->id, 'fileId' => $sectionFile->file->id, 'fileName' => $sectionFile->file->name])}}">{{$sectionFile->file->name}}</a></li>
        @endforeach
    </ul>

@endsection
