@extends('layout')
@section('title', "Dodaj wydział - Eduplatform.pl")

@section('content')
    <h1 class="title">Dodaj wydział</h1>

    <section class="section">
        <form action="{{route('administrator.faculties.store')}}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="">
                <label for="name">Nazwa</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="code" class="form-control" id="code" placeholder="">
                <label for="code">Kod</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Opis kursu</label>
                <textarea class="tinymce" id="description" name="description"></textarea>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
