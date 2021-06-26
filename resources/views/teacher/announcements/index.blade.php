@extends('teacher.group_layout')

@section('title', "Ogłoszenia $group - Eduplatform.pl")

@section('group_content')
    <div class="is-flex">
        <h1 class="title">Ogłoszenia</h1>
        <a class="button is-normal ml-5" href="{{route('teacher.groups.announcements.create', $group)}}">
            <span class="icon-text">
              <span class="icon">
                <i class="fas fa-plus"></i>
              </span>
              <span>Dodaj ogłoszenie</span>
            </span>
        </a>
    </div>

    <table class="table is-hoverable is-fullwidth">
        <thead>
            <th>Tytuł</th>
            <th>Opis</th>
            <th>Data</th>
            <th>Typ</th>
        </thead>
        <tbody>
        @foreach($announcements as $announcement)
            <tr>
                <td><a href="{{route('teacher.groups.announcements.show', [$group, $announcement])}}">{{$announcement->title}}</a></td>
                <td>{!! $announcement->description !!}</td>
                <td>{{$announcement->mark_at}}</td>
                <td>{{\App\Enums\AnnouncementType::getDescription($announcement->type)}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
