@extends('teacher.group_layout')

@section('content')
    <h3 class="title is-3">Edytuj ocenę</h3>
    <form action="{{route('teacher.grades.update', $gradeItem->id)}}" method="POST">
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

        <div class="field">
            <label class="label" for="color">Kolor: </label>
            <div class="control">
                <input class="input" type="text" id="color" name="color" value="{{$gradeItem->color}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="mark_weight">Waga: </label>
            <div class="control">
                <input class="input" type="number" id="mark_weight" name="mark_weight"
                       value="{{$gradeItem->mark_weight}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="max_score">Maksymalna liczba punktów: </label>
            <div class="control">
                <input class="input" type="number" id="max_score" name="max_score" value="{{$gradeItem->max_score}}">
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
                                        <option @if($value == $grade->grade_value) selected
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
