@extends('admin.layout')
@section('title', "Wydziały - Eduplatform.pl")

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Wydziały</h1>
        <a class="button is-normal ml-5" href="{{route('admin.faculties.create')}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj wydział</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nazwa</th>
                <th>Kod</th>
                <th>Opis</th>
            </tr>
        </thead>
        <tbody>
        @foreach($faculties as $faculty)
            <tr>
                <td><a href="{{route('admin.faculties.show', $faculty)}}">{{$faculty->id}}</a></td>
                <td>{{$faculty->name}}</td>
                <td>{{$faculty->code}}</td>
                <td>{!! \Illuminate\Support\Str::limit($faculty->description) !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
