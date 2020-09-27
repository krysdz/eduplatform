@extends('teacher.group_layout')

@section('content')
    <h1>Dodaj sekcję</h1>
    <form action="{{route('teacher.groups.sections.store', $group->id)}}" enctype="multipart/form-data" method="POST">
        @csrf
        <label for="title">Tytuł: </label>
        <input type="text" id="title" name="title">

        <label for="position">Pozycja: </label>
        <input type="number" id="position" name="position">

        <label for="textarea">Opis: </label>
        <textarea name="description" id="textarea"></textarea>

        <label for="section_files">Pliki: </label>
        <input type="file" id="section_files" name="section_files[]" multiple>

        <button type="submit" name="is_active" value="is_not_active">Dodaj</button>
        <button type="submit" name="is_active" value="is_active">Dodaj i udostępnij</button>
    </form>
@endsection
