@extends('modules.teacher.group-layout')

@section('title', "Edytuj $lesson - Eduplatform.pl")

@section('content')

    <h1 class="title">Edytuj lekcję </h1>
    <h2 class="subtitle">{{$lesson->scheduledLesson->date}} {{$lesson->scheduledLesson->start_time}}
        - {{$lesson->scheduledLesson->end_time}}</h2>

    <section class="section">
        <form action="{{route('teacher.groups.lessons.update', [$group, $lesson])}}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <input type="number" name="number" value="{{$lesson->number}}" class="form-control" id="number"
                       placeholder="">
                <label for="number">Numer</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="name" value="{{$lesson->name}}" class="form-control" id="name" placeholder="">
                <label for="name">Temat</label>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
