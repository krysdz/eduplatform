@extends('modules.teacher.group_layout')

@section('title', "Edytuj ogłoszenie $announcement - Eduplatform.pl")

@section('content')

    <h1 class="title">Eytuj ogłoszenie </h1>

    <section class="section">
        <form action="{{route('teacher.groups.announcements.update', [$group, $announcement])}}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="title" value="{{$announcement->title}}" class="form-control" id="title"
                       placeholder="">
                <label for="title">Tytuł</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Opis</label>
                <textarea class="tinymce" id="description" name="description">{{$announcement->description}}</textarea>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="date" value="{{explode(' ', $announcement->mark_at)[0]}}" class="form-control"
                       id="date" placeholder="">
                <label for="date">Data</label>
            </div>

            <div class="form-floating mb-3">
                <input type="time" name="time" value="{{explode(' ', $announcement->mark_at)[1]}}" class="form-control"
                       id="time" placeholder="">
                <label for="time">Godzina</label>
            </div>

            <div class="form-floating mb-3">
                <select name="type" class="form-select" id="type">
                    @foreach($types as $key => $value)
                        <option @if($announcement->$value == $value) selected
                                @endif value="{{$value}}">{{\App\Enums\AnnouncementType::getDescription($value)}}</option>
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
