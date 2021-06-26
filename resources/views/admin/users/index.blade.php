@extends('admin.layout')
@section('title', "Użytkownicy - Eduplatform.pl")

@section('content')

    <div class="is-flex mt-4">
        <h1 class="title">Użytkownicy</h1>
        <a class="button is-normal ml-5" href="{{route('admin.users.create')}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-user-plus"></i>
              </span>
              <span>Dodaj użytkownika</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <tr>
                <th>Id</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>E-mail</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td><a href="{{route('admin.users.show', [$user->id])}}">{{$user->id}}</a></td>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <div class="tags">
                        @foreach($user->roles as $role)
                            <span class="tag">{{\App\Enums\UserRoleType::getDescription($role->type)}}</span>
                        @endforeach
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
