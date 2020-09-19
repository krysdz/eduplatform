@extends('app')

@section('content')
<h1>Internetowa platforma wspomagania nauczania</h1>
@auth()
    @if(Auth::user()->admin)
        <button><a href="{{route('admin.index')}}">Moduł administratora</a></button>
    @elseif(Auth::user()->teacher)
        <button><a href="#">Moduł nauczyciela</a></button>
    @elseif(Auth::user()->student)
        <button><a href="#">Moduł studenta</a></button>
    @endif
@endauth
@endsection
