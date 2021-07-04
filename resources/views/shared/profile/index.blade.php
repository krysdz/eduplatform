@extends('layout')
@section('title', "Profil użytkownika $user - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">Profil użytkownika</h1>
    <h2 class="subtitle">{{ $user }}</h2>

    <h5 class="subtitle-sm">Twoje konto na Eduplatform zostało założone {{ $user->created_at->diffForHumans() }}.</h5>

    <section class="section">
        <h5 class="subtitle-sm">Moje role</h5>
        @forelse($user->roles->sortBy('type') as $role)
            <span class="badge bg-light text-dark">{{\App\Enums\UserRoleType::getDescription($role->type)}}</span>
        @empty
            <p>Obecnie nie posiadam żadnych ról,</p>
        @endforelse
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Moje dane kontaktowe</h5>

        <p class="mb-0">
            Email:
            <a href="mailto:{{$user->email}}">{{$user->email}}</a>
        </p>
        <p class="mb-0">
            Numer tel.:
            <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
        </p>
        <p class="mb-0">
            Strona internetowa: <a href="http://{{$user->website}}">{{$user->website}}</a>
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Moje informacje o wykształceniu</h5>

        <p class="mb-0">
            Nr indeksu:
            {{$user->code}}
        </p>
        <p class="mb-0">
            Uzyskany stopień naukowy:
            {{$user->degree}}
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Moje grupy</h5>

        <ul>
            @forelse($user->groups()->withPivot('type')->get() as $group)
                <li>
                    {{ $group }}
                    <span
                        class="badge bg-light text-dark">{{ \App\Enums\GroupMemberType::getDescription($group->pivot->type) }}</span>
                    <span class="badge bg-dark">{{ $group->term }}</span>
                </li>
            @empty
                <p>Brak grup przypisanych do użytkownika.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <div class="alert alert-warning">
            <h5 class="alert-heading">Zmień hasło</h5>
            <p>Pamiętaj, że nowe hasło musi:</p>
            <ul>
                <li>zawierać minimum 8 znaków</li>
                <li>zawierać co najmniej 1 dużą literę</li>
                <li>zawierać przynajmniej jedną dużą i jedną małą literę</li>
                <li>powinno zawierać przynajmniej jedną cyfrę</li>
                <li>zawierać inne znaki, np. ~ ! ? @ # $ % ^ & * _ - + ( ) [ ] { } > < / \ | " ' . , : ; ;</li>
            </ul>
        </div>

        <form action="{{ route('profile.change_password') }}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="">
                <label for="current_password">Obecne hasło</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="">
                <label for="new_password">Nowe hasło</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="new_password2" class="form-control" id="new_password2" placeholder="">
                <label for="new_password2">Powtórz nowe hasło</label>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zmień</button>
            </div>
        </form>

    </section>

@endsection
