@extends('layout')
@section('title', "Planowane lekcje dla $group - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <div>
            <h1 class="title">Planowane lekcje</h1>
            <h2 class="subtitle"><a class="link-dark" href="{{route('administrator.groups.show', $group)}}">{{ $group }}</a></h2>
        </div>

        <div>
            <form action="{{route('administrator.groups.scheduled_lessons.generate', $group)}}" method="POST">
                @csrf
                <button class="btn btn-outline-dark" type="submit">
                    <span class="me-2"><i class="fas fa-plus"></i></span>
                    <span>Generuj planowane lekcje</span>
                </button>
            </form>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
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
                        <td>{{$scheduled_lesson->date}}</td>
                        <td>{{$scheduled_lesson->start_time}}</td>
                        <td>{{$scheduled_lesson->end_time}}</td>
                        <td>{{$scheduled_lesson->teacher}}</td>
                        <td>{{$scheduled_lesson->room_name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

