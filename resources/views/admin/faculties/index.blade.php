@extends('admin.index')

@section('content')
    <h1>Wydziały</h1>
    <button><a href="{{route('admin.faculties.create')}}">Dodaj wydział</a></button>
    <table class="table">
        <tr>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Code</th>
            <th>Data stworzenia</th>
            <th>Data aktualizacji</th>
        </tr>
        @foreach($faculties as $faculty)
            <tr>
                <td><a href="{{route('admin.faculties.show', [$faculty->id])}}">{{$faculty->id}}</a></td>
                <td>{{$faculty->name}}</td>
                <td>{{$faculty->code}}</td>
                <td>{{$faculty->created_at}}</td>
                <td>{{$faculty->updated_at}}</td>
                <td>
                    <button><a href="{{route('admin.faculties.edit', $faculty->id)}}">Edytuj</a></button>
                </td>
                <td>
                    <form action="{{route('admin.faculties.destroy', $faculty->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
