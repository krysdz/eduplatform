@extends('admin.layout')
@section('title', "Edytuj $term - Eduplatform.pl")

@section('content')
    <h1 class="title mt-4">Edytuj semestr</h1>

<form action="{{route('admin.terms.update', $term)}}" method="POST">
    @method('PUT')
    @csrf

    <div class="field">
        <label class='label' for="name">Nazwa:</label>
        <div class="control">
            <input class='input' type="text" id="name" name="name" value="{{$term->name}}">
        </div>
    </div>

    <div class="field">
        <label class='label' for="code">Kod:</label>
        <div class="control">
            <input class='input' type="text" id="code" name="code" value="{{$term->code}}">
        </div>
    </div>

    <div class="field">
        <label class='label' for="start_date">Data rozpoczęcia:</label>
        <div class="control">
            <input class='input' type="date" id="start_date" name="start_date" value="{{$term->start_date}}">
        </div>
    </div>

    <div class="field">
        <label class='label' for="end_classes_date">Ostani dzień zajęć dydaktycznych:</label>
        <div class="control">
            <input class='input' type="date" id="end_classes_date" name="end_classes_date" value="{{$term->end_classes_date}}">
        </div>
    </div>

    <div class="field">
        <label class='label' for="end_date">Data zakończenia:</label>
        <div class="control">
            <input class='input' type="date" id="end_date" name="end_date" value="{{$term->end_date}}">
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
