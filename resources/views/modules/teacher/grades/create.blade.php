@extends('modules.teacher.group_layout')

@section('title', "Dodaj ocenę - Eduplatform.pl")

@section('content')

    <h1 class="title">Dodaj ocenę</h1>

    <section class="section">
        <form action="{{route('teacher.groups.grades.store', $group)}}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <input type="text" name="code" class="form-control" id="code" placeholder="">
                <label for="code">Kod</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="">
                <label for="name">Nazwa</label>
            </div>

            <div class="form-floating mb-3">
                <select id="color" class="form-select" name="color">
                    <option selected value="">Wybierz z listy...</option>
                    @foreach($colors as $color => $name)
                        <option value="{{$color}}">{{$name}}</option>
                    @endforeach
                </select>
                <label for="color">Kolor</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" name="weight" class="form-control" id="weight" placeholder="">
                <label for="weight">Waga</label>
            </div>

            <div class="form-floating mb-3">
                <input type="number" name="maxscore" class="form-control" id="maxscore" placeholder="">
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
                        @foreach($students as $student)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$student}}</td>
                                <td>
                                    <select class="form-select" name="{{$student->id}}-grade_value" id="{{$student->id}}-grade_value">
                                        <option selected value="">Wybierz z listy...</option>
                                        @foreach($gradeValues as $key => $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="number" id="score" name="{{$student->id}}-score">
                                </td>
                                <td>
                                    <input class="form-control" type="text" id="comment" name="{{$student->id}}-comment">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
