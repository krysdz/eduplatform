@extends('admin.index')

@section('content')
<h1>{{$user->first_name}} {{$user->last_name}}</h1>
<h2>{{$user->type}}</h2>
<p>{{$user->email}}</p>
<p>{{$user->phone}}</p>
<p>{{$user->created_at}}</p>
<p>{{$user->updated_at}}</p>
@if($user->type == 'student')
    <p>{{$user->student->code}}</p>

    <h2>Grupy:</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Nauczyciel prowadzący</th>
            <th>Ilość uczestników</th>
        </tr>
        @foreach($user->student->groups as $group)
            <tr>
                <td>{{$group->id}}</td>
                <td>{{$group->course->name}}</td>
                <td>{{$group->number}}</td>
                <td>{{$group->type->label}}</td>
                <td>{{$group->teacher->user->fullName}}</td>
                <td>{{$group->students->count()}}</td>
            </tr>
        @endforeach
    </table>
@elseif($user->type == 'teacher')
    <p>{{$user->teacher->degree}}</p>
    <p>{{$user->teacher->website}}</p>

    <h2>Grupy:</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Nauczyciel prowadzący</th>
            <th>Ilość uczestników</th>
        </tr>
        @foreach($user->teacher->groups as $group)
            <tr>
                <td>{{$group->id}}</td>
                <td>{{$group->course->name}}</td>
                <td>{{$group->number}}</td>
                <td>{{$group->type->label}}</td>
                <td>{{$group->teacher->user->fullName}}</td>
                <td>{{$group->students->count()}}</td>
            </tr>
        @endforeach
    </table>
@endif

@endsection
