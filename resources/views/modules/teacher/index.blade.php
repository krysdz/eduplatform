@extends('layout')

@section('title', "Moduł nauczyciela - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Moduł nauczyciela</h1>

    <section class="section">
        <h2 class="subtitle">Plan zajęć na dziś ({{$today}}):</h2>
        @forelse($todayScheduledLessons as $scheduledLesson)
            <div class="card">
                <div class="card-body">
                    <a class="link-dark text-decoration-none"
                       href="{{route('teacher.groups.lessons.index', $scheduledLesson->group)}}">
                        <h5 class="card-title">{{$loop->iteration}}. {{$scheduledLesson->group}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$scheduledLesson->start_time}}
                            - {{$scheduledLesson->end_time}}</h6>
                        <p class="card-text">s. {{$scheduledLesson->room_name}}</p>
                    </a>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Brak zajęć</h5>
                </div>
            </div>
        @endforelse
    </section>

    <section class="section">
        <h2 class="subtitle">Plan zajęć na jutro ({{$tomorrow}}):</h2>
        @forelse($tomorrowScheduledLessons as $scheduledLesson)
            <div class="card">
                <div class="card-body">
                    <a class="link-dark text-decoration-none"
                       href="{{route('teacher.groups.lessons.index', $scheduledLesson->group)}}">
                        <h5 class="card-title">{{$loop->iteration}}. {{$scheduledLesson->group}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$scheduledLesson->start_time}}
                            - {{$scheduledLesson->end_time}}</h6>
                        <p class="card-text">s. {{$scheduledLesson->room_name}}</p>
                    </a>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Brak zajęć</h5>
                </div>
            </div>
        @endforelse
    </section>
@endsection
