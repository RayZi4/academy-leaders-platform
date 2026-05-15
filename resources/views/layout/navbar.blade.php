<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('welcome') }}">
            <i class="bi bi-stars"></i> Академия лидеров
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    @if(!auth()->user()->isAdmin() && !auth()->user()->isCustomer())
                        <li class="nav-item"><a class="nav-link" href="{{ route('catalog') }}"><i class="bi bi-grid-3x3-gap-fill"></i> Проекты</a></li>
                    @endif

                    @if(auth()->user()->isStudent())
                        <li class="nav-item"><a class="nav-link" href="{{ route('my.projects') }}"><i class="bi bi-folder-symlink"></i> Мои проекты</a></li>
                    @endif

                    <li class="nav-item"><a class="nav-link" href="{{ route('leaderboard') }}"><i class="bi bi-trophy-fill"></i> Рейтинг</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}"><i class="bi bi-info-circle-fill"></i> О нас</a></li>

                    @if(auth()->user()->isMentor())
                        <li class="nav-item"><a class="nav-link" href="{{ route('mentor.students') }}"><i class="bi bi-people-fill"></i> Студенты</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mentor.gantt') }}"><i class="bi bi-bar-chart-steps"></i> Гант</a></li>
                    @endif

                    @if(auth()->user()->isCustomer())
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.my-projects') }}"><i class="bi bi-briefcase-fill"></i> Мои проекты</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('customer.create-project') }}"><i class="bi bi-plus-circle"></i> Создать проект</a></li>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-shield-lock-fill"></i> Админ
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.users') }}"><i class="bi bi-people"></i> Пользователи</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.projects') }}"><i class="bi bi-kanban"></i> Все проекты</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pending-projects') }}"><i class="bi bi-clock-history"></i> На модерации</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.pending-registrations') }}"><i class="bi bi-person-plus"></i> Заявки</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.audit') }}"><i class="bi bi-journal-text"></i> Аудит</a></li>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="@if(auth()->user()->isMentor()) {{ route('mentor.profile') }} @else {{ route('profile') }} @endif">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Выход
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('catalog') }}"><i class="bi bi-grid-3x3-gap-fill"></i> Проекты</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('leaderboard') }}"><i class="bi bi-trophy-fill"></i> Рейтинг</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}"><i class="bi bi-info-circle-fill"></i> О нас</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Вход</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Регистрация</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
