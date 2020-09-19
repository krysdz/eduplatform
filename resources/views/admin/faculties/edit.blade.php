@extends('admin.index')

@section('content')
    <h1>Edytuj wydział</h1>
    <form action="{{route('admin.faculties.update', $faculty->id)}}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nazwa: </label>
        <input type="text" id="name" name="name" value="{{$faculty->name}}">

        <label for="code">Kod: </label>
        <input type="text" id="code" name="code" value="{{$faculty->code}}">

        <button type="submit">Zapisz</button>
    </form>
@endsection
