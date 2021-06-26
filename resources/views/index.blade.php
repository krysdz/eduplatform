@extends('app')

@section('upper_content')
    <section class="hero is-large">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">Eduplatform</h1>
                <p class="subtitle">Internetowa platforma wspomagania nauczania</p>
            </div>
        </div>
        <div class="hero-foot">
            <nav class="tabs is-boxed is-fullwidth">
                <div class="container">
                    <ul>
                        @auth()
                            @foreach($roles as $role)
                                @switch($role)
                                    @case(\App\Enums\UserRoleType::SuperAdministrator)
                                    @case(\App\Enums\UserRoleType::Administrator)
                                    <li><a href="{{route('admin.index')}}">Moduł administratora</a></li>
                                    @break
                                    @case(\App\Enums\UserRoleType::Teacher)
                                    <li><a href="{{route('teacher.index')}}">Moduł nauczyciela</a></li>
                                    @break
                                    @case(\App\Enums\UserRoleType::Student)
                                    <li><a href="{{route('student.index')}}">Moduł studenta</a></li>
                                    @break
                                    @default
                                @endswitch
                            @endforeach
                        @endauth
                    </ul>
                </div>
            </nav>
        </div>
    </section>
@endsection


