@extends('layout.app')
@section('title', 'Профиль наставника')
@section('content')
    <div class="row">
        <!-- Левая колонка: карточка профиля -->
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    @if($mentor->avatar)
                        <img src="{{ Storage::url($mentor->avatar) }}" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:150px;height:150px;">
                            <i class="bi bi-person-badge fs-1 text-white"></i>
                        </div>
                    @endif
                    <h3>{{ $mentor->name }}</h3>
                    <p class="text-muted">{{ $mentor->email }}</p>
                    <p><strong>Роль:</strong> Наставник</p>
                    <hr>
                    <h5>Статистика</h5>
                    <div class="row mt-3 g-2">
                        <div class="col-4">
                            <div class="border rounded p-2 h-100 d-flex flex-column justify-content-between">
                                <small class="text-muted">Студентов</small>
                                <h3 class="mb-0 text-primary">{{ $totalStudents }}</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 h-100 d-flex flex-column justify-content-between">
                                <small class="text-muted">Проектов всего</small>
                                <h3 class="mb-0 text-primary">{{ $totalProjects }}</h3>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border rounded p-2 h-100 d-flex flex-column justify-content-between">
                                <small class="text-muted">Завершено</small>
                                <h3 class="mb-0 text-success">{{ $completedProjects }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Правая колонка: таблица студентов -->
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">Мои студенты и их проекты</div>
                <div class="card-body p-0">
                    <div class="table-responsive-custom">
                        <table class="table-custom mb-0">
                            <thead>
                            <tr>
                                <th>Студент</th>
                                <th>Email</th>
                                <th>Проект</th>
                                <th>Статус</th>
                                <th>Оценка</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($students as $sp)
                                <tr>
                                    <td>{{ $sp->student->name }}
                                    <td>{{ $sp->student->email }}
                                    <td>{{ $sp->project->title }}
                                    <td><span class="badge bg-secondary">{{ $sp->status->label() }}</span>
                                    <td>
                                        @if($sp->grade)
                                            <span class="badge bg-success">{{ $sp->grade }}/5</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif

                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('chat.index', $sp) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Чат">
                                                <i class="bi bi-chat-dots"></i>
                                            </a>
                                            <a href="{{ route('profile.student', $sp->student) }}" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Профиль студента">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">Нет назначенных студентов.导航</td>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
