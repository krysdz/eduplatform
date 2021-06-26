@extends('teacher.group_layout')

@section('title', "Edytuj frekwencje $group - Eduplatform.pl")

@section('group_content')
    <div>
        <form action="{{route('teacher.groups.attendances.update', $group)}}" method="POST" class="is-flex"
              style="flex-direction: column; flex-wrap: wrap">
            @method('PUT')
            @csrf

            <div class="is-flex">
                <h1 class="title">Edytuj frekwencje</h1>
                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link" type="submit">Zapisz</button>
                    </div>
                    <div class="control">
                        <button class="button is-link is-light"><a href="{{url()->previous()}}">Anuluj</a></button>
                    </div>
                </div>
            </div>


            <table class="table is-hoverable is-fullwidth">
                <thead>
                    <th></th>
                    <th>Lista studentów</th>
                    @foreach($scheduledLessons as $lesson)
                        <th>{{$lesson->date}}</th>
                    @endforeach
                </thead>
                <tbody>
                @foreach($studentsAttendanceList as $studentId => $attendanceList)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$students->where('id', '=', $studentId)->first()}}</td>
                            @foreach($attendanceList['items'] as $scheduledLessonId => $attendance)
                                <td @if($attendance && $attendance->updated_at > $attendance->created_at) class="has-background-warning-light" @endif>
                                    <div class="select">
                                        <select name="{{$studentId}}-{{$scheduledLessonId}}" id="{{$studentId}}-{{$scheduledLessonId}}">
                                            @if($attendance)
                                                @foreach($attendanceTypes as $attendanceType)
                                                    <option
                                                        @if($attendance->type->value === $attendanceType) selected @endif
                                                        value="{{$attendanceType}}">{{\App\Enums\AttendanceType::getDescription($attendanceType)[0]}}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option hidden selected></option>
                                                @foreach($attendanceTypes as $attendanceType)
                                                    <option
                                                        value="{{$attendanceType}}">{{\App\Enums\AttendanceType::getDescription($attendanceType)[0]}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
@endsection
