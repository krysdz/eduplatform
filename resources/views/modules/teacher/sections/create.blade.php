@extends('modules.teacher.group-layout')

@section('title', "Dodaj sekcję - Eduplatform.pl")

@section('content')

    <h1 class="title">Dodaj sekcję </h1>

    <section class="section">
        <form action="{{route('teacher.groups.sections.store', $group)}}" enctype="multipart/form-data" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="">
                <label for="name">Tytuł</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" name="order" class="form-control" id="order" placeholder="">
                <label for="order">Pozycja</label>
            </div>

            <div class="form-floating mb-3">
                <select name="lesson_id" class="form-select" id="lesson_id">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($lessons as $lesson)
                        <option value="{{$lesson->id}}">{{$lesson->name}}</option>
                    @endforeach
                </select>
                <label for="lesson_id">Lekcja</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Opis</label>
                <textarea class="tinymce" id="description" name="description"></textarea>
            </div>

            <div class="mb-3">
                <label for="files" class="form-label">Dodaj pliki</label>
                <input class="form-control" type="file" id="files" name="files[]" multiple>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <button class="btn btn-success" type="submit" name="published_at" value="{{Carbon\Carbon::now()}}">
                    Zapisz i udostępnij
                </button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
