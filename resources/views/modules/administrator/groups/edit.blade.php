@extends('layout')
@section('title', "Edytuj $group - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">Edytuj grupę</h1>
    <h2 class="subtitle">{{ $group }}</h2>


    <section class="section">
        <form action="{{route('administrator.groups.update', $group)}}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <select id="course_id" class="form-select" name="course_id">
                    @foreach($courses as $course)
                        <option @if($group->course->id === $course->id) selected
                                @endif value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
                <label for="course_id">Kurs</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="number" value="{{$group->number}}" class="form-control" id="number"
                       placeholder="">
                <label for="number">Numer</label>
            </div>

            <div class="form-floating mb-3">
                <select id="type" class="form-select" name="type">
                    @foreach($types as $key => $value)
                        <option @if($group->type->value === $value) selected
                                @endif value="{{$value}}">{{\App\Enums\GroupType::getDescription($value)}}</option>
                    @endforeach
                </select>
                <label for="type">Typ:</label>
            </div>

            <div class="form-floating mb-3">
                <select id="term_id" class="form-select" name="term_id">
                    @foreach($terms as $term)
                        <option @if($group->term->id === $term->id) selected
                                @endif value="{{$term->id}}">{{$term}}</option>
                    @endforeach
                </select>
                <label for="term_id">Semestr</label>
            </div>

            <div class="mb-3">
                <label for="teachers">Nauczyciele</label>
                <select id="teachers" class="form-select" name="teachers[]" multiple>
                    @foreach($teachers as $teacher)
                        <option @if($group->teachers()->contains($teacher->id)) selected
                                @endif value="{{$teacher->id}}">{{$teacher}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="students">Studenci</label>
                <select id="students" class="form-select" name="students[]" multiple>
                    @foreach($students as $student)
                        <option @if($group->students()->contains($student->id)) selected
                                @endif value="{{$student->id}}">{{$student}}</option>
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
