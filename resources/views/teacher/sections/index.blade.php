@extends('teacher.group_layout')

@section('title', "Sekcje $group - Eduplatform.pl")

@section('group_content')
    <div class="is-flex">
        <h1 class="title">Sekcje</h1>
        <a class="button is-normal ml-5" href="{{route('teacher.groups.sections.create', $group)}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj sekcję</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <th>Tytuł</th>
            <th>Pozycja</th>
            <th>Lekcja</th>
            <th>Obublikowana</th>
        </thead>
        <tbody>
            @foreach($sections as $section)
                <tr>
                    <td><a href="{{route('teacher.groups.sections.show', [$group, $section])}}">{{$section->name}}</a></td>
                    <td>{{$section->order}}</td>
                    <td>@if($section->lesson_id){{$section->lesson->scheduledLesson->date}} @else brak @endif</td>
                    <td>@if($section->published_at)tak @else nie @endif</td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
