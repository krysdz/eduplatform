@extends('teacher.group_layout')

@section('content')
    <h1>Edytuj sekcję</h1>
    <form action="{{route('teacher.sections.update', $section->id)}}" enctype="multipart/form-data" method="POST">
        @method('PUT')
        @csrf
        <label for="title">Tytuł: </label>
        <input type="text" id="title" name="title" value="{{$section->title}}">

        <label for="position">Pozycja: </label>
        <input type="number" id="position" name="position" value="{{$section->position}}" }}>

        <label for="textarea">Opis: </label>
        <textarea name="description" id="textarea">{{$section->description}}</textarea>

        <label for="section_files">Dodaj nowe pliki: </label>
        <input type="file" id="section_files" name="section_files[]" multiple>

        <button type="submit">Zapisz</button>
        <button type="submit" name="is_active" @if($section->is_active) value="is_not_active"> Zapisz i ukryj @else
                value="is_active"> Zapisz i udostępnij @endif</button>
    </form>

    <h2>Aktualne pliki w sekcji</h2>
    <ul>

        @foreach($section->sectionFiles as $sectionFile)
            <li>
                <a href="{{route('teacher.sections.files.show', ['sectionId' => $section->id, 'fileId' => $sectionFile->file->id, 'fileName' => $sectionFile->file->name])}}">{{$sectionFile->file->name}}</a>
                <form
                    action="{{route('teacher.sections.files.destroy', ['sectionId' => $section->id, 'fileId' => $sectionFile->file->id])}}"
                    method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger" type="submit">Usuń</button>
                </form>
            </li>
        @endforeach


    </ul>

@endsection
