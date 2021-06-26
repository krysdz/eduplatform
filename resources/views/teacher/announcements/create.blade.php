@extends('teacher.group_layout')

@section('title', "Dodaj ogłoszenie - Eduplatform.pl")

@section('group_content')

    <h1 class="title">Dodaj ogłoszenie </h1>

    <form action="{{route('teacher.groups.announcements.store', $group->id)}}" method="POST">
        @csrf

        <div class="field">
            <label class="label" for="title">Tytuł: </label>
            <div class="control">
                <input type="text" class="input" id="title" name="title">
            </div>
        </div>

        <div class="field">
            <label class='label' for="description">Opis:</label>
            <div class="control">
                <textarea class='textarea' id="textarea" name="description"></textarea>
            </div>
        </div>

        <div class="field">
            <label class="label" for="date">Data: </label>
            <div class="control">
                <input type="date" class="input" id="date" name="date">
            </div>
        </div>

        <div class="field">
            <label class="label" for="date">Godzina: </label>
            <div class="control">
                <input type="time" class="input" id="time" name="time">
            </div>
        </div>

        <div class="field">
            <label class="label" for="type">Typ:</label>
            <div class="control">
                <div class="select">
                    <select id="type" name="type">
                        <option hidden selected></option>
                        @foreach($types as $key => $value)
                            <option value="{{$value}}">{{\App\Enums\AnnouncementType::getDescription($value)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" type="submit">Zapisz</button>
            </div>
            <div class="control">
                <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
            </div>
        </div>
    </form>
@endsection
