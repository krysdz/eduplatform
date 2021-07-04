@extends('layout')

@section('title', "Moje grupy - Eduplatform.pl")

@section('content')
    <h1 class="title mb-1">Moje grupy</h1>

    <section class="section">
        <div class="list-group">
            @forelse($groups as $group)
                <a href="{{route('student.groups.show', $group)}}" class="list-group-item list-group-item-action">{{ $group }}</a>
            @empty
                <h5>Brak grup</h5>
            @endforelse
        </div>
    </section>
@endsection
