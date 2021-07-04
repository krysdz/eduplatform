@extends('modules.teacher.group-layout')

@section('title', "Lekcję $group - Eduplatform.pl")

@section('content')
    <h1 class="title">Lekcje</h1>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Temat</th>
                    <th>Numer lekcji</th>
                    <th>Data</th>
                    <th>Czas trwania</th>
                    <th>Nauczyciel</th>
                </tr>
                </thead>
                <tbody>
                @foreach($scheduledLesson as $scheduleLesson)
                    <tr>
                        @if($scheduleLesson->lesson()->exists())
                            <td>
                                <a href="{{route('teacher.groups.lessons.show', [$group, $scheduleLesson->lesson])}}">{{$scheduleLesson->lesson->name}}</a>
                            </td>
                            <td>{{$scheduleLesson->lesson->number}}</td>
                        @else
                            <td>
                                <a href="{{route('teacher.groups.lessons.create', $group)}}?scheduledLesson={{$scheduleLesson->id}}">+</a>
                            </td>
                            <td></td>
                        @endif
                        <td>{{$scheduleLesson->date}}</td>
                        <td>{{$scheduleLesson->start_time}} - {{$scheduleLesson->end_time}}</td>
                        <td>{{$scheduleLesson->teacher}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
