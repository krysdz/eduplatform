@extends('layout')
@section('title', "Edytuj $term - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Edytuj semestr</h1>
    <h2 class="subtitle">{{ $term }}</h2>

    <section class="section">
        <form action="{{route('administrator.terms.update', $term)}}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="name" value="{{$term->name}}" class="form-control" id="name" placeholder="">
                <label for="name">Nazwa</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="code" value="{{$term->code}}" class="form-control" id="code" placeholder="">
                <label for="code">Kod</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="start_date" value="{{$term->start_date}}" class="form-control" id="start_date"
                       placeholder="">
                <label for="start_date">Data rozpoczęcia</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="end_classes_date" value="{{$term->end_classes_date}}" class="form-control"
                       id="end_classes_date" placeholder="">
                <label for="end_classes_date">Ostani dzień zajęć dydaktycznych</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="end_date" value="{{$term->end_date}}" class="form-control" id="end_date"
                       placeholder="">
                <label for="end_date">Data zakończenia</label>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>

@endsection
