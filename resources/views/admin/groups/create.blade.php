@extends('admin.index')

@section('content')
    <h1>Dodaj grupę</h1>
    <form action="{{route('admin.groups.store')}}" method="POST">
        @csrf

        <label for="course_id">Kurs: </label>
        <select id="course_id" name="course_id">
            <option hidden selected></option>
            @foreach($courses as $course)
                <option value="{{$course->id}}">{{$course->name}}</option>
            @endforeach
        </select>

        <label for="number">Numer: </label>
        <input type="text" id="number" name="number">

        <label for="type">Typ: </label>
        <select id="type" name="type">
            <option hidden selected></option>
            @foreach($types as $value => $label)
                <option value="{{$value}}">{{$label}}</option>
            @endforeach
        </select>

        <label for="teacher_id">Nauczyciel: </label>
        <select id="teacher_id" name="teacher_id">
            <option hidden selected></option>
            @foreach($teachers as $teacher)
                <option value="{{$teacher->id}}">{{$teacher->user->fullName}}</option>
            @endforeach
        </select>

        <label for="term_id">Semestr: </label>
        <select id="term_id" name="term_id">
            @foreach($terms as $term)
                <option @if($term->isActive) selected @endif value="{{$term->id}}">{{$term->name}}</option>
            @endforeach
        </select>

        <label for="students">Studenci: </label>
        <select id="students" name="students[]" multiple>
            @foreach($students as $student)
                <option value="{{$student->id}}">{{$student->user->fullName}}</option>
            @endforeach
        </select>

        <button type="submit">Dodaj</button>
    </form>
@endsection
