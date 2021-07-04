@extends('modules.teacher.group_layout')

@section('title', "Frekwencja $group - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Frekwencja</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{route('teacher.groups.attendances.edit', $group)}}">
                <span class="me-2"><i class="fas fa-edit"></i></span>
                <span>Edytuj frekwencje</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <th style="width: 48px;"></th>
                <th style="min-width: 200px; max-width: 260px;">Lista studentów</th>
                @foreach($scheduledLessons as $lesson)
                    <th style="writing-mode: sideways-lr;">{{$lesson->date}}</th>
                @endforeach
                @foreach($attendanceTypes as $type)
                    <th>{{\App\Enums\AttendanceType::getDescription($type)[0]}}</th>
                @endforeach
                </thead>
                <tbody>
                @foreach($studentsAttendanceList as $studentId => $attendanceList)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$students->where('id', '=', $studentId)->first()}}</td>
                        @foreach($attendanceList['items'] as $scheduledLessonId => $attendance)
                            @if($attendance)
                                <td @if($attendance->updated_at > $attendance->created_at) class="bg-warning" @endif> {{\App\Enums\AttendanceType::getDescription($attendance->type)[0]}} </td>
                            @else
                                <td>?</td>
                            @endif
                        @endforeach
                        @foreach($attendanceList['total'] as $type => $amount)
                            <td>{{$amount}}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
@endsection
