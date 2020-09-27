@extends('teacher.group_layout')

@section('content')

    <h2>Studenci:</h2>
    <ul>
        @foreach($group->students as $student)
            <li>User_id {{$student->user->id}} {{$student->user->fullName}}</li>
        @endforeach
    </ul>

@endsection
