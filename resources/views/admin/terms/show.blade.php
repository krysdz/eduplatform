@extends('admin.index')

@section('content')
    <h1>{{$term->name}}</h1>
    <h2>{{$term->start_date}} - {{$term->end_date}}</h2>
    @if($term->is_active)
        <h2>Aktualny</h2>
    @endif
    <h2>Grupy:</h2>
    <table>
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Nauczyciel prowadzący</th>
            <th>Ilość uczestników</th>
        </tr>
        @foreach($term->groups as $group)
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

@endsection
