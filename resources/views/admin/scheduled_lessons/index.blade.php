@extends('admin.layout')
@section('title', "Planowane lekcje dla $group - Eduplatform.pl")

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Planowane lekcje dla {{$group}}</h1>
        <form action="{{route('admin.groups.scheduled_lessons.generate', $group)}}" method="POST">
            @csrf
            <button class="button is-normal ml-5" type="submit">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span>Generuj planowane lekcje</span>
            </button>
        </form>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
        <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Godzina rozpoczęcia</th>
            <th>Godzina zakończenia</th>
            <th>Nauczyciel</th>
            <th>Sala</th>
        </tr>
        </thead>
        <tbody>
        @foreach($scheduled_lessons as $scheduled_lesson)
            <tr>
                <td>{{$scheduled_lesson->id}}</td>
                <td>{{$scheduled_lesson->date}}</td>
                <td>{{$scheduled_lesson->start_time}}</td>
                <td>{{$scheduled_lesson->end_time}}</td>
                <td>{{$scheduled_lesson->teacher}}</td>
                <td>{{$scheduled_lesson->room_name}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection

