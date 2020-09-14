<html>
<body>
<h1>Witaj, {{ $name }}</h1>
<div>
    <button><a href="{{route('admin.users.index')}}">Użytkownicy</a></button>
    <button><a href="{{route('admin.users.create')}}?type=administrator">Dodaj administratora</a></button>
    <button><a href="{{route('admin.users.create')}}?type=nauczyciel">Dodaj nauczyciela</a></button>
    <button><a href="{{route('admin.users.create')}}?type=student">Dodaj studenta</a></button>
</div>
<div>
    <button><a href="{{route('admin.terms.index')}}">Semestry</a></button>
    <button><a href="{{route('admin.terms.create')}}">Dodaj semestr</a></button>
</div>
</body>
</html>
