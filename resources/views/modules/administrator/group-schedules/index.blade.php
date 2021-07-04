@extends('layout')
@section('title', "Harmonogramy dla $group - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <div>
            <h1 class="title">Harmonogramy</h1>
            <h2 class="subtitle"><a class="link-dark" href="{{route('administrator.groups.show', $group)}}">{{ $group }}</a></h2>
        </div>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('administrator.groups.group_schedules.create', $group) }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj harmonogram</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Dzień tygodnia</th>
                    <th>Godzina rozpoczęcia</th>
                    <th>Godzina zakończenia</th>
                    <th>Interwał</th>
                    <th>Data rozpoczęcia</th>
                    <th>Data zakończenia</th>
                    <th>Nauczyciel</th>
                    <th>Sala</th>
                    <th>Akcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach($group_schedules as $group_schedule)
                    <tr>
                        <td>{{\App\Enums\DayOfWeekType::getDescription($group_schedule->day_of_week_type)}}</td>
                        <td>{{$group_schedule->start_time}}</td>
                        <td>{{$group_schedule->end_time}}</td>
                        <td>{{$group_schedule->interval_days}}</td>
                        <td>{{$group_schedule->first_date}}</td>
                        <td>{{$group_schedule->last_date}}</td>
                        <td>{{$group_schedule->teacher}}</td>
                        <td>{{$group_schedule->room_name}}</td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-primary me-2"
                                   href="{{ route('administrator.groups.group_schedules.edit', [$group, $group_schedule]) }}">Edytuj</a>
                                <form
                                    action="{{ route('administrator.groups.group_schedules.destroy', [$group, $group_schedule]) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Usuń</button>
                                </form>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

