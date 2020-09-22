@extends('teacher.layout')

@section('content')
    <h1>{{$group->course->name}} {{$group->number}} {{$group->type->label}}</h1>
    <h2>{{$group->course->faculty->code}}</h2>

    <button><a href="{{route('teacher.groups.lessons.index', $group->id)}}">Lekcje</a></button>

    <h2>Studenci:</h2>
    <ul>
        @foreach($group->students as $student)
            <li>{{$student->user->id}} {{$student->user->fullName}}</li>
        @endforeach
    </ul>



@endsection
