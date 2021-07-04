@extends('shared.messenger.index')

@section('title', "Nowa rozmowa - Eduplatform.pl")

@section('messenger_content')
    <h2 class="subtitle">Nowa rozmowa </h2>

    <section class="section">
        <form action="{{route('messenger.store')}}" enctype="multipart/form-data" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="">
                <label for="name">Nazwa rozmowy</label>
            </div>

            <div class="mb-3">
                <label for="users">Do:</label>
                <select class="form-select" id="users" name="users[]" multiple>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="content" name="content" placeholder="">
                <label for="content">Wiadomość</label>
            </div>

            <div class="mb-3">
                <label for="section_files" class="form-label">Dodaj pliki</label>
                <input class="form-control" type="file" id="message_files" name="message_files[]" multiple>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Wyślij</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>

@endsection
