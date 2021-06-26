@extends('admin.layout')
@section('title', "Dodaj wydział - Eduplatform.pl")

@section('content')
    <h1 class="title mt-4">Dodaj wydział</h1>

    <form action="{{route('admin.faculties.store')}}" method="POST">
        @csrf

        <div class="field">
            <label class='label' for="name">Nazwa:</label>
            <div class="control">
                <input class='input' type="text" id="name" name="name">
            </div>
        </div>

        <div class="field">
            <label class='label' for="code">Kod:</label>
            <div class="control">
                <input class='input' type="text" id="code" name="code">
            </div>
        </div>

        <div class="field">
            <label class='label' for="description">Opis:</label>
            <div class="control">
                <textarea class='textarea' id="textarea" name="description"></textarea>
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
