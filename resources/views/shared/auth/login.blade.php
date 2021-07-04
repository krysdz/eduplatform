@extends('layout')

@section('title', "Logowanie - Eduplatform.pl")

@section('content')

    <h1 class="title text-center">Logowanie</h1>
    <section class="section">
        <form method="POST" action="{{ route('login') }}">
            @csrf

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           id="input-email"
                           placeholder="" value="{{ old('email') }}" autocomplete="email" required autofocus>
                    <label for="input-email">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           id="input-password"
                           placeholder="" value="{{ old('password') }}" autocomplete="current-password" required autofocus>
                    <label for="input-password">Hasło</label>
                </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
            </div>
        </form>
    </section>
@endsection
