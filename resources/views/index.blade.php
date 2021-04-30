@extends('app')

@section('upper_content')
    <section class="hero is-medium is-link">
        <div class="hero-body">
            <div class="container">
                <h1 class="title is-2">Internetowa platforma wspomagania nauczania</h1>

                <p class="subtitle">
                    Medium subtitle
                </p>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <section class="my-5">
        @auth()
            @if(Auth::user()->admin)
                <button><a href="{{route('admin.index')}}">Moduł administratora</a></button>
            @elseif(Auth::user()->teacher)
                <button><a href="{{route('teacher.index')}}">Moduł nauczyciela</a></button>
            @elseif(Auth::user()->student)
                <button><a href="{{route('student.index')}}">Moduł studenta</a></button>
            @endif
        @endauth
    </section>
@endsection
