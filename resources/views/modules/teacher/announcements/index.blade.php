@extends('modules.teacher.group-layout')

@section('title', "Ogłoszenia $group - Eduplatform.pl")

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Ogłoszenia</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{route('teacher.groups.announcements.create', $group)}}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj ogłoszenie</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <th>Tytuł</th>
                <th>Data</th>
                <th>Typ</th>
                </thead>
                <tbody>
                @foreach($announcements as $announcement)
                    <tr>
                        <td>
                            <a href="{{route('teacher.groups.announcements.show', [$group, $announcement])}}">{{$announcement->title}}</a>
                        </td>
                        <td>{{$announcement->mark_at}}</td>
                        <td>{{\App\Enums\AnnouncementType::getDescription($announcement->type)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
