@extends('layout')

@section('title', "Moje frekwencja - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Moje frekwencja</h1>

    <section class="section">
        <div class="accordion" id="accordionGrades">
            @forelse($studentAttendanceByGroup as $group => $attendanceList)
                <div class="accordion-item ">
                    <h2 class="accordion-header" id="heading-{{$group}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse-{{$group}}" aria-expanded="false"
                                aria-controls="collapse-{{$group}}">
                            {{ $groups->find($group) }}
                        </button>
                    </h2>
                    <div id="collapse-{{$group}}" class="accordion-collapse collapse" aria-labelledby="headingOne"
                         data-bs-parent="#accordionGrades">
                        <div class="accordion-body">
                            <div class="mb-3">
                                @forelse($attendanceList['items'] as $attendance)
                                    <span
                                        class="badge bg-@switch($attendance->type->value)@case(1)success @break @case(2)danger @break @case(3)warning @break @case(4)primary @break @endswitch fs-7"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-html="true"
                                        title="<div><p class='mb-0'>Temat: @if($attendance->scheduledLesson->lesson){{$attendance->scheduledLesson->lesson->name }}@else brak @endif</p>">
                                        {{ $attendance->scheduledLesson->date }}: {{ $attendance->type->description }}
                                 </span>
                                @empty
                                    <p>Brak frekwencji.</p>
                                @endforelse
                            </div>

                            <div>
                                <p class="mb-0"><small>Statystyki:</small>
                                    @foreach($attendanceList['total'] as $key => $total)
                                        <span
                                            class="badge rounded-pill bg-@switch($key)@case(1)success @break @case(2)danger @break @case(3)warning @break @case(4)primary @break @endswitch">
                                        {{\App\Enums\AttendanceType::getDescription($key)[0]}}: {{$total}}
                                    </span>
                                    @endforeach
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <h5>Brak frekwencji</h5>
            @endforelse
        </div>
    </section>
@endsection
