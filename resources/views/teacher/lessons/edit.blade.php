@extends('teacher.group_layout')

@section('content')
    <h3 class="title is-3">@if($action === 'plan') Zaplanuj @elseif($action === 'create')
            Stwórz @elseif($action === 'edit') Edytuj @endif lekcję</h3>
    <form action="{{route('teacher.lessons.update', $lesson->id)}}" method="POST">
        @method('PUT')
        @csrf
        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field">
                    <label class="label" for="date">Data: </label>
                    <div class="control">
                        <input class="input" type="date" id="date" name="date" value="{{$lesson->date}}">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="number">Numer: </label>
                    <div class="control">
                        <input class="input" id="number" name="number" value="{{$lesson->number}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="title">Temat: </label>
            <div class="control">
                <input class="input" type="text" id="title" name="title" value="{{$lesson->title}}">
            </div>
        </div>

        @if($action === 'create' || ($action === 'edit' && $lesson->is_active) )
            <input type="hidden" id="is_active" name="is_active" value="is_active">
        @endif

        <div class="field is-grouped">
            <p class="control">
                <button class="button is-primary">
                    Zapisz
                </button>
            </p>
            <p class="control">
                <a class="button is-light" href="{{url()->previous()}}">
                    Powrót
                </a>
            </p>
        </div>
    </form>
@endsection
