@extends('admin.layout')
@section('title', "Edytuj $course - Eduplatform.pl")

@section('content')

    <h1 class="title mt-4">Edytuj kurs</h1>

    <form action="{{route('admin.courses.update', $course)}}" method="POST">
        @method('PUT')
        @csrf

        <div class="field">
            <label class='label' for="name">Nazwa:</label>
            <div class="control">
                <input class='input' type="text" id="name" name="name" value="{{$course->name}}">
            </div>
        </div>

        <div class="field">
            <label class='label' for="code">Kod:</label>
            <div class="control">
                <input class='input' type="text" id="code" name="code" value="{{$course->code}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="faculty_id">Wydział:</label>
            <div class="control">
                <div class="select">
                    <select id="faculty_id" name="faculty_id">
                        <option hidden selected></option>
                        @foreach($faculties as $faculty)
                            <option value="{{$faculty->id}}" @if($course->faculty_id === $faculty->id) selected @endif>{{$faculty}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="coordinator_id">Koordynator:</label>
            <div class="control">
                <div class="select">
                    <select id="coordinator_id" name="coordinator_id">
                        <option hidden selected></option>
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}" @if($course->coordinator_id === $teacher->id) selected @endif>{{$teacher}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class='label' for="description">Opis:</label>
            <div class="control">
                <textarea class='textarea' id="textarea" name="description">{{$course->description}}</textarea>
            </div>
        </div>

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
