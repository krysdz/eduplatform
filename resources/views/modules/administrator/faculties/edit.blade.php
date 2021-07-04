@extends('layout')
@section('title', "Edytuj $faculty - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">Edytuj wydział</h1>
    <h2 class="subtitle">{{ $faculty }}</h2>

    <section class="section">
        <form action="{{route('administrator.faculties.update', $faculty)}}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-floating mb-3">
                <input type="text" name="name" value="{{$faculty->name}}" class="form-control" id="name" placeholder="">
                <label for="name">Nazwa</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="code" value="{{$faculty->code}}" class="form-control" id="code" placeholder="">
                <label for="code">Kod</label>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Opis kursu</label>
                <textarea class="tinymce" id="description" name="description">{{$faculty->description}}</textarea>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>

        </form>
    </section>
@endsection
