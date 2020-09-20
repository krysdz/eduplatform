@extends('admin.index')

@section('content')
    <h1>{{$group->course->name}} {{$group->number}} {{$group->type->label}}</h1>
    <h2>{{$group->course->faculty->code}}</h2>
    <h2>{{$group->teacher->user->fullName}}</h2>

    <h2>Studenci:</h2>
    <ul>
        @foreach($group->students as $student)
            <li>{{$student->user->id}} {{$student->user->fullName}}</li>
        @endforeach
    </ul>

@endsection
