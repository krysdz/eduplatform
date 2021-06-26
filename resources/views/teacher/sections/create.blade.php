@extends('teacher.group_layout')

@section('title', "Dodaj sekcję - Eduplatform.pl")

@section('group_content')

    <h1 class="title">Dodaj sekcję </h1>

    <form action="{{route('teacher.groups.sections.store', $group)}}" enctype="multipart/form-data" method="POST">
        @csrf

        <div class="field">
            <label class="label" for="name">Tytuł: </label>
            <div class="control">
                <input type="text" class="input" id="name" name="name">
            </div>
        </div>

        <div class="field">
            <label class="label" for="order">Pozycja: </label>
            <div class="control">
                <input class="input" type="number" id="order" name="order">
            </div>
        </div>

        <div class="field">
            <label class="label" for="lesson_id">Lekcja:</label>
            <div class="control">
                <div class="select">
                    <select id="lesson_id" name="lesson_id">
                        <option hidden selected></option>
                        @foreach($lessons as $lesson)
                            <option value="{{$lesson->id}}">{{$lesson->name}}</option>
                        @endforeach
                    </select>
            </div>
        </div>

        <div class="field">
            <label class='label' for="description">Opis:</label>
            <div class="control">
                <textarea class='textarea' id="textarea" name="description"></textarea>
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
            <div class="control">
                <button class="button is-link" type="submit" name="published_at" value="{{Carbon\Carbon::now()}}">Zapisz i udostępnij</button>
            </div>
            <div class="control">
                <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
            </div>
        </div>
        </div>
    </form>
@endsection
