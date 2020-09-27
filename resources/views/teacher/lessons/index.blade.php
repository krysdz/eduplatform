@extends('teacher.group_layout')

@section('content')
    <h3 class="title is-3">Lekcje</h3>
    <table class="table is-striped is-fullwidth">
        <thead>
        <tr>
            <th></th>
            <th>Data</th>
            <th>Temat</th>
            <th>Stworzona</th>
            <th>Akcje</th>
        </tr>
        </thead>
        <tbody>
        @foreach($lessons as $lesson)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td><a href="{{route('teacher.lessons.show', $lesson->id)}}">{{$lesson->date}}</a></td>
                <td>{{$lesson->title}}</td>
                <td>@if($lesson->is_active)tak @else nie @endif</td>
                <td>@include('teacher.lessons.buttons')</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
