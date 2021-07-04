@extends('layout')

@section('content')
    <section class="section">

        <section class="section">
            <h2 class="subtitle">Plan zajęć na dziś ({{$today}})</h2>
            @forelse($todayScheduledLessons as $scheduledLesson)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$loop->iteration}}. {{$scheduledLesson->group}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{$scheduledLesson->start_time}}
                            - {{$scheduledLesson->end_time}}</h6> {{ $scheduledLesson->created_at }}
                        <p class="card-text">s. {{$scheduledLesson->room_name}}</p>
                    </div>
                </div>
            @empty
                <h5 class="card-title">Brak zajęć</h5>
            @endforelse
        </section>

        <h2 class="subtitle">Aktualności</h2>
        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
                @if($notification->type === "App\\Notifications\\GradeNotification")
                    <div class="card border-success mb-3">
                        @if($notification->data['changes'])
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">
                                        Zmiana oceny - {{ $notification->data['group'] }}
                                    </h5>
                                    <small
                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <p class="card-text">
                                    Twoja ocena za {{ $notification->data['gradeItem'] }} została zmieniona na
                                    <span class="badge bg-success">
                                        {{$notification->data['grade']}}
                                        @if($notification->data['score'])({{$notification->data['score']}} pkt.)@endif
                                    </span>
                                </p>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">
                                        Nowa ocena - {{ $notification->data['group'] }}
                                    </h5>
                                    <small
                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <p class="card-text">
                                    Otrzymałeś ocenę za {{ $notification->data['gradeItem'] }} <span
                                        class="badge bg-success">
                                        {{$notification->data['grade']}}
                                        @if($notification->data['score'])({{$notification->data['score']}} pkt.)@endif
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                @if($notification->type === "App\\Notifications\\AttendanceNotification")
                    <div class="card border-primary mb-3">
                        @if($notification->data['changes'])
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">
                                        Zmiana frekwencji - {{ $notification->data['group'] }}
                                    </h5>
                                    <small
                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <p class="card-text">
                                    Twoja frekwencja z {{ $notification->data['date'] }} została zmieniona na
                                    <span class="badge bg-primary">{{$notification->data['attendance']}}</span>
                                </p>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">
                                        Nowa frekwencja - {{ $notification->data['group'] }}
                                    </h5>
                                    <small
                                        class="text-muted">{{ $notification->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <p class="card-text">
                                    Twoja frekwencja na zajęciach z {{ $notification->data['date'] }}
                                    <span class="badge bg-primary">{{$notification->data['attendance']}}</span>
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                @if($notification->type === "App\\Notifications\\AnnouncementNotification")
                    <div class="card border-warning mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">
                                    Nowe ogłoszenie - {{ $notification->data['group'] }}
                                </h5>
                                <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <p class="card-text">
                                {{ $notification->data['title'] }}
                            </p>
                        </div>
                    </div>
                @endif

                @if($notification->type === "App\\Notifications\\SectionNotification")
                    <div class="card border-danger mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">
                                    Nowa sekcja - {{ $notification->data['group'] }}
                                </h5>
                                <small
                                    class="text-muted">{{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <p class="card-text">
                                {{ $notification->data['name'] }}
                            </p>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <h5>Brak powiadomień</h5>
        @endif
    </section>
@endsection
