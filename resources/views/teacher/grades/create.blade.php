@extends('teacher.group_layout')

@section('title', "Dodaj ocenę - Eduplatform.pl")

@section('group_content')

    <h1 class="title">Dodaj ocenę</h1>

    <form action="{{route('teacher.groups.grades.store', $group)}}" method="POST">
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

        <label class="label" for="color">Kolor:</label>
        <div class="select">
            <select name="color" id="color">
                @foreach($colors as $color => $name)
                    <option value="{{$color}}">{{$name}}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label class="label" for="weight">Waga: </label>
            <div class="control">
                <input class="input" type="number" id="weight" name="weight" value="1">
            </div>
        </div>

        <div class="field">
            <label class="label" for="maxscore">Maksymalna liczba punktów: </label>
            <div class="control">
                <input class="input" type="number" id="maxscore" name="maxscore">
            </div>
        </div>


        <table class="table is-striped is-fullwidth">
            <thead>
            <tr>
                <th></th>
                <th>Lista studentów</th>
                <th>Ocena</th>
                <th>Liczba punktów</th>
                <th>Komentarz</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$student}}</td>
                    <td>
                        <div class="select">
                            <select name="{{$student->id}}-grade_value" id="{{$student->id}}-grade_value">
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
            <div class="control">
                <button class="button is-link" type="submit">Zapisz</button>
            </div>
            <div class="control">
                <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
            </div>
        </div>
    </form>
@endsection
