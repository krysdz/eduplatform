@extends('teacher.group_layout')

@section('content')
    <h1>Edytuj ogłoszenie</h1>
    <form action="{{route('teacher.announcements.update', $announcement->id)}}" method="POST">
        @method('PUT')
        @csrf
        <label for="title">Tytuł: </label>
        <input type="text" id="title" name="title" value="{{$announcement->title}}">

        <label for="textarea">Opis: </label>
        <textarea id="textarea" name="description">{{$announcement->description}}</textarea>

        <label for="date">Data: </label>
        <input type="date" name="date" id="date" value="{{explode(' ', $announcement->deadline)[0]}}">

        <label for="time">Czas: </label>
        <input type="time" name="time" id="time" value="{{explode(' ', $announcement->deadline)[1]}}">

        <label for="type">Typ: </label>
        <select id="type" name="type">
            @foreach($types as $value => $label)
                <option @if($announcement->$value == $value) selected @endif value="{{$value}}">{{$label}}</option>
            @endforeach
        </select>

        <button type="submit">Dodaj</button>
    </form>
@endsection
