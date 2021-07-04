@extends('layout')
@section('title', "Dodaj harmonogram dla $group - Eduplatform.pl")

@section('content')
    <h1 class="title">Dodaj harmonogram dla {{$group}}</h1>

    <section class="section">
        <form action="{{route('administrator.groups.group_schedules.store', $group)}}" method="POST">
            @csrf

            <div class="form-floating mb-3">
                <select id="day_of_week_type" class="form-select" name="day_of_week_type">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($day_of_week_type as $key => $value)
                        <option value="{{$value}}">{{\App\Enums\DayOfWeekType::getDescription($value)}}</option>
                    @endforeach
                </select>
                <label for="day_of_week_type">Dzień tygodnia</label>
            </div>

            <div class="form-floating mb-3">
                <select id="interval_days" class="form-select" name="interval_days">
                    <option value="" selected>Wybierz z listy...</option>
                    @for($i = 1; $i < 5; $i++)
                        <option value="{{$i * 7}}">{{$i}} @if($i === 1) tydzień @else tygodnie @endif</option>
                    @endfor
                </select>
                <label for="interval_days">Częstotliwość zajęć</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="first_date" class="form-control" id="first_date" placeholder="" min="{{$group->term->start_date}}" max="{{$group->term->end_date}}">
                <label for="first_date">Data rozpoczęcia</label>
            </div>

            <div class="form-floating mb-3">
                <input type="date" name="last_date" class="form-control" id="last_date" placeholder="" min="{{$group->term->start_date}}" max="{{$group->term->end_date}}">
                <label for="last_date">Data zakończenia</label>
            </div>

            <div class="form-floating mb-3">
                <input type="time" name="start_time" class="form-control" id="start_time" placeholder="">
                <label for="start_time">Godzina rozpoczęcia</label>
            </div>

            <div class="form-floating mb-3">
                <input type="time" name="end_time" class="form-control" id="end_time" placeholder="">
                <label for="end_time">Godzina zakończenia</label>
            </div>

            <div class="form-floating mb-3">
                <select id="teacher_id" class="form-select" name="teacher_id">
                    <option value="" selected>Wybierz z listy...</option>
                    @foreach($teachers as $teacher)
                        <option value="{{$teacher->id}}">{{$teacher}}</option>
                    @endforeach
                </select>
                <label for="teacher_id">Nauczyciel</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="room_name" class="form-control" id="room_name" placeholder="">
                <label for="room_name">Sala</label>
            </div>

            <div class="d-grid gap-2 d-lg-flex">
                <button class="btn btn-primary" type="submit">Zapisz</button>
                <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
            </div>
        </form>
    </section>
@endsection
