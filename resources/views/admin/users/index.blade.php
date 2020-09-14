@include('flash::message')

<h1>Użytkownicy</h1>
<table>
    <tr>
        <th>Id</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Type</th>
        <th>E-mail</th>
        <th>Data stworzenia</th>
        <th>Data aktualizacji</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td><a href="{{route('admin.users.show', [$user->id])}}">{{$user->id}}</a></td>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->type}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->created_at}}</td>
            <td>{{$user->updated_at}}</td>
            <td>
                <button><a href="{{route('admin.users.edit', $user->id)}}">Edytuj</a></button>
            </td>
            <td>
                <form action="{{route('admin.users.destroy', $user->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">Usuń</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

