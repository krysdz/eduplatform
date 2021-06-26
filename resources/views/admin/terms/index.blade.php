@extends('admin.layout')
@section('title', 'Semestry - Eduplatform.pl')

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Semestry</h1>
        <a class="button is-normal ml-5" href="{{route('admin.terms.create')}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj semestr</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <tr>
                <th>Id</th>
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
                <td><a href="{{route('admin.terms.show', $term)}}">{{$term->id}}</a></td>
                <td>{{$term->name}}</td>
                <td>{{$term->code}}</td>
                <td>{{$term->start_date}}</td>
                <td>{{$term->end_classes_date}}</td>
                <td>{{$term->end_date}}</td>
                <td>@if($term->checkIsActive()) <span class="tag is-success">Tak</span> @else <span class="tag is-danger">Nie</span> @endif</td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
