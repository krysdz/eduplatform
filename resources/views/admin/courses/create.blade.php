@extends('admin.index')

@section('content')
    <h1>Dodaj kurs</h1>
    <form action="{{route('admin.courses.store')}}" method="POST">
        @csrf

        <label for="name">Nazwa: </label>
        <input type="text" id="name" name="name">

        <label for="code">Kod: </label>
        <input type="text" id="code" name="code">

        <label for="faculty_id">Kod: </label>
        <select id="faculty_id" name="faculty_id">
            <option hidden selected></option>
            @foreach($faculties as $faculty)
                <option value="{{$faculty->id}}">{{$faculty->name}}</option>
            @endforeach
        </select>

        <button type="submit">Dodaj</button>
    </form>
@endsection
