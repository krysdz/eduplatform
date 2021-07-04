@extends('modules.teacher.group_layout')

@section('title', "Edytuj $section - Eduplatform.pl")

@section('content')

    <h1 class="title">Edytuj sekcję </h1>
    <h2 class="subtitle">{{$section->name}}</h2>

    <section class="section">
        <form action="{{route('teacher.groups.sections.update', [$group, $section])}}" enctype="multipart/form-data"
              method="POST">
            @csrf
            @method('PUT')

            <div class="form-floating mb-3">
                <input type="text" name="name" value="{{$section->name}}" class="form-control" id="name" placeholder="">
                <label for="name">Tytuł</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" name="order" value="{{$section->order}}" class="form-control" id="order"
                       placeholder="">
                <label for="order">Pozycja</label>
            </div>

            <div class="form-floating mb-3">
                <select name="lesson_id" class="form-select" id="lesson_id">
                    @if($section->lesson)
                        @foreach($lessons as $lesson)
                            <option value="{{$lesson->id}}"
                                    @if($section->lesson->id === $lesson->id) selected @endif>{{$lesson->name}}</option>
                        @endforeach
                    @else
                        @foreach($lessons as $lesson)
                            <option value="" selected>Wybierz z listy...</option>
                            <option value="{{$lesson->id}}">{{$lesson->name}}</option>
                        @endforeach
                    @endif
                </select>
                <label for="lesson_id">Lekcja</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Opis</label>
                <textarea class="tinymce" id="description" name="description">{{$section->description}}</textarea>
            </div>

            <div class="mb-3">
                <label for="section_files" class="form-label">Dodaj nowe pliki</label>
                <input class="form-control" type="file" id="section_files" name="section_files[]" multiple>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                @if(!$section->published_at)
                    <button class="btn btn-success" type="submit" name="published_at" value="{{Carbon\Carbon::now()}}">
                        Zapisz i udostępnij
                    </button>
                @else
                    <button class="btn btn-danger" type="submit" name="published_at" value="">Zapisz i ukryj</button>
                @endif
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>

    </section>
@endsection

