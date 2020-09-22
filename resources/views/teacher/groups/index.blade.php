@extends('teacher.layout')

@section('content')
    @if(!$archived)
        <button><a href="{{route('teacher.groups.index')}}?archived=true">Archiwalne grupy</a></button>
    @else
        <button><a href="{{route('teacher.groups.index')}}">Aktualne grupy</a></button>
    @endif
    <h2>Grupy:</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Przedmiot</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Semestr</th>
            <th>Dzień tygodnia</th>
            <th>Wydział</th>
            <th>Ilość uczestników</th>
        </tr>
        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('teacher.groups.show', $group->id)}}">{{$group->id}}</a></td>
                <td>{{$group->course->name}}</td>
                <td>{{$group->number}}</td>
                <td>{{$group->type->label}}</td>
                <td>{{$group->term->code}}</td>
                <td>{{$group->day_of_classes->label}}</td>
                <td>{{$group->course->faculty->code}}</td>
                <td>{{$group->students->count()}}</td>
            </tr>
        @endforeach
    </table>
@endsection
