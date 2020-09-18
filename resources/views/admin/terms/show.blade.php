@extends('admin.index')

@section('content')
    <h1>{{$term->name}}</h1>
    <h2>{{$term->start_date}}</h2>
    <h2>{{$term->end_date}}</h2>
    <h2>{{$term->is_active}}</h2>
@endsection
