@extends('layout')
@section('title', "Dodaj kurs - Eduplatform.pl")

@section('content')
    <h1 class="title">Dodaj kurs</h1>

    <section class="section">
        <form action="{{ route('administrator.courses.store') }}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="">
                <label for="name">Nazwa</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="code" class="form-control" id="code" placeholder="">
                <label for="code">Kod</label>
            </div>

            <div class="form-floating mb-3">
                <select name="faculty_id" class="form-select" id="faculty_id">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty }}</option>
                    @endforeach
                </select>
                <label for="faculty_id">Wydział</label>
            </div>

            <div class="form-floating mb-3">
                <select name="coordinator_id" class="form-select" id="coordinator_id">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher }}</option>
                    @endforeach
                </select>
                <label for="coordinator_id">Koordynator</label>
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
