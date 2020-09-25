@extends('teacher.layout')

@section('content')
    <button><a href="{{route('teacher.groups.sections.create', $group->id)}}">Dodaj sekcję</a></button>
    <h2>Sekcje {{$group->course->name}} gr.{{$group->number}} ({{$group->type->label}})</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Pozycja</th>
            <th>Tytuł</th>
            <th>Ma lekcję</th>
            <th>Obublikowana</th>
        </tr>
        @foreach($sections as $section)
            <tr>
                <td><a href="{{route('teacher.sections.show', $section->id)}}">{{$section->id}}</a></td>
                <td>{{$section->position}}</td>
                <td>{{$section->title}}</td>
                <td>@if($section->lesson_id)tak @else nie @endif</td>
                <td>@if($section->is_active)tak @else nie @endif</td>
                <td>@include('teacher.sections.buttons')</td>
            </tr>
        @endforeach
    </table>
@endsection
