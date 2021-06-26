@extends('admin.layout')
@section('title', "Kursy - Eduplatform.pl")

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Kursy</h1>
        <a class="button is-normal ml-5" href="{{route('admin.courses.create')}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj kurs</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Kod</th>
            <th>Wydział</th>
            <th>Kordynator</th>
            <th>Opis</th>

        </tr>
        </thead>
        <tbody>
        @foreach($courses as $course)
            <tr>
                <td><a href="{{route('admin.courses.show', $course)}}">{{$course->id}}</a></td>
                <td>{{$course->name}}</td>
                <td>{{$course->code}}</td>
                <td>{{$course->faculty->code}}</td>
                <td>{{$course->coordinator}}</td>
                <td>{!! \Illuminate\Support\Str::limit($course->description) !!}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
