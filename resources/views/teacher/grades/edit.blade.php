@extends('teacher.group_layout')

@section('title', "Edytuj ocenę $gradeItem - Eduplatform.pl")

@section('group_content')

    <h1 class="title">Edytuj ocenę</h1>
    <h2 class="subtitle">{{$gradeItem}}</h2>

    <form action="{{route('teacher.groups.grades.update', [$group, $gradeItem])}}" method="POST">
        @method('PUT')
        @csrf

        <div class="field">
            <label class="label" for="code">Kod: </label>
            <div class="control">
                <input class="input" type="text" id="code" name="code" value="{{$gradeItem->code}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="name">Nazwa: </label>
            <div class="control">
                <input class="input" type="text" id="name" name="name" value="{{$gradeItem->name}}">
            </div>
        </div>

        <label class="label" for="color">Kolor:</label>
        <div class="select">
            <select name="color" id="color">
                @foreach($colors as $color => $name)
                    <option @if($gradeItem->color === $color) selected @endif value="{{$color}}">{{$name}}</option>
            @endforeach
            </select>
        </div>

        <div class="field">
            <label class="label" for="weight">Waga: </label>
            <div class="control">
                <input class="input" type="number" id="weight" name="weight"
                       value="{{$gradeItem->weight}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="maxscore">Maksymalna liczba punktów: </label>
            <div class="control">
                <input class="input" type="number" id="maxscore" name="maxscore" value="{{$gradeItem->maxscore}}">
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
            @foreach($studentsGradeList as $studentId => $grade)

                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$students->where('id', '=', $studentId)->first()->first_name}}
                        {{$students->where('id', '=', $studentId)->first()->last_name}}
                    </td>
                    @if($grade)
                        <td>
                            <div class="select">
                                <select name="{{$studentId}}-grade_value" id="">
                                    <option hidden selected></option>
                                    @foreach($gradeValues as $key => $value)
                                        <option @if($value == $grade->grade) selected
                                                @endif value="{{$value}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="number" id="score" name="{{$studentId}}-score"
                                           value="{{$grade->score}}">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" id="comment" name="{{$studentId}}-comment"
                                           value="{{$grade->comment}}">
                                </div>
                            </div>
                        </td>
                    @else
                        <td>
                            <div class="select">
                                <select name="{{$studentId}}-grade_value" id="">
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
                                    <input class="input" type="number" id="score" name="{{$studentId}}-score">
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" id="comment" name="{{$studentId}}-comment">
                                </div>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>


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
