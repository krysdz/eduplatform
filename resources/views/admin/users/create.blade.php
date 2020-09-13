<h1>Dodaj nowego {{$type}}a</h1>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    <label for="first_name">Imię: </label>
    <input type="text" name="first_name">
    <label for="last_name">Nazwisko: </label>
    <input type="text" name="last_name">
    <label for="email">E-mail: </label>
    <input type="email" name="email">
    <label for="phone">Nr telefonu: </label>
    <input type="text" name="phone">
    <label for="password">Hasło: </label>
    <input type="password" name="password">


    @if($type == 'student')
        <label for="code">Nr albumu: </label>
        <input type="number" name="code">
    @elseif($type == 'nauczyciel')
        <label for="degree">Stopień naukowy: </label>
        <input type="text" name="degree">
        <label for="website">Strona internetowa: </label>
        <input type="text" name="website">
    @endif

    <button type="submit">Dodaj</button>
    <input type="hidden" name="type" value="{{$type}}" />
</form>
