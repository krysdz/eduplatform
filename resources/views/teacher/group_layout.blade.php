@extends('teacher.layout')

@section('vertical_nav')
    <nav class="nav flex-column border-right border-dark" style="width:260px">
{{--        <p class="pt-3 pl-3 pb-1 mb-0">{{$group->course->name}}</p>--}}
{{--        <p class="pt-3 pl-3 pb-1 mb-0">{{$group->type->label}} grupa {{$group->number}} </p>--}}
{{--        <p class="p-3">{{$group->course->faculty->code}}</p>--}}
        <div class="px-3 py-4 border-bottom border-dark">
            <h4 class="">{{$group->course->name}}</h4>
            <h5>{{$group->type->label}} grupa {{$group->number}}</h5>
            <p class="mb-0">{{$group->course->faculty->code}}</p>
        </div>

        <a class="nav-link" href="{{route('teacher.groups.lessons.index', $group->id)}}">Lekcje</a>
        <a class="nav-link" href="{{route('teacher.groups.sections.index', $group->id)}}">Sekcje</a>
        <a class="nav-link" href="{{route('teacher.groups.announcements.index', $group->id)}}">Ogłoszenia</a>
        <a class="nav-link" href="{{route('teacher.groups.attendances.index', $group->id)}}">Frekwencja</a>
    </nav>
@endsection
