@extends('admin.layout')
@section('title', "$user - Eduplatform.pl")

@section('content')
    <div class="content">
        <h1 class="title mt-4">Informacje o użytkowniku</h1>
        <h2 class="subtitle is-1 pb-5">{{$user}}</h2>

        <p class="title is-4">Akcje:</p>

        <div class="buttons">
            <a class="button is-success is-normal" href="{{route('admin.users.edit', $user->id)}}">Edytuj</a>
            <form class="is-inline" action="{{route('admin.users.destroy', $user->id)}}" method="POST">
                @method('DELETE')
                @csrf
                <button class="button is-danger" type="submit">Usuń</button>
            </form>
        </div>

        <p class="title is-4">Role użytkownika:</p>
        <div class="tags are-medium">
            @forelse($user->roles as $role)
                <span class="tag">{{\App\Enums\UserRoleType::getDescription($role->type)}}</span>
            @empty
                <p>Brak ról przypisanych do użytkownika.</p>
            @endforelse
        </div>

        <p class="title is-4">Dane kontaktowe:</p>
        <p>Email: <a href="mailto:{{$user->email}}">{{$user->email}}</a></p>
        <p>Numer tel.: <a href="tel:{{$user->phone}}">{{$user->phone}}</a></p>
        <p>Strona internetowa: <a href="http://{{$user->website}}">{{$user->website}}</a></p>

        <p class="title is-4">Informacje o wykształceniu:</p>
        <p>Nr indeksu: {{$user->code}}</p>
        <p>Uzyskany stopień naukowy: {{$user->degree}}</p>

        <p class="title is-4">Grupy do których należy użytkownik:</p>
        <ul>
            @forelse($user->groups()->withPivot('type')->get() as $group)
                <li>
                    <a href="{{ route('admin.groups.show', $group) }}">{{ $group }} </a>
                    <span class="tag">{{ \App\Enums\GroupMemberType::getDescription($group->pivot->type) }}</span>
                    <span class="tag is-dark">{{ $group->term }}</span>
                </li>
            @empty
                <p>Brak grup przypisanych do użytkownika.</p>
            @endforelse
        </ul>

        <p class="title is-4">Inne informacje:</p>
        <p>Data utworzenia: {{$user->created_at}}</p>
        <p>Data ostatniej aktualizacji: {{$user->updated_at}}</p>

    </div>
@endsection
