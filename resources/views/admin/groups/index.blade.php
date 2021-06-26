@extends('admin.layout')

@section('title', 'Grupy - Eduplatform.pl')

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Grupy</h1>
        <a class="button is-normal ml-5" href="{{route('admin.groups.create')}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj grupę</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <th>Id</th>
            <th>Kurs</th>
            <th>Nr grupy</th>
            <th>Typ</th>
            <th>Semestr</th>
            <th>Wydział</th>
            <th>Liczba nauczycieli</th>
            <th>Liczba studentów</th>
        </thead>
        <tbody>
        @foreach($groups as $group)
            <tr>
                <td><a href="{{route('admin.groups.show', $group->id)}}">{{$group->id}}</a></td>
                <td>{{$group->course}}</td>
                <td>{{$group->number}}</td>
                <td>{{\App\Enums\GroupType::getDescription($group->type)}}</td>
                <td>{{$group->term->code}}</td>
                <td>{{$group->course->faculty->code}}</td>
                <td>{{$group->teachers()->count()}}</td>
                <td>{{$group->students()->count()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
