@extends('admin.index')

@section('content')
    <h1>Edytuj grupę</h1>
    <form action="{{route('admin.groups.update', $group->id)}}" method="POST">
        @method('PUT')
        @csrf

        <label for="course_id">Kurs: </label>
        <select id="course_id" name="course_id">
            <option hidden selected></option>
            @foreach($courses as $course)
                <option @if($group->course->id === $course->id) selected @endif value="{{$course->id}}">{{$course->name}}</option>
            @endforeach
        </select>

        <label for="number">Numer: </label>
        <input type="text" id="number" name="number" value="{{$group->number}}">

        <label for="day_of_classes">Dzień zajęć: </label>
        <select id="day_of_classes" name="day_of_classes">
            <option hidden selected></option>
            @foreach($days as $value => $label)
                <option @if($group->day_of_classes->value === $value) selected @endif value="{{$value}}">{{$label}}</option>
            @endforeach
        </select>

        <label for="start_update_date">Zmień dzień zajęć od: </label>
        <input type="date" id="start_update_date" name="start_update_date">

        <label for="type">Typ: </label>
        <select id="type" name="type">
            <option hidden selected></option>
            @foreach($types as $value => $label)
                <option @if($group->type->value === $value) selected @endif value="{{$value}}">{{$label}}</option>
            @endforeach
        </select>

        <label for="teacher_id">Nauczyciel: </label>
        <select id="teacher_id" name="teacher_id">
            <option hidden selected></option>
            @foreach($teachers as $teacher)
                <option @if($group->teacher->id === $teacher->id) selected @endif value="{{$teacher->id}}">{{$teacher->user->fullName}}</option>
            @endforeach
        </select>

        <label for="term_id">Semestr: </label>
        <select id="term_id" name="term_id">
            @foreach($terms as $term)
                <option @if($group->term->id === $term->id) selected @endif value="{{$term->id}}">{{$term->name}}</option>
            @endforeach
        </select>

        <label for="students">Studenci: </label>
        <select id="students" name="students[]" multiple>
            @foreach($students as $student)
                <option @if($group->students->contains($student->id)) selected @endif value="{{$student->id}}">{{$student->user->fullName}}</option>
            @endforeach
        </select>

        <button type="submit">Zapisz</button>
    </form>
@endsection
