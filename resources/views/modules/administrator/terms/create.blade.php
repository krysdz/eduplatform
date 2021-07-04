@extends('layout')
@section('title', "Dodaj semestr - Eduplatform.pl")

@section('content')

    <h1 class="title">Dodaj semestr</h1>

    <section class="section">
        <form action="{{route('administrator.terms.store')}}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="date" name="start_date" class="form-control" id="start_date" placeholder="">
                <label for="start_date">Data rozpoczęcia</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="end_classes_date" class="form-control" id="end_classes_date" placeholder="">
                <label for="end_classes_date">Ostani dzień zajęć dydaktycznych</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="end_date" class="form-control" id="end_date" placeholder="">
                <label for="end_date">Data zakończenia</label>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
