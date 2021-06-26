@extends('admin.layout')
@section('title', "Edytuj $faculty - Eduplatform.pl")

@section('content')

    <h1 class="title mt-4">Edytuj wydział</h1>

    <form action="{{route('admin.faculties.update', $faculty)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="field">
            <label class='label' for="name">Nazwa:</label>
            <div class="control">
                <input class='input' type="text" id="name" name="name" value="{{$faculty->name}}">
            </div>
        </div>

        <div class="field">
            <label class='label' for="code">Kod:</label>
            <div class="control">
                <input class='input' type="text" id="code" name="code" value="{{$faculty->code}}">
            </div>
        </div>

        <div class="field">
            <label class='label' for="description">Opis:</label>
            <div class="control">
                <textarea class='textarea' id="textarea" name="description">{{$faculty->description}}</textarea>
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
