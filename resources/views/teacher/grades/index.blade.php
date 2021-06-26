@extends('teacher.group_layout')

@section('title', "Oceny $group - Eduplatform.pl")

@section('group_content')

    <div class="is-flex">
        <h1 class="title">Oceny</h1>
        <a class="button is-normal ml-5" href="{{route('teacher.groups.grades.create', $group->id)}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj ocenę</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th></th>
                <th>Lista studentów</th>
                @foreach($gradeItems as $gradeItem)
                    <th><a style="color: {{$gradeItem->color}}" href="{{route('teacher.groups.grades.edit', [$group, $gradeItem])}}">{{$gradeItem->code}}</a></th>
                @endforeach
                <th>Średnia</th>
                <th>Suma punktów</th>
            </tr>
            </thead>
            <tbody>
            @foreach($studentsGradeList as $studentId => $gradesList)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$students->where('id', '=', $studentId)->first()}}</td>
                    @foreach($gradesList['items'] as $gradeItemsId => $grade)
                        @if($grade)
                            <td style="color: {{$grade->gradeItem->color}}" @if($grade->updated_at > $grade->created_at) class="has-background-warning-light" @endif> {{$grade->grade}} @if(!is_null($grade->score))({{$grade->score}} pkt.)@endif</td>
                        @else
                            <td>?</td>
                        @endif
                    @endforeach
                    @if($gradesList['total']['grade_weight'] === 0)
                        <td>0</td>
                    @else
                        <td>{{number_format($gradesList['total']['grade_sum']/$gradesList['total']['grade_weight'], 2)}}</td>
                    @endif
                    <td>{{$gradesList['total']['score_sum']}}/{{$gradesList['total']['score_max']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
