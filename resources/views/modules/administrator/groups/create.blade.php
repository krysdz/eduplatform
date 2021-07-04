@extends('layout')

@section('title', "Dodaj grupę - Eduplatform.pl")

@section('content')
    <h1 class="title">Dodaj grupę</h1>

    <section class="section">
        <form action="{{route('administrator.groups.store')}}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <select id="course_id" class="form-select" name="course_id">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
                <label for="course_id">Kurs</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="number" class="form-control" id="number" placeholder="">
                <label for="number">Numer</label>
            </div>

            <div class="form-floating mb-3">
                <select id="type" class="form-select" name="type">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($types as $key => $value)
                        <option value="{{$value}}">{{\App\Enums\GroupType::getDescription($value)}}</option>
                    @endforeach
                </select>
                <label for="type">Typ:</label>
            </div>

            <div class="form-floating mb-3">
                <select id="term_id" class="form-select" name="term_id">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($terms as $term)
                        <option value="{{$term->id}}">{{$term}}</option>
                    @endforeach
                </select>
                <label for="term_id">Semestr</label>
            </div>

            <div class="mb-3">
                <label for="teachers">Nauczyciele</label>
                <select id="teachers" class="form-select" name="teachers[]" multiple>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{$teacher}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="students">Studenci</label>
                <select id="students" class="form-select" name="students[]" multiple>
                    @foreach($students as $student)
                        <option value="{{$student->id}}">{{$student}}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
