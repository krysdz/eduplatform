@extends('layout')

@section('title', "Plan zajęć - Eduplatform.pl")

@section('fluid_content')
    <div class="flex-fill container-fluid">
        <div class="my-4">
            <h1 class="title mb-1">Plan zajęć</h1>
            <h2 class="subtitle">{{$term}}</h2>
        </div>

        <section class="section">
            <div class="row">
                @foreach($daysOfWeek as $day)
                    <div class="col-12 col-lg-3 col-xxl mb-4">
                        <h5>{{\App\Enums\DayOfWeekType::getDescription($day)}}</h5>
                        @if(!empty($groupsSchedules[$day]))
                            @foreach($groupsSchedules[$day] as $classes)
                                <div class="card @if($classes->interval_days > 7) border-warning @endif">
                                    <div class="card-body">
                                        @if(Auth::user()->roles->where('type', '=', \App\Enums\UserRoleType::Teacher))
                                            <a class="link-dark text-decoration-none"
                                               href="{{route('teacher.groups.show', $classes->group->id)}}">
                                                <h5 class="card-title fs-6">{{$classes->group}}</h5>
                                                <h6 class="card-subtitle fs-7 text-muted">{{$classes->start_time}}
                                                    - {{$classes->end_time}}</h6>
                                                <p class="card-text fs-7">s. {{$classes->room_name}}</p>
                                            </a>
                                        @else
                                            <h5 class="card-title fs-6">{{$classes->group}}</h5>
                                            <h6 class="card-subtitle fs-7 text-muted">{{$classes->start_time}}
                                                - {{$classes->end_time}}</h6>
                                            <p class="card-text fs-7">s. {{$classes->room_name}}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title fs-6">Brak zajęć</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
