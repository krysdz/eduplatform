@extends('admin.index')

@section('content')
    <h1>Kursy</h1>
    <button><a href="{{route('admin.courses.create')}}">Dodaj kurs</a></button>
    <table>
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Code</th>
            <th>Wydział</th>
            <th>Data stworzenia</th>
            <th>Data aktualizacji</th>
        </tr>
        @foreach($courses as $course)
            <tr>
                <td><a href="{{route('admin.courses.show', [$course->id])}}">{{$course->id}}</a></td>
                <td>{{$course->name}}</td>
                <td>{{$course->code}}</td>
                <td>{{$course->faculty->name}}</td>
                <td>{{$course->created_at}}</td>
                <td>{{$course->updated_at}}</td>
                <td>
                    <button><a href="{{route('admin.courses.edit', $course->id)}}">Edytuj</a></button>
                </td>
                <td>
                    <form action="{{route('admin.courses.destroy', $course->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
