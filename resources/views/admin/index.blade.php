<html>
<body>
<h1>Witaj, {{ $name }}</h1>
<button><a href="{{route('admin.users')}}">Użytkownicy</a></button>
<button><a href="{{route('admin.users.create')}}?type=administrator">Dodaj administratora</a></button>
<button><a href="{{route('admin.users.create')}}?type=nauczyciel">Dodaj nauczyciela</a></button>
<button><a href="{{route('admin.users.create')}}?type=student">Dodaj studenta</a></button>
</body>
</html>
