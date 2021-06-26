@extends('teacher.layout')

@section('title', "Plan zajęć - Eduplatform.pl")

@section('content')
    <div class="content">
        <h1 class="title mt-4">Plan zajęć</h1>
        <h2 class="subtitle pb-5">{{$term}}</h2>

        <div class="is-flex">
            @foreach($daysOfWeek as $day)
                <div class="fa-border">
                    <p>{{\App\Enums\DayOfWeekType::getDescription($day)}}</p>
                    @if(!empty($groupsSchedules[$day]))
                        @foreach($groupsSchedules[$day] as $classes)
                            <p><a href="{{route('teacher.groups.show', $classes->group->id)}}">{{$loop->iteration}}. {{$classes->group}}</a></p>
                            <p>{{$classes->start_time}} - {{$classes->end_time}}</p>
                            <p>s. {{$classes->room_name}}</p>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>


    </div>
@endsection
