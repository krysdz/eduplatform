@extends('admin.index')

@section('content')
    <h1>Dodaj wydział</h1>
    <form action="{{route('admin.faculties.store')}}" method="POST">
        @csrf

        <label for="name">Nazwa: </label>
        <input type="text" name="name">

        <label for="code">Kod: </label>
        <input type="text" name="code">

        <button type="submit">Dodaj</button>
    </form>
@endsection
