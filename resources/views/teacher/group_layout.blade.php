@extends('teacher.layout')

@section('vertical_nav')
    <div class="section pr-0" style="flex: 0 0 260px;">
        <div class="block pl-3">
            <p class="title is-3">{{$group->course->name}}</p>
            <p class="subtitle is-4">{{$group->type->label}} grupa {{$group->number}}</p>
            <p class="subtitle is-4">{{$group->course->faculty->code}}</p>
        </div>
        <aside class="menu">
            <ul class="menu-list">
                <li><a class="nav-link {{ Request::is(['*/lekcje', '*/lekcje/*']) ? 'is-active' : '' }}"
                       href="{{route('teacher.groups.lessons.index', $group->id)}}">Lekcje</a></li>
                <li><a class="nav-link {{ Request::is(['*/sekcje', '*/sekcje/*']) ? 'is-active' : '' }}"
                       href="{{route('teacher.groups.sections.index', $group->id)}}">Sekcje</a></li>
                <li><a class="nav-link {{ Request::is(['*/ogloszenia', '*/ogloszenia/*']) ? 'is-active' : '' }}"
                       href="{{route('teacher.groups.announcements.index', $group->id)}}">Ogłoszenia</a></li>
                <li><a class="nav-link {{ Request::is(['*/frekwencja', '*/frekwencja/*']) ? 'is-active' : '' }}"
                       href="{{route('teacher.groups.attendances.index', $group->id)}}">Frekwencja</a>
                </li>
            </ul>
        </aside>
    </div>

@endsection

