@extends('layout')

@section('pre_content')
    <div class="container-fluid my-4">
        <h1 class="mb-0">{{ $group }}</h1>
    </div>
@endsection

@section('left_sidebar')
    <aside class="container-fluid w-auto mx-0 mb-4 mb-lg-0" style="min-width: 260px;">
        <div class="card">
            <nav class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action {{ Request::is(['*/lekcje', '*/lekcje/*']) ? 'active' : '' }}"
                   href="{{route('teacher.groups.lessons.index', $group->id)}}">
                    Lekcje
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is(['*/sekcje', '*/sekcje/*']) ? 'active' : '' }}"
                   href="{{route('teacher.groups.sections.index', $group->id)}}">
                    Sekcje
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is(['*/ogloszenia', '*/ogloszenia/*']) ? 'active' : '' }}"
                   href="{{route('teacher.groups.announcements.index', $group->id)}}">
                    Ogłoszenia
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is(['*/frekwencja', '*/frekwencja/*']) ? 'active' : '' }}"
                   href="{{route('teacher.groups.attendances.index', $group->id)}}">
                    Frekwencja
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is(['*/oceny', '*/oceny/*']) ? 'active' : '' }}"
                   href="{{route('teacher.groups.grades.index', $group->id)}}">
                    Oceny
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is(["*/grupy/$group->id"]) ? 'active' : '' }}"
                   href="{{route('teacher.groups.show', $group->id)}}">
                    Informacje
                </a>
            </nav>
        </div>
    </aside>
@endsection

@section('fluid_content')
    <div class="container-fluid">
        @yield('content')
    </div>
@endsection
