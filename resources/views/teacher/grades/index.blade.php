@extends('teacher.group_layout')

@section('content')
    <div class="is-flex">
        <h3 class="title is-3 mr-5">Oceny</h3>
        <a class="button" href="{{route('teacher.groups.grades.create', $group->id)}}">
            <span class="icon">
                <i class="fas fa-plus"></i>
            </span>
            <span>Dodaj oceny</span>
        </a>
    </div>

    <div class="table-container">
        <table class="table is-striped is-fullwidth">
            <thead>
            <tr>
                <th></th>
                <th style="min-width: 220px">Lista studentów</th>
                @foreach($gradeItems as $gradeItem)
                    <th style="min-width: 120px">{{$gradeItem->code}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($studentsGradeList as $studentId => $gradesList)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$students->where('id', '=', $studentId)->first()->first_name}} {{$students->where('id', '=', $studentId)->first()->last_name}}
                        (student_id {{$studentId}})
                    </td>
                    @foreach($gradesList as $gradeItemsId => $grade)
                        @if($grade)
                            <td @if($grade->updated_at > $grade->created_at) class="table-warning" @endif> {{$grade->grade_value}} </td>
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
