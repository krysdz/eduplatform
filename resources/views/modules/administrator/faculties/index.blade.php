@extends('layout')
@section('title', "Wydziały - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Wydziały</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('administrator.faculties.create') }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj wydział</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Kod</th>
                </tr>
                </thead>
                <tbody>
                @foreach($faculties as $faculty)
                    <tr>
                        <td><a href="{{ route('administrator.faculties.show', $faculty) }}">{{ $faculty->name }}</a></td>
                        <td>{{$faculty->code}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </section>
@endsection
