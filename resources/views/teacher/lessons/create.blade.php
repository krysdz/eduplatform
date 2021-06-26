@extends('teacher.group_layout')

@section('title', "Dodaj lekcję - Eduplatform.pl")

@section('group_content')

    <h1 class="title">Dodaj lekcję </h1>
    <h2 class="subtitle">{{$scheduledLesson->date}} {{$scheduledLesson->start_time}} - {{$scheduledLesson->end_time}}</h2>

    <form action="{{route('teacher.groups.lessons.store', $group)}}" method="POST">
        @csrf

        <div class="field">
            <label class="label" for="number">Numer: </label>
            <div class="control">
                <input class="input" id="number" name="number">
            </div>
        </div>

        <div class="field">
            <label class="label" for="name">Temat: </label>
            <div class="control">
                <input class="input" type="text" id="name" name="name">
            </div>
        </div>

        <input type="hidden" name="scheduled_lesson_id" value="{{ request()->query('scheduledLesson') }}">

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" type="submit">Zapisz</button>
            </div>
            <div class="control">
                <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
            </div>
        </div>
    </form>
@endsection
