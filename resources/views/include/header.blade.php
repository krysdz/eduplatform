<header class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-md">
            <a class="navbar-brand d-flex flex-column justify-content-center lh-sm"
               href="{{ route(session('current_role_index') ?? 'index') }}">
                Eduplatform
                @if (session('current_role'))
                    <small class="d-block fs-7 text-center text-gray">
                        {{ session('current_role')->description }}
                    </small>
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    @if (session('current_role'))
                        @switch (session('current_role')->value)
                            @case (\App\Enums\UserRoleType::Student)
                            <li class="nav-item">
                                <a href="{{ route('student.groups.index') }}" class="nav-link">
                                    Grupy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('student.grades.index') }}" class="nav-link">
                                    Oceny
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('student.attendances.index') }}" class="nav-link">
                                    Frekwencja
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('student.timetable.index') }}" class="nav-link">
                                    Plan zajęć
                                </a>
                            </li>
                            @break
                            @case (\App\Enums\UserRoleType::Teacher)
                            <li class="nav-item">
                                <a href="{{ route('teacher.groups.index') }}" class="nav-link">
                                    Grupy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('teacher.timetable.index') }}" class="nav-link">
                                    Plan zajęć
                                </a>
                            </li>
                            @break
                            @case (\App\Enums\UserRoleType::Administrator)
                            <li class="nav-item">
                                <a href="{{ route('administrator.users.index') }}" class="nav-link">
                                    Użytkownicy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('administrator.terms.index') }}" class="nav-link">
                                    Semestry
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('administrator.faculties.index') }}" class="nav-link">
                                    Wydziały
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('administrator.courses.index') }}" class="nav-link">
                                    Kursy
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('administrator.groups.index') }}" class="nav-link">
                                    Grupy
                                </a>
                            </li>
                            @break
                        @endswitch
                    @endif
                </ul>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-light">
                                <strong>Zaloguj</strong>
                            </a>
                        </li>
                    @endguest

                    @auth

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                Witaj, {{ auth()->user() }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('index') }}">Zmień moduł</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Wyloguj</button>
                                    </form>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item mx-3">
                            <a href="{{ route('messenger.index') }}" class="btn btn-outline-light">
                                <i class="far fa-comments"></i>
                            </a>
                        </li>

                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
