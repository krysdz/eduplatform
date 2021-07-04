@extends('layout')
@section('title', "$user - Eduplatform.pl")

@section('content')

    <h1 class="title mb-1">Informacje o użytkowniku</h1>
    <h2 class="subtitle">{{ $user }}</h2>

    <section class="section">
        <h5 class="subtitle-sm">Akcje</h5>

        <div class="d-grid gap-2 d-lg-flex">
            <a class="btn btn-primary py-2" href="{{ route('administrator.users.edit', $user) }}">Edytuj</a>

            <form action="{{ route('administrator.users.destroy', $user) }}" method="POST">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger py-2 w-100" type="submit">Usuń</button>
            </form>
        </div>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Role użytkownika</h5>
        @forelse($user->roles->sortBy('type') as $role)
            <span class="badge bg-light text-dark">{{\App\Enums\UserRoleType::getDescription($role->type)}}</span>
        @empty
            <p>Brak ról przypisanych do użytkownika.</p>
        @endforelse
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Dane kontaktowe</h5>

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
        <h5 class="subtitle-sm">Informacje o wykształceniu</h5>

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
        <h5 class="subtitle-sm">Grupy do których należy użytkownik</h5>

        <ul>
            @forelse($user->groups()->withPivot('type')->get() as $group)
                <li>
                    <a href="{{ route('administrator.groups.show', $group->id) }}">{{ $group }}</a>
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
        <h5 class="subtitle-sm">Inne informacje</h5>

        <p class="mb-0">Data utworzenia: {{ $user->created_at }}</p>
        <p class="mb-0">Data ostatniej aktualizacji: {{ $user->updated_at }}</p>
    </section>

@endsection
