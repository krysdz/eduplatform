@extends('teacher.group_layout')

@section('content')
    <div>
        <form action="{{route('teacher.groups.grades.update', $group->id)}}" method="POST" class="is-flex"
              style="flex-direction: column; flex-wrap: wrap">
            @method('PUT')
            @csrf
            <div class="buttons is-grouped">
                <h3 class="title is-3 mr-5">Edytuj oceny</h3>
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
                        @foreach($gradeItems as $gradeItem)
                            <th style="min-width: 120px">{{$gradeItem->code}}</th>
                        @endforeach
                        <th style="min-width: 120px"><span class="icon">
                       <i class="fas fa-plus"></i>
                    </span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($studentsGradeList as $studentId => $gradesList)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$students->where('id', '=', $studentId)->first()->first_name}}
                                {{$students->where('id', '=', $studentId)->first()->last_name}}
                            </td>
                            @foreach($gradesList as $gradeItemsId => $grade)
                                <td>
                                    <div class="select">
                                        <select name="{{$studentId}}-{{$gradeItemsId}}" id="">
                                            <option hidden selected></option>
                                            @foreach($gradeValue as $key => $value)
                                                <option
                                                    @if($grade && ($grade->grade_value == $value)) selected
                                                    @endif value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            @endforeach
                            <td>

                                <fieldset disabled class="select">
                                    <select class="is-disabled" name="{{$studentId}}-{{$gradeItemsId}}" id="">
{{--                                        <option disabled selected></option>--}}
{{--                                        @foreach($gradeValue as $key => $value)--}}
{{--                                            <option class="is-disabled" value="{{$value}}">{{$value}}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </fieldset>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection
