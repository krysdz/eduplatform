@extends('admin.index')

@section('content')
    <h1>{{$course->name}} ({{$course->code}})</h1>
    <h2>{{$course->faculty->name}}</h2>
    <h2>Grupy:</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Nauczyciel prowadzący</th>
            <th>Ilość uczestników</th>
        </tr>
        @foreach($course->groups as $group)
            <tr>
                <td>{{$group->id}}</td>
                <td>{{$group->number}}</td>
                <td>{{$group->type->label}}</td>
                <td>{{$group->teacher->user->fullName}}</td>
                <td>{{$group->students->count()}}</td>
            </tr>
        @endforeach
    </table>
@endsection
