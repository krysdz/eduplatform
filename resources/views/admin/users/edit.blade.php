@extends('admin.index')

@section('content')
<h1>Edytuj użytkownika {{$user->id}}</h1>
@if($user->type == 'student')
    <h2>student</h2>
@elseif($user->type == 'teacher')
    <h2>nauczyciel</h2>
@else
    <h2>admnistrator</h2>
@endif


<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @method('PUT')
    @csrf

    <label for="first_name">Imię: </label>
    <input type="text" name="first_name" value="{{$user->first_name}}">
    <label for="last_name">Nazwisko: </label>
    <input type="text" name="last_name" value="{{$user->last_name}}">
    <label for="email">E-mail: </label>
    <input type="email" name="email" value="{{$user->email}}">
    <label for="phone">Nr telefonu: </label>
    <input type="text" name="phone" value="{{$user->phone}}">

    @if($user->type == 'student')
        <label for="code">Nr albumu: </label>
        <input type="number" name="code" value="{{$user->student->code}}">
    @elseif($user->type == 'teacher')
        <label for="degree">Stopień naukowy: </label>
        <input type="text" name="degree" value="{{$user->teacher->degree}}">
        <label for="website">Strona internetowa: </label>
        <input type="text" name="website" value="{{$user->teacher->website}}">
    @endif

    <button type="submit">Zapisz</button>

</form>
@endsection
