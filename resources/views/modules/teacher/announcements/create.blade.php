@extends('modules.teacher.group-layout')

@section('title', "Dodaj ogłoszenie - Eduplatform.pl")

@section('content')

    <h1 class="title">Dodaj ogłoszenie </h1>

    <section class="section">
        <form action="{{route('teacher.groups.announcements.store', $group->id)}}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="title" class="form-control" id="title" placeholder="">
                <label for="title">Tytuł</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Opis</label>
                <textarea class="tinymce" id="description" name="description"></textarea>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="date" class="form-control" id="date" placeholder="">
                <label for="date">Data</label>
            </div>

            <div class="form-floating mb-3">
                <input type="time" name="time" class="form-control" id="time" placeholder="">
                <label for="time">Godzina</label>
            </div>

            <div class="form-floating mb-3">
                <select name="type" class="form-select" id="type">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($types as $key => $value)
                        <option value="{{$value}}">{{\App\Enums\AnnouncementType::getDescription($value)}}</option>
                    @endforeach
                </select>
                <label for="type">Typ</label>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
