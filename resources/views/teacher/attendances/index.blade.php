@extends('teacher.group_layout')

@section('content')
    <div class="is-flex">
        <h3 class="title is-3 mr-5">Frekwencja</h3>
        <a class="button" href="{{route('teacher.groups.attendances.edit', $group->id)}}">
            <span class="icon">
                <i class="fas fa-edit"></i>
            </span>
            <span>Edytuj frekwencję</span>
        </a>
    </div>

    <div class="table-container">
        <table class="table is-striped is-fullwidth">
            <thead>
            <tr>
                <th></th>
                <th style="min-width: 220px">Lista Studentów</th>
                @foreach($lessons as $lesson)
                    <th style="min-width: 120px">{{$lesson->date}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($studentsAttendanceList as $studentId => $attendanceList)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$students->where('id', '=', $studentId)->first()->first_name}} {{$students->where('id', '=', $studentId)->first()->last_name}}
                        (student_id {{$studentId}})
                    </td>
                    @foreach($attendanceList as $date => $attendance)
                        @if($attendance)
                            <td @if($attendance->updated_at > $attendance->created_at) class="table-warning" @endif> {{$attendance->type->label}} </td>
                        @else
                            <td>?</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
