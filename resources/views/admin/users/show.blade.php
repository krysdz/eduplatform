@extends('admin.index')

@section('content')
<h1>{{$user->first_name}} {{$user->last_name}}</h1>
<h2>{{$user->type}}</h2>
<p>{{$user->email}}</p>
<p>{{$user->phone}}</p>
<p>{{$user->created_at}}</p>
<p>{{$user->updated_at}}</p>
@if($user->type == 'student')
    <p>{{$user->code}}</p>
@elseif($user->type == 'teacher')
    <p>{{$user->degree}}</p>
    <p>{{$user->website}}</p>
@endif

@endsection
