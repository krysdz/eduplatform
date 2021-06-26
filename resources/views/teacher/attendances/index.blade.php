@extends('teacher.group_layout')

@section('title', "Frekwencja $group - Eduplatform.pl")

@section('group_content')

    <div class="is-flex">
        <h1 class="title">Frekwencja</h1>
        <a class="button is-normal ml-5" href="{{route('teacher.groups.attendances.edit', $group)}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Edytuj frekwencje</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <th></th>
            <th style="min-width: 220px">Lista studentów</th>
            @foreach($scheduledLessons as $lesson)
                <th>{{$lesson->date}}</th>
            @endforeach
        @foreach($attendanceTypes as $type)
            <th><abbr title="{{\App\Enums\AttendanceType::getDescription($type)}}">{{\App\Enums\AttendanceType::getDescription($type)[0]}}</abbr></th>
        @endforeach
        </thead>
        <tbody>
        @foreach($studentsAttendanceList as $studentId => $attendanceList)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$students->where('id', '=', $studentId)->first()}}</td>
                @foreach($attendanceList['items'] as $scheduledLessonId => $attendance)
                    @if($attendance)
                        <td @if($attendance->updated_at > $attendance->created_at) class="has-background-warning-light" @endif> {{\App\Enums\AttendanceType::getDescription($attendance->type)[0]}} </td>
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
