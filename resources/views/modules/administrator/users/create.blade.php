@extends('layout')
@section('title', "Dodaj użytkownika - Eduplatform.pl")

@section('content')
    <h1 class="title">Dodaj użytkownika</h1>

    <section class="section">
        <form action="{{ route('administrator.users.store') }}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="">
                <label for="first_name">Imię</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="">
                <label for="last_name">Nazwisko</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="">
                <label for="email">E-mail</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="phone" class="form-control" id="phone" placeholder="">
                <label for="phone">Nr telefonu</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="">
                <label for="password">Hasło</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="code" class="form-control" id="code" placeholder="">
                <label for="code">Nr albumu</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="degree" class="form-control" id="degree" placeholder="">
                <label for="degree">Stopień naukowy</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="website" class="form-control" id="website" placeholder="">
                <label for="website">Strona internetowa</label>
            </div>

            <div class="mb-3">
                <label class="label">Role użytkownika</label>

                @foreach($userRoleType as $key => $value)
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="role-{{$value}}" name="roles[]"
                               value="{{$value}}">
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
