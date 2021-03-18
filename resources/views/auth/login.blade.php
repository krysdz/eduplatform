@extends('app')

@section('content')
    <h1>Logowanie</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror" name="email"
               value="{{ old('email') }}" required autocomplete="email" autofocus>

        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror" name="password"
               required autocomplete="current-password">

        <button type="submit" class="btn btn-primary">
            Zaloguj
        </button>
    </form>
@endsection
