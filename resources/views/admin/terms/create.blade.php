@extends('admin.layout')
@section('title', "Dodaj semestr - Eduplatform.pl")

@section('content')

    <h1 class="title mt-4">Dodaj semestr</h1>

    <form action="{{route('admin.terms.store')}}" method="POST">
        @csrf

        <div class="field">
            <label class='label' for="start_date">Data rozpoczęcia:</label>
            <div class="control">
                <input class='input' type="date" id="start_date" name="start_date">
            </div>
        </div>

        <div class="field">
            <label class='label' for="end_classes_date">Ostani dzień zajęć dydaktycznych:</label>
            <div class="control">
                <input class='input' type="date" id="end_classes_date" name="end_classes_date">
            </div>
        </div>

        <div class="field">
            <label class='label' for="end_date">Data zakończenia:</label>
            <div class="control">
                <input class='input' type="date" id="end_date" name="end_date">
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
