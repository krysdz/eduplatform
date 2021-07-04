@extends('layout')

@section('title', "Eduplatform")

@section('fluid_content')
    <div class="flex-fill d-flex flex-column justify-content-center">
        <div class="container">
            <section class="pb-6 text-center">
                <h1>Eduplatform</h1>
                <p class="lead">Internetowa platforma wspomagania nauczania.</p>
            </section>

            <section>
                <nav class="d-grid gap-3 d-lg-flex">
                    @auth
                        @foreach($roles as $role)
                            @switch($role)
                                @case(\App\Enums\UserRoleType::SuperAdministrator)
                                @case(\App\Enums\UserRoleType::Administrator)
                                <a href="{{ route('administrator.index') }}" class="btn btn-outline-dark py-3 flex-fill">Moduł administratora</a>
                                @break
                                @case(\App\Enums\UserRoleType::Teacher)
                                <a href="{{ route('teacher.index') }}" class="btn btn-outline-dark py-3 flex-fill">Moduł nauczyciela</a>
                                @break
                                @case(\App\Enums\UserRoleType::Student)
                                <a href="{{ route('student.index') }}" class="btn btn-outline-dark py-3 flex-fill">Moduł studenta</a>
                                @break
                            @endswitch
                        @endforeach
                    @endauth
                </nav>
            </section>
        </div>
    </div>
@endsection

