@extends('layout')
@section('title', "Kursy - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Kursy</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('administrator.courses.create') }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj kurs</span>
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
                    <th>Wydział</th>
                    <th>Kordynator</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td><a href="{{ route('administrator.courses.show', $course) }}">{{ $course->name }}</a></td>
                        <td>{{ $course->code }}</td>
                        <td>{{ $course->faculty->code }}</td>
                        <td>{{ $course->coordinator }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
