@extends('teacher.layout')

@section('content')
    <button><a href="{{route('teacher.groups.announcements.create', $group->id)}}">Dodaj ogłoszenie</a></button>
    <h2>Ogłoszenia {{$group->course->name}} gr.{{$group->number}} ({{$group->type->label}})</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Tytuł</th>
            <th>Opis</th>
            <th>Data</th>
            <th>Type</th>
        </tr>
        @foreach($announcements as $announcement)
            <tr>
                <td><a href="{{route('teacher.announcements.show', $announcement->id)}}">{{$announcement->id}}</a></td>
                <td>{{$announcement->title}}</td>
                <td>{!! $announcement->description !!}</td>
                <td>{{$announcement->deadline}}</td>
                <td>{{$announcement->type->label}}</td>
                <td>
                    <button><a href="{{route('teacher.announcements.edit', $announcement->id)}}">Edytuj</a></button>
                    <form action="{{route('teacher.announcements.destroy', $announcement->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
