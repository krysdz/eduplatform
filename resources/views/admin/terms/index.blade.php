@include('flash::message')

<h1>Semestry</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Nazwa</th>
        <th>Data rozpoczęcia</th>
        <th>Data zakończenia</th>
        <th>Aktywny?</th>
        <th>Data stworzenia</th>
        <th>Data aktualizacji</th>
    </tr>
    @foreach($terms as $term)
        <tr>
            <td><a href="{{route('admin.terms.show', [$term->id])}}">{{$term->id}}</a></td>
            <td>{{$term->name}}</td>
            <td>{{$term->start_date}}</td>
            <td>{{$term->end_date}}</td>
            <td>{{$term->is_active}}</td>
            <td>{{$term->created_at}}</td>
            <td>{{$term->updated_at}}</td>
            <td>
                <button><a href="{{route('admin.terms.edit', $term->id)}}">Edytuj</a></button>
            </td>
            <td>
                <form action="{{route('admin.terms.destroy', $term->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">Usuń</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

