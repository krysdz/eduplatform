@extends('modules.teacher.group_layout')

@section('title', "Dodaj lekcję - Eduplatform.pl")

@section('content')

    <h1 class="title">Dodaj lekcję </h1>
    <h2 class="subtitle">{{$scheduledLesson->date}} {{$scheduledLesson->start_time}}
        - {{$scheduledLesson->end_time}}</h2>

    <section class="section">
        <form action="{{route('teacher.groups.lessons.store', $group)}}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="number" name="number" class="form-control" id="number" placeholder="">
                <label for="number">Numer</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="">
                <label for="name">Temat</label>
            </div>

            <input type="hidden" name="scheduled_lesson_id" value="{{ request()->query('scheduledLesson') }}">

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
