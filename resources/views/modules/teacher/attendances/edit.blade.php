@extends('modules.teacher.group_layout')

@section('title', "Edytuj frekwencje $group - Eduplatform.pl")

@section('content')

    <section class="section">
        <form action="{{route('teacher.groups.attendances.update', $group)}}" method="POST">
            <section class="section d-flex justify-content-between align-items-center">
                <h1 class="title">Edytuj frekwencję</h1>

                <div class="d-grid gap-2 d-lg-flex">
                    <button class="btn btn-primary" type="submit">Zapisz</button>
                    <a class="btn btn-outline-primary" href="{{ url()->previous() }}">Anuluj</a>
                </div>
            </section>

            @method('PUT')
            @csrf

            <section class="section">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <th style="width: 48px;"></th>
                        <th style="min-width: 200px; max-width: 260px;">Lista studentów</th>
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
                                            <select class="form-select" name="{{$studentId}}-{{$scheduledLessonId}}"
                                                    id="{{$studentId}}-{{$scheduledLessonId}}">
                                                @if($attendance)
                                                    @foreach($attendanceTypes as $attendanceType)
                                                        <option
                                                            @if($attendance->type->value === $attendanceType) selected
                                                            @endif
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
                </div>
            </section>
        </form>
    </section>
@endsection
