<h1>Dodaj semestr</h1>
<form action="{{route('admin.terms.store')}}" method="POST">
    @csrf

    <label for="start_date">Data rozpoczęcia: </label>
    <input type="date" name="start_date">

    <label for="end_date">Data zakończenia: </label>
    <input type="date" name="end_date">

    <label for="is_active">Aktywny? </label>
    <input type="checkbox" name="is_active" value="is_active">

    <button type="submit">Dodaj</button>
</form>
