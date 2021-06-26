@extends('teacher.layout')

@section('vertical_nav')
    <div class="container is-fluid">
    <div class="is-flex is-flex-direction-column">
        <div class="title">{{$group}}</div>

            <div class="is-flex is-flex-direction-row">
                <aside class="menu is-flex-grow-1">
                    <ul class="menu-list">
                        <li><a class="nav-link {{ Request::is(['*/lekcje', '*/lekcje/*']) ? 'is-active' : '' }}"
                               href="{{route('teacher.groups.lessons.index', $group->id)}}">Lekcje</a></li>
                        <li><a class="nav-link {{ Request::is(['*/sekcje', '*/sekcje/*']) ? 'is-active' : '' }}"
                               href="{{route('teacher.groups.sections.index', $group->id)}}">Sekcje</a></li>
                        <li><a class="nav-link {{ Request::is(['*/ogloszenia', '*/ogloszenia/*']) ? 'is-active' : '' }}"
                               href="{{route('teacher.groups.announcements.index', $group->id)}}">Ogłoszenia</a></li>
                        <li><a class="nav-link {{ Request::is(['*/frekwencja', '*/frekwencja/*']) ? 'is-active' : '' }}"
                               href="{{route('teacher.groups.attendances.index', $group->id)}}">Frekwencja</a></li>
                        <li><a class="nav-link {{ Request::is(['*/oceny', '*/oceny/*']) ? 'is-active' : '' }}"
                               href="{{route('teacher.groups.grades.index', $group->id)}}">Oceny</a></li>
                        <li><a class="nav-link {{ Request::is(["*/$group->id"]) ? 'is-active' : '' }}"
                               href="{{route('teacher.groups.show', $group->id)}}">Informacje</a></li>
                    </ul>
                </aside>

                <div class="is-block is-flex-grow-5">
                    @yield('group_content')
                </div>

            </div>
        </div>
    </div>
@endsection

