@extends('teacher.layout')

@section('content')
    <h1>{{$group->course->name}} {{$group->number}} {{$group->type->label}}</h1>
    <h2>{{$group->course->faculty->code}}</h2>

    <button><a href="{{route('teacher.groups.lessons.index', $group->id)}}">Lekcje</a></button>
    <button><a href="{{route('teacher.groups.sections.index', $group->id)}}">Sekcje</a></button>
    <button><a href="{{route('teacher.groups.announcements.index', $group->id)}}">Ogłoszenia</a></button>
    <button><a href="{{route('teacher.groups.attendances.index', $group->id)}}">Frekwencja</a></button>

    <h2>Studenci:</h2>
    <ul>
        @foreach($group->students as $student)
            <li>User_id {{$student->user->id}} {{$student->user->fullName}}</li>
        @endforeach
    </ul>



@endsection
