@extends('teacher.layout')

@section('content')
    <h2>Lekcje {{$lessons->first()->group->course->name}} gr.{{$lessons->first()->group->number}} ({{$lessons->first()->group->type->label}})</h2>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Data</th>
            <th>Temat</th>
            <th>Obublikowana</th>
        </tr>
        @foreach($lessons as $lesson)
            <tr>
                <td><a href="{{route('teacher.lessons.show', $lesson->id)}}">{{$lesson->id}}</a></td>
                <td>{{$lesson->date}}</td>
                <td>{{$lesson->title}}</td>
                <td>@if($lesson->is_active)tak @else nie @endif</td>
                <td>
                    @empty($lesson->title)
                    <form action="{{route('teacher.lessons.edit', $lesson->id)}}" method="GET">
                    <button type="submit" name="action" value="plan" class="btn btn-success">Zaplanuj lekcję</button>
                    <button type="submit" name="'action" value="create" class="btn btn-warning">Stwórz lekcję</button>
                    </form>
                    @endempty
                    @isset($lesson->title)
                            <form action="{{route('teacher.lessons.update', $lesson->id)}}" method="POST">
                                @method('PUT')
                                @csrf
                                @if(!$lesson->is_active)
                                <button type="submit" name="action" value="publish" class="btn btn-warning">Opublikuj lekcję</button>
                                @endif
                                <button type="submit" name="action" value="clear" class="btn btn-danger">Wyczyść lekcję</button>
                            </form>
                        @endisset
                </td>
            </tr>
        @endforeach
    </table>
@endsection
