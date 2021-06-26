@extends('teacher.layout')

@section('title', 'Grupy - Eduplatform.pl')

@section('content')
    <div class="is-flex mt-4 mb-5">
        <h1 class="title">Moje grupy</h1>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <th>Id</th>
            <th>Kurs</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Semestr</th>
            <th>Wydział</th>
            <th>Ilość uczestników</th>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('teacher.groups.show', $group)}}">{{$group->id}}</a></td>
                <td>{{$group->course}}</td>
                <td>{{$group->number}}</td>
                <td>{{\App\Enums\GroupType::getDescription($group->type)}}</td>
                <td>{{$group->term->code}}</td>
                <td>{{$group->course->faculty->code}}</td>
                <td>{{$group->students()->count()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
