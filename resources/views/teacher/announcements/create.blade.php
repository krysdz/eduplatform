@extends('teacher.group_layout')

@section('content')
    <h1>Dodaj ogłoszenie</h1>
    <form action="{{route('teacher.groups.announcements.store', $group->id)}}" method="POST">
        @csrf
        <label for="title">Tytuł: </label>
        <input type="text" id="title" name="title">

        <label for="textarea">Opis: </label>
        <textarea id="textarea" name="description"></textarea>

        <label for="date">Data: </label>
        <input type="date" name="date" id="date">

        <label for="time">Czas: </label>
        <input type="time" name="time" id="time">

        <label for="type">Typ: </label>
        <select id="type" name="type">
            <option hidden selected></option>
            @foreach($types as $value => $label)
                <option value="{{$value}}">{{$label}}</option>
            @endforeach
        </select>

        <button type="submit">Dodaj</button>
    </form>
@endsection
