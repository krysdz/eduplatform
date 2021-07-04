@extends('layout')
@section('title', "Edytuj $user - Eduplatform.pl")


@section('content')
    <h1 class="title mb-1">Edytuj użytkownika</h1>
    <h2 class="subtitle">{{ $user }}</h2>

    <section class="section">
        <form action="{{ route('administrator.users.update', $user->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" id="first_name"
                       placeholder="">
                <label for="first_name">Imię</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control" id="last_name"
                       placeholder="">
                <label for="last_name">Nazwisko</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" value="{{$user->email}}" class="form-control" id="email"
                       placeholder="">
                <label for="email">E-mail</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="phone" value="{{$user->phone}}" class="form-control" id="phone" placeholder="">
                <label for="phone">Nr telefonu</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="code" value="{{$user->code}}" class="form-control" id="code" placeholder="">
                <label for="code">Nr albumu</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="degree" value="{{$user->degree}}" class="form-control" id="degree"
                       placeholder="">
                <label for="degree">Stopień naukowy</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="website" value="{{$user->website}}" class="form-control" id="website"
                       placeholder="">
                <label for="website">Strona internetowa</label>
            </div>

            <div class="mb-3">
                <label class="label">Role użytkownika</label>

                @foreach($userRoleType as $key => $value)
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="role-{{$value}}" name="roles[]"
                               value="{{$value}}"
                               @if($user->roles->filter(fn($roleValue) => $roleValue->type->value === $value)->isNotEmpty()) checked @endif>
                        <label class="form-check-label"
                               for="role-{{$value}}">{{\App\Enums\UserRoleType::getDescription($value)}}</label>
                    </div>
                @endforeach
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
