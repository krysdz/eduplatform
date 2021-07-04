@extends('layout')
@section('title', 'Semestry - Eduplatform.pl')

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Semestry</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('administrator.terms.create') }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj semestr</span>
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
                    <th>Data rozpoczęcia</th>
                    <th>Ostani dzień zajęć</th>
                    <th>Data zakończenia</th>
                    <th>Bieżący semestr</th>
                </tr>
                </thead>
                <tbody>
                @foreach($terms as $term)
                    <tr>
                        <td><a href="{{ route('administrator.terms.show', $term) }}">{{ $term->name }}</a></td>
                        <td>{{ $term->code }}</td>
                        <td>{{ $term->start_date }}</td>
                        <td>{{ $term->end_classes_date }}</td>
                        <td>{{ $term->end_date }}</td>
                        <td>@if ($term->checkIsActive()) <span class="tag is-success">Tak</span> @else <span
                                class="tag is-danger">Nie</span> @endif</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </section>
@endsection
