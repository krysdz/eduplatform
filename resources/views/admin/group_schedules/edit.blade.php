@extends('admin.layout')
@section('title', "Edytuj harmonogram dla $group - Eduplatform.pl")

@section('content')
    <h1 class="title mt-4">Edytuj harmonogram dla {{$group}}</h1>

    <form action="{{route('admin.groups.group_schedules.update', [$group, $group_schedule])}}" method="POST">
        @csrf
        @method('PUT')

        <div class="field">
            <label class="label" for="day_of_week_type">Dzień tygodnia:</label>
            <div class="control">
                <div class="select">
                    <select id="day_of_week_type" name="day_of_week_type">
                        @foreach($day_of_week_type as $key => $value)
                            <option @if($group_schedule->day_of_week_type->value === $value) selected
                                    @endif value="{{$value}}">{{\App\Enums\DayOfWeekType::getDescription($value)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="interval_days">Częstotliwość zajęć:</label>
            <div class="control">
                <div class="select">
                    <select id="interval_days" name="interval_days">
                        @for($i = 1; $i < 5; $i++)
                            <option value="{{$i * 7}}" @if($group_schedule->interval_days === $i) selected @endif>{{$i}} @if($i === 1) tydzień @else tygodnie @endif</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="first_date">Data rozpoczęcia:</label>
            <div class="control">
                <input class="input" type="date" id="first_date" name="first_date" value="{{$group_schedule->first_date}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="last_date">Data zakończenia:</label>
            <div class="control">
                <input class="input" type="date" id="last_date" name="last_date" value="{{$group_schedule->last_date}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="start_time">Godzina rozpoczęcia:</label>
            <div class="control">
                <input class="input" type="time" id="start_time" name="start_time" value="{{$group_schedule->start_time}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="end_time">Godzina zakończenia:</label>
            <div class="control">
                <input class="input" type="time" id="end_time" name="end_time" value="{{$group_schedule->end_time}}">
            </div>
        </div>

        <div class="field">
            <label class="label" for="teacher_id">Nauczyciel:</label>
            <div class="control">
                <div class="select">
                    <select id="teacher_id" name="teacher_id">
                        @foreach($teachers as $teacher)
                            <option @if($group->teachers()->contains($teacher->id)) selected
                                    @endif value="{{$teacher->id}}">{{$teacher}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="room_name">Sala:</label>
            <div class="control">
                <input class="input" type="text" id="room_name" name="room_name" value="{{$group_schedule->room_name}}">
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
