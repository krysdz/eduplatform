@extends('layout')
@section('title', "Użytkownicy - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Użytkownicy</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('administrator.users.create') }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj użytkownika</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">

                <thead>
                <tr>
                    <th>Nazwisko</th>
                    <th>Imię</th>
                    <th>E-mail</th>
                    <th>Role</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ route('administrator.users.show', $user) }}">{{ $user->last_name }}</a></td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="tags">
                                @foreach($user->roles->sortBy('type') as $role)
                                    <span class="badge bg-primary">{{ \App\Enums\UserRoleType::getDescription($role->type) }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection
