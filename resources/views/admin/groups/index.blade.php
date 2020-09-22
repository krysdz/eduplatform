@extends('admin.index')

@section('content')
    <button><a href="{{route('admin.groups.create')}}">Dodaj grupę</a></button>
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
            <th>Nauczyciel prowadzący</th>
            <th>Ilość uczestników</th>
        </tr>
        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('admin.groups.show', $group->id)}}">{{$group->id}}</a></td>
                <td>{{$group->course->name}}</td>
                <td>{{$group->number}}</td>
                <td>{{$group->type->label}}</td>
                <td>{{$group->term->code}}</td>
                <td>{{$group->day_of_classes->label}}</td>
                <td>{{$group->course->faculty->code}}</td>
                <td>{{$group->teacher->user->fullName}}</td>
                <td>{{$group->students->count()}}</td>
                <td>
                    <button><a href="{{route('admin.groups.edit', $group->id)}}">Edytuj</a></button>
                </td>
                <td>
                    <form action="{{route('admin.groups.destroy', $group->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
