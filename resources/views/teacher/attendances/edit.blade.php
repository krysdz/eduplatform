@extends('teacher.group_layout')

@section('content')
    <div>
        <form action="{{route('teacher.groups.attendances.update', $group->id)}}" method="POST" class="is-flex"
              style="flex-direction: column; flex-wrap: wrap">
            @method('PUT')
            @csrf
            <div class="buttons is-grouped">
                <h3 class="title is-3 mr-5">Edytuj frekwencję</h3>
                <button type="submit" class="button">
                    <span class="icon">
                        <i class="far fa-save"></i>
                    </span>
                    <span>Zapisz zmiany</span>
                </button>

                <a href="{{url()->previous()}}" class="button">
                    <span class="icon">
                       <i class="fas fa-undo-alt"></i>
                    </span>
                    <span>Cofnij</span>
                </a>
            </div>

                <div class="table-container">
                    <table class="table is-striped is-fullwidth">
                        <thead>
                        <tr>
                            <th></th>
                            <th style="min-width: 220px">Lista studentów</th>
                            @foreach($lessons as $lesson)
                                <th style="min-width: 120px">{{$lesson->date}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($studentsAttendanceList as $studentId => $attendanceList)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$students->where('id', '=', $studentId)->first()->first_name}}
                                    {{$students->where('id', '=', $studentId)->first()->last_name}}
                                </td>
                                @foreach($attendanceList as $lessonId => $attendance)
                                    <td>
                                        <div class="select">
                                            <select name="{{$studentId}}-{{$lessonId}}" id="">
                                                <option hidden selected></option>
                                                @foreach($types as $value => $label)
                                                    <option
                                                        @if($attendance && ($attendance->type->value == $value)) selected
                                                        @endif value="{{$value}}">{{$label}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </form>
    </div>
@endsection
