@extends('admin.index')

@section('content')
    <h1>Edytuj kurs</h1>
    <form action="{{route('admin.courses.update', $course->id)}}" method="POST">
        @method('PUT')
        @csrf

        <label for="name">Nazwa: </label>
        <input type="text" id="name" name="name" value="{{$course->name}}">

        <label for="code">Kod: </label>
        <input type="text" id="code" name="code" value="{{$course->code}}">

        <label for="faculty_id">Kod: </label>
        <select id="faculty_id" name="faculty_id">
            @foreach($faculties as $faculty)
                <option value="{{$faculty->id}}" @if($course->faculty_id === $faculty->id) selected @endif>{{$faculty->name}} </option>
            @endforeach
        </select>

        <button type="submit">Zapisz</button>
    </form>
@endsection
