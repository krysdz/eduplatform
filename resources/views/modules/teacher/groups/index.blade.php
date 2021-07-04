@extends('layout')

@section('title', 'Moje grupy - Eduplatform.pl')

@section('content')
    <h1 class="title">Moje grupy</h1>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <th>Grupa</th>
                <th>Typ</th>
                <th>Semestr</th>
                <th>Wydział</th>
                <th>Ilość uczestników</th>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>
                            <a href="{{route('teacher.groups.show', $group->id)}}">
                                {{$group->course}} (gr. {{$group->number}})
                            </a>
                        </td>
                        <td>{{\App\Enums\GroupType::getDescription($group->type)}}</td>
                        <td>{{$group->term->code}}</td>
                        <td>{{$group->course->faculty->code}}</td>
                        <td>{{$group->students()->count()}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
