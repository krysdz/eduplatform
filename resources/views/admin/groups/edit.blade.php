@extends('admin.layout')
@section('title', "Edytuj $group - Eduplatform.pl")

@section('content')

    <h1 class="title mt-4">Edytuj grupę</h1>

    <form action="{{route('admin.groups.update', $group)}}" method="POST">
        @method('PUT')
        @csrf

        <h2 class="subtitle">Informacje o grupie:</h2>

        <div class="field">
            <label class="label" for="course_id">Kurs:</label>
            <div class="control">
                <div class="select">
                    <select id="course_id" name="course_id">
                        <option hidden selected></option>
                        @foreach($courses as $course)
                            <option @if($group->course->id === $course->id) selected
                                    @endif value="{{$course->id}}">{{$course->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="number">Numer:</label>
            <div class="control">
                <input class="input" type="text" id="number" name="number" value="{{$group->number}}">
            </div>
        </div>

        <div class=" field">
                <label class="label" for="type">Typ:</label>
                <div class="control">
                    <div class="select">
                        <select id="type" name="type">
                            <option hidden selected></option>
                            @foreach($types as $key => $value)
                                <option @if($group->type->value === $value) selected
                                        @endif value="{{$value}}">{{$key}}</option>
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
                            @foreach($terms as $term)
                                <option @if($group->term->id === $term->id) selected
                                        @endif value="{{$term->id}}">{{$term->name}}</option>
                            @endforeach
                        </select></div>
                </div>
            </div>

            <h2 class="subtitle">Członkowie grupy:</h2>

            <div class="field">
                <label class="label" for="teachers">Nauczyciele:</label>
                <div class="control">
                    <div class="select is-multiple">
                        <select id="teachers" name="teachers[]" multiple>
                            @foreach($teachers as $teacher)
                                <option @if($group->teachers()->contains($teacher->id)) selected
                                        @endif value="{{$teacher->id}}">{{$teacher}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label" for="students">Studenci:</label>
                <div class="control">
                    <div class="select is-multiple">
                        <select id="students" name="students[]" multiple>
                            @foreach($students as $student)
                                <option @if($group->students()->contains($student->id)) selected
                                        @endif value="{{$student->id}}">{{$student}}</option>
                            @endforeach
                        </select>
                    </div>
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
        </div>
    </form>
@endsection
