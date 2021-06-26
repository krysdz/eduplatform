@extends('admin.layout')

@section('title', "Dodaj grupę - Eduplatform.pl")

@section('content')
    <h1 class="title mt-4">Dodaj grupę</h1>

    <form action="{{route('admin.groups.store')}}" method="POST">
        @csrf

        <h2 class="subtitle">Informacje o grupie:</h2>

        <div class="field">
            <label class="label" for="course_id">Kurs:</label>
            <div class="control">
                <div class="select">
                    <select id="course_id" name="course_id">
                        <option hidden selected></option>
                        @foreach($courses as $course)
                            <option value="{{$course->id}}">{{$course->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="number">Numer:</label>
            <div class="control">
                <input class="input" type="text" id="number" name="number">
            </div>
        </div>

        <div class="field">
            <label class="label" for="type">Typ:</label>
            <div class="control">
                <div class="select">
                    <select id="type" name="type">
                        <option hidden selected></option>
                        @foreach($types as $key => $value)
                            <option value="{{$value}}">{{$key}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="term_id">Semestr:</label>
            <div class="control">
                <div class="select">
                    <select id="term_id" name="term_id">
                        <option hidden selected></option>
                        @foreach($terms as $term)
                            <option value="{{$term->id}}">{{$term->name}}</option>
                        @endforeach
                    </select></div>
            </div>
        </div>

        <h2 class="subtitle">Członkowie grupy:</h2>

        <div class="field">
            <label class="label" for="teachers">Nauczyciele:</label>
            <div class="control">
                <div class="select is-multiple"><select id="teachers" name="teachers[]" multiple>
                        <option hidden selected></option>
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}">{{$teacher}}</option>
                        @endforeach
                    </select></div>

            </div>
        </div>

        <div class="field">
            <label class="label" for="students">Studenci:</label>
            <div class="control">
                <div class="select is-multiple"><select id="students" name="students[]" multiple>
                        @foreach($students as $student)
                            <option value="{{$student->id}}">{{$student}}</option>
                        @endforeach
                    </select></div>

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
