@extends('teacher.layout')

@section('content')
    <h2>Edytuj frekwencję {{$group->course->name}} gr.{{$group->number}} ({{$group->type->label}})</h2>

    <form action="{{route('teacher.groups.attendances.update', $group->id)}}" method="POST">
        @method('PUT')
        @csrf
        <button type="submit">Zapisz frekwencję</button>
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
                    @foreach($attendanceList as $lessonId => $attendance)
                        <td>
                            <select name="{{$studentId}}-{{$lessonId}}" id="">
                                <option hidden selected></option>
                                @foreach($types as $value => $label)
                                    <option @if($attendance && ($attendance->type->value == $value)) selected
                                            @endif value="{{$value}}">{{$label}}</option>
                                @endforeach
                            </select>
                        </td>
                    @endforeach
                </tr>
            @endforeach

        </table>
    </form>
@endsection
