@extends('teacher.layout')

@section('title', "Moduł nauczyciela - Eduplatform.pl")

@section('content')
    <div class="content">
        <h1 class="title mt-4">Moduł nauczyciela</h1>

        <p class="title is-4">Plan zajęć ({{$today}}):</p>

            @foreach($scheduledLessons as $scheduledLesson)
                <div class="box">
                    <div><a href="{{route('teacher.groups.lessons.index', $scheduledLesson->group)}}">{{$loop->iteration}}. {{$scheduledLesson->group}}</a></div>
                    <div>{{$scheduledLesson->start_time}} - {{$scheduledLesson->end_time}} </div>
                    <div>sala {{$scheduledLesson->room_name}}</div>
                </div>
            @endforeach
    </div>
@endsection
