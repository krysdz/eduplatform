@extends('admin.layout')
@section('title', "Edytuj $user - Eduplatform.pl")


@section('content')
<h1 class="title mt-4">Edytuj użytkownika</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @method('PUT')
    @csrf

    <div class="field">
        <label class='label' for="first_name">Imię: </label>
        <div class="control">
            <input class='input' type="text" id="first_name" name="first_name" value="{{$user->first_name}}">
        </div>
    </div>


    <div class="field">
        <label class='label' for="last_name">Nazwisko: </label>
        <div class="control">
            <input class='input' type="text" id="last_name" name="last_name" value="{{$user->last_name}}">
        </div>
    </div>


    <div class="field">
        <label class='label' for="email">E-mail: </label>
        <div class="control">
            <input class='input' type="email" id="email" name="email" value="{{$user->email}}">
        </div>
    </div>


    <div class="field">
        <label class='label' for="phone">Nr telefonu: </label>
        <div class="control">
            <input class='input' type="text" id="phone" name="phone" value="{{$user->phone}}">
        </div>
    </div>


    <div class="field">
        <label class='label' for="code">Nr albumu: </label>
        <div class="control">
            <input class='input' type="text" id="code" name="code" value="{{$user->code}}">
        </div>
    </div>


    <div class="field">
        <label class='label' for="degree">Stopień naukowy: </label>
        <div class="control">
            <input class='input' type="text" id="degree" name="degree" value="{{$user->degree}}">
        </div>
    </div>


    <div class="field">
        <label class='label' for="website">Strona internetowa: </label>
        <div class="control">
            <input class='input' type="text" id="website" name="website" value="{{$user->website}}">
        </div>
    </div>

    <label class="label">Role użytkownika:</label>

    @foreach($userRoleType as $key => $value)
        <div class="field">
            <div class="control">
                <label class="checkbox" for="role-{{$value}}">{{\App\Enums\UserRoleType::getDescription($value)}}</label>
                <input type="checkbox" id="role-{{$value}}" name="roles[]" value="{{$value}}" @if($user->roles->filter(fn($roleValue) => $roleValue->type->value === $value)->isNotEmpty()) checked @endif>
            </div>
        </div>
    @endforeach

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
