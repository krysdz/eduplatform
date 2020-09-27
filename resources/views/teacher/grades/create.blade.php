@extends('teacher.group_layout')

@section('content')
    <h3 class="title is-3">Dodaj ocenę</h3>
    <form action="{{route('teacher.groups.grades.store', $group->id)}}" method="POST">
        @csrf

        <div class="field">
            <label class="label" for="code">Kod: </label>
            <div class="control">
                <input class="input" type="text" id="code" name="code">
            </div>
        </div>

        <div class="field">
            <label class="label" for="name">Nazwa: </label>
            <div class="control">
                <input class="input" type="text" id="name" name="name">
            </div>
        </div>

        <div class="field">
            <label class="label" for="color">Kolor: </label>
            <div class="control">
                <input class="input" type="text" id="color" name="color" placeholder="#0000000">
            </div>
        </div>

        <div class="field">
            <label class="label" for="mark_weight">Waga: </label>
            <div class="control">
                <input class="input" type="number" id="mark_weight" name="mark_weight" placeholder="1">
            </div>
        </div>

        <div class="field">
            <label class="label" for="max_score">Maksymalna liczba punktów: </label>
            <div class="control">
                <input class="input" type="number" id="max_score" name="max_score">
            </div>
        </div>


        <table class="table is-striped is-fullwidth">
            <thead>
            <tr>
                <th></th>
                <th style="min-width: 220px">Lista studentów</th>
                <th style="min-width: 220px">Ocena</th>
                <th style="min-width: 220px">Liczba punktów</th>
                <th style="min-width: 220px">Komentarz</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student->first_name}}
                        {{$student->last_name}}
                    </td>
                    <td>
                        <div class="select">
                            <select name="{{$student->id}}-grade_value" id="">
                                <option hidden selected></option>
                                @foreach($gradeValues as $key => $value)
                                    <option value="{{$value}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="field">
                            <div class="control">
                                <input class="input" type="number" id="score" name="{{$student->id}}-score">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="field">
                            <div class="control">
                                <input class="input" type="text" id="comment" name="{{$student->id}}-comment">
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>


        <div class="field is-grouped">
            <p class="control">
                <button class="button is-primary">
                    Dodaj
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
