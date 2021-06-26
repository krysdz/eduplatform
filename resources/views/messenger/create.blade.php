@extends('messenger.index')

@section('title', "Nowa wiadomość - Eduplatform.pl")

@section('messenger_content')
    <h1 class="title">Nowa wiadomość </h1>

    <form action="{{route('messenger.store')}}" method="POST">
    @csrf
        <div class="field">
            <label class="label" for="name">Nazwa rozmowy:</label>
            <div class="control">
                <input type="text" class="input" id="name" name="name">
            </div>
        </div>

        <div class="field">
            <label class="label" for="users">Do:</label>
            <div class="control">
                <div class="select is-multiple">
                    <select id="users" name="users[]" multiple>
                        <option hidden selected></option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="content">Treść:</label>
            <div class="control">
                <input type="text" class="input" id="content" name="content">
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" type="submit">Zapisz</button>
            </div>
            <div class="control">
                <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
            </div>
        </div>
    </form>

@endsection
