@extends('teacher.group_layout')

@section('title', "Lekcję $group - Eduplatform.pl")

@section('group_content')
    <h3 class="title is-3">Lekcje</h3>
    <table class="table is-hoverable is-fullwidth">
        <thead>
        <tr>
            <th>Temat</th>
            <th>Numer lekcji</th>
            <th>Data</th>
            <th>Czas trwania</th>
            <th>Nauczyciel</th>
            <th>Przełóż lekcję</th>
        </tr>
        </thead>
        <tbody>
        @foreach($scheduledLesson as $scheduleLesson)
            <tr>
                @if($scheduleLesson->lesson()->exists())
                    <td><a href="{{route('teacher.groups.lessons.show', [$group, $scheduleLesson->lesson])}}">{{$scheduleLesson->lesson->name}}</a></td>
                    <td>{{$scheduleLesson->lesson->number}}</td>
                @else
                    <td><a href="{{route('teacher.groups.lessons.create', $group)}}?scheduledLesson={{$scheduleLesson->id}}">+</a></td>
                    <td></td>
                @endif
                <td>{{$scheduleLesson->date}}</td>
                <td>{{$scheduleLesson->start_time}} - {{$scheduleLesson->end_time}}</td>
                <td>{{$scheduleLesson->teacher}}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
