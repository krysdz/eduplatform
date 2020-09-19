@extends('admin.index')

@section('content')
<h1>Edytuj semestr</h1>
<form action="{{route('admin.terms.update', $term->id)}}" method="POST">
    @method('PUT')
    @csrf

    <label for="name">Nazwa: </label>
    <input type="text" id="name" name="name" value="{{$term->name}}">

    <label for="start_date">Data rozpoczęcia: </label>
    <input type="date" id="start_date" name="start_date" value="{{$term->start_date}}">

    <label for="end_date">Data zakończenia: </label>
    <input type="date" id="end_date" name="end_date" value="{{$term->end_date}}">

    <label for="is_active">Aktywny? </label>
    <input type="checkbox" id="is_active" name="is_active" value="is_active" @if($term->is_active) checked @endif">

    <button type="submit">Zapisz</button>
</form>
@endsection
