@extends('modules.teacher.group_layout')

@section('title', "Edytuj ocenę $gradeItem - Eduplatform.pl")

@section('content')

    <h1 class="title">Edytuj ocenę</h1>
    <h2 class="subtitle">{{$gradeItem}}</h2>

    <section class="section">
        <form action="{{route('teacher.groups.grades.update', [$group, $gradeItem])}}" method="POST">
            @method('PUT')
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="code" value="{{$gradeItem->code}}" class="form-control" id="code"
                       placeholder="">
                <label for="code">Kod</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="name" value="{{$gradeItem->name}}" class="form-control" id="name"
                       placeholder="">
                <label for="name">Nazwa</label>
            </div>

            <div class="form-floating mb-3">
                <select id="color" class="form-select" name="color">
                    <option selected value="">Wybierz z listy...</option>
                    @foreach($colors as $color => $name)
                        <option @if($gradeItem->color === $color) selected @endif value="{{$color}}">{{$name}}</option>
                    @endforeach
                </select>
                <label for="color">Kolor</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" name="weight" value="{{$gradeItem->weight}}" class="form-control" id="weight"
                       placeholder="">
                <label for="weight">Waga</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" name="maxscore" value="{{$gradeItem->maxscore}}" class="form-control" id="maxscore"
                       placeholder="">
                <label for="maxscore">Maksymalna liczba punktów</label>
            </div>

            <section class="section">
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                <td>{{$students->where('id', '=', $studentId)->first()}}</td>
                                @if($grade)
                                    <td>
                                        <select class="form-select" name="{{$studentId}}-grade_value"
                                                id="{{$studentId}}-grade_value">
                                            @foreach($gradeValues as $key => $value)
                                                <option @if($value == $grade->grade) selected
                                                        @endif value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" value="{{$grade->score}}" id="score"
                                               name="{{$studentId}}-score">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" value="{{$grade->comment}}" id="comment"
                                               name="{{$studentId}}-comment">
                                    </td>
                                @else
                                    <td>
                                        <select class="form-select" name="{{$studentId}}-grade_value"
                                                id="{{$studentId}}-grade_value">
                                            <option selected value="">Wybierz z listy...</option>
                                            @foreach($gradeValues as $key => $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" id="score"
                                               name="{{$studentId}}-score">
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" id="comment"
                                               name="{{$studentId}}-comment">
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="d-grid gap-2 d-lg-flex">
                        <button class="btn btn-primary" type="submit">Zapisz</button>
                        <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
                    </div>
                </div>
            </section>
        </form>
    </section>
@endsection
