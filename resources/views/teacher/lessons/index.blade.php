@extends('teacher.layout')

@section('content')
    <h2>Lekcje {{$lessons->first()->group->course->name}} gr.{{$lessons->first()->group->number}} ({{$lessons->first()->group->type->label}})</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Temat</th>
            <th>Stworzona</th>
        </tr>
        @foreach($lessons as $lesson)
            <tr>
                <td><a href="{{route('teacher.lessons.show', $lesson->id)}}">{{$lesson->id}}</a></td>
                <td>{{$lesson->date}}</td>
                <td>{{$lesson->title}}</td>
                <td>@if($lesson->is_active)tak @else nie @endif</td>
                <td>@include('teacher.lessons.buttons')</td>
            </tr>
        @endforeach
    </table>
@endsection
