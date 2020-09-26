@extends('teacher.layout')

@section('content')
    <button><a href="{{route('teacher.groups.attendances.edit', $group->id)}}">Edytuj frekwencję</a></button>
    <h2>Frekwencja {{$group->course->name}} gr.{{$group->number}} ({{$group->type->label}})</h2>
    <table class="table">
        <tr>
            <th></th>
            <th>Lista Studentów</th>
            @foreach($lessons as $lesson)
                <th>{{$lesson->date}}</th>
            @endforeach
        </tr>

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
    </table>
@endsection
