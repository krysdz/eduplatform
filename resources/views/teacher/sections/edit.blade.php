@extends('teacher.group_layout')

@section('title', "Edytuj $section - Eduplatform.pl")

@section('group_content')

    <h1 class="title">Edytuj sekcję </h1>
    <h2 class="subtitle">{{$section->name}}</h2>


    <form action="{{route('teacher.groups.sections.update', [$group, $section])}}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label" for="name">Tytuł: </label>
            <div class="control">
                <input type="text" class="input" id="name" name="name" value="{{$section->name}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="order">Pozycja: </label>
            <div class="control">
                <input class="input" type="number" id="order" name="order" value="{{$section->order}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="lesson_id">Lekcja:</label>
            <div class="control">
                <div class="select">
                    <select id="lesson_id" name="lesson_id">
                        @if($section->lesson)
                            @foreach($lessons as $lesson)
                                <option value="{{$lesson->id}}" @if($section->lesson->id === $lesson->id) selected @endif>{{$lesson->name}}</option>
                            @endforeach
                        @else
                            @foreach($lessons as $lesson)
                                <option hidden selected></option>
                                <option value="{{$lesson->id}}">{{$lesson->name}}</option>
                            @endforeach
                        @endif
                    </select>
            </div>
        </div>

        <div class="field">
            <label class='label' for="description">Opis:</label>
            <div class="control">
                <textarea class='textarea' id="textarea" name="description">{{$section->description}}</textarea>
            </div>
        </div>

        <div class="file">
            <label class="file-label">
                <input class="file-input" type="file" id="section_files" name="section_files[]" multiple>
                <span class="file-cta">
                  <span class="file-icon">
                    <i class="fas fa-upload"></i>
                  </span>
                  <span class="file-label">
                    Dodaj pliki
                  </span>
                </span>
            </label>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" type="submit">Zapisz</button>
            </div>
            @if(!$section->published_at)
                <div class="control">
                    <button class="button is-link" type="submit" name="published_at" value="{{Carbon\Carbon::now()}}">Zapisz i udostępnij</button>
                </div>
            @else
                <div class="control">
                    <button class="button is-link" type="submit" name="published_at" value="">Zapisz i ukryj</button>
                </div>
            @endif
            <div class="control">
                <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
            </div>
        </div>
        </div>
    </form>

    <label class='label'>Pliki w sekcji:</label>
    @foreach($section->sectionFiles as $sectionFile)
        <div>
            <a href="{{route('teacher.groups.sections.files.show', [$group, $section, $sectionFile->file->id, $sectionFile->file->filename])}}">{{$sectionFile->file->filename}}</a>
            <form
                action="{{route('teacher.groups.sections.files.destroy', [$group, $section,$sectionFile->file->id])}}"
                method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>
    @endforeach
@endsection

