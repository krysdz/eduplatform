@extends('modules.teacher.group_layout')

@section('title', "Sekcje $group - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Sekcje</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{route('teacher.groups.sections.create', $group)}}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj sekcję</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <th>Tytuł</th>
                <th>Pozycja</th>
                <th>Lekcja</th>
                <th>Obublikowana</th>
                </thead>
                <tbody>
                @foreach($sections as $section)
                    <tr>
                        <td>
                            <a href="{{route('teacher.groups.sections.show', [$group, $section])}}">{{$section->name}}</a>
                        </td>
                        <td>{{$section->order}}</td>
                        <td>@if($section->lesson_id){{$section->lesson->scheduledLesson->date}} @else brak @endif</td>
                        <td>@if($section->published_at)tak @else nie @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
