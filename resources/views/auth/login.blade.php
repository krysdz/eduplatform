@extends('app')

@section('content')
    <section class="my-5">
        <h1 class="title is-2 has-text-centered">Logowanie</h1>

        <div class="columns">
            <div class="column">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="field">
                        <label for="input-email" class="label">E-mail</label>
                        <div class="control has-icons-left">
                            <input id="input-email" type="email"
                                   class="input @error('email') is-danger @enderror" name="email"
                                   value="{{ old('email') }}" autocomplete="email" required autofocus>

                            <span class="icon is-small is-left">
                                <i class="fas fa-at"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field">
                        <label for="input-password" class="label">Hasło</label>
                        <div class="control has-icons-left">
                            <input id="input-password" type="password" name="password"
                                   class="input @error('password') is-danger @enderror"
                                   autocomplete="current-password" required>

                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>

                    <div class="field mt-5">
                        <div class="control has-text-right has-text-centered-mobile">
                            <button class="button is-link">Zaloguj</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
