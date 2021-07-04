@extends('modules.teacher.group_layout')

@section('title', "Oceny $group - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Oceny</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('teacher.groups.grades.create', $group->id) }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj ocenę</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 48px;"></th>
                    <th style="min-width: 200px; max-width: 260px;">Lista studentów</th>
                    @foreach($gradeItems as $gradeItem)
                        <th style="min-width: 140px;">
                            <span style="color: {{$gradeItem->color}}">{{$gradeItem->code}}</span>
                            <a class="link-dark" href="{{route('teacher.groups.grades.edit', [$group, $gradeItem])}}"><i
                                    class="far fa-edit"></i></a>
                        </th>
                    @endforeach
                    <th style="min-width: 140px;">Średnia</th>
                    <th style="min-width: 160px;">Suma punktów</th>
                </tr>
                </thead>
                <tbody>
                @foreach($studentsGradeList as $studentId => $gradesList)
                    <tr>
                        <td style="text-align: center;">{{$loop->iteration}}</td>
                        <td>{{$students->where('id', '=', $studentId)->first()}}</td>
                        @foreach($gradesList['items'] as $gradeItemsId => $grade)
                            @if($grade)
                                <td style="color: {{$grade->gradeItem->color}}"
                                    @if($grade->updated_at > $grade->created_at) class="bg-warning-100" @endif> {{$grade->grade}} @if(!is_null($grade->score))
                                        ({{$grade->score}} pkt.)@endif</td>
                            @else
                                <td>?</td>
                            @endif
                        @endforeach
                        @if($gradesList['total']['grade_weight'] === 0)
                            <td>0</td>
                        @else
                            <td>{{number_format($gradesList['total']['grade_sum']/$gradesList['total']['grade_weight'], 2)}}</td>
                        @endif
                        <td>{{$gradesList['total']['score_sum']}} pkt. /{{$gradesList['total']['score_max']}} pkt.</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
