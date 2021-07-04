@extends('layout')

@section('title', 'Grupy - Eduplatform.pl')

@section('content')
    <section class="section d-flex justify-content-between align-items-center">
        <h1 class="title">Grupy</h1>

        <div>
            <a class="btn btn-outline-dark" href="{{ route('administrator.groups.create') }}">
                <span class="me-2"><i class="fas fa-plus"></i></span>
                <span>Dodaj grupę</span>
            </a>
        </div>
    </section>

    <section class="section">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <th>Grupa</th>
                <th>Typ</th>
                <th>Semestr</th>
                <th>Wydział</th>
                <th>Liczba nauczycieli</th>
                <th>Liczba studentów</th>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>
                            <a href="{{route('administrator.groups.show', $group->id)}}">
                                {{$group->course}} (gr. {{$group->number}})
                            </a>
                        </td>
                        <td>{{\App\Enums\GroupType::getDescription($group->type)}}</td>
                        <td>{{$group->term->code}}</td>
                        <td>{{$group->course->faculty->code}}</td>
                        <td>{{$group->teachers_relation_count}}</td>
                        <td>{{$group->students_relation_count}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
