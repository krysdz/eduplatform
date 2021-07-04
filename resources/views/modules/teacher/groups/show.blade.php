@extends('modules.teacher.group-layout')

@section('content')
    <h1 class="title mb-1">Informacje o grupie</h1>

    <section class="section">
        <h5 class="subtitle-sm">O grupie</h5>

        <p class="mb-0">
            Kurs:
            {{$group->course}}
        </p>
        <p class="mb-0">
            Numer:
            {{$group->number}}
        </p>
        <p class="mb-0">
            Typ:
            {{\App\Enums\GroupType::getDescription($group->type)}}
        </p>
        <p class="mb-0">
            Semestr:
           {{$group->term}}
        </p>
        <p class="mb-0">
            Wydział:
            {{$group->course->faculty}}
        </p>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Harmonogramy</h5>

        <ul>
            @forelse($group->groupSchedules as $schedule)
                <li>
                    <p class="mb-0">
                        {{ \App\Enums\DayOfWeekType::getDescription($schedule->day_of_week_type) }} {{ $schedule->start_time }} - {{ $schedule->end_time }} (częstotliwość: {{$schedule->interval_days/7}} tydzień/tygodnie)
                    </p>
                    <p class="mb-0">
                        s. {{ $schedule->room_name }}, {{$schedule->teacher}}
                    </p>
                </li>
            @empty
                <p>Brak harmonogramów przypisanych do grupy.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Nauczyciele w grupie ({{$group->teachers()->count()}})</h5>

        <ul>
            @forelse($group->teachers() as $teacher)
                <li>
                    {{ $teacher }}
                </li>
            @empty
                <p>Brak nauczycieli przypisanych do grupy.</p>
            @endforelse
        </ul>
    </section>

    <section class="section">
        <h5 class="subtitle-sm">Studenci w grupie ({{$group->students()->count()}})</h5>

        <ul>
            @forelse($group->students() as $student)
                <li>
                   {{ $student }}
                </li>
            @empty
                <p>Brak studentów przypisanych do grupy.</p>
            @endforelse
        </ul>
    </section>
@endsection
