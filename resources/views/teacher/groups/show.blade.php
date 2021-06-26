@extends('teacher.group_layout')

@section('group_content')

    <h2>Studenci:</h2>
    <ul>
        @foreach($group->students() as $student)
            <li>User_id {{$student}} {{$student}}</li>
        @endforeach
    </ul>

@endsection
