@extends('layout.app')
@section('title', 'Мои студенты')
@section('content')
    <h1 class="mb-3"><i class="bi bi-people-fill text-primary"></i> Мои студенты</h1>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr>
                <th>Студент</th>
                <th>Email</th>
                <th>Проект</th>
                <th>Статус</th>
                <th>Дедлайн</th>
                <th>Оценка</th>
                <th>Комментарий</th>
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
                        <form action="{{ route('mentor.deadline', $sp) }}" method="POST" class="d-flex gap-1">
                            @csrf
                            <input type="date" name="deadline" value="{{ $sp->deadline?->format('Y-m-d') }}" class="form-control form-control-sm" style="width: 120px;">
                            <button type="submit" class="btn btn-sm btn-outline-secondary" data-bs-toggle="tooltip" title="Установить дедлайн">
                                <i class="bi bi-calendar-check"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($sp->grade)
                            <span class="badge bg-success">{{ $sp->grade }}/5</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($sp->mentor_comment)
                            <span data-bs-toggle="tooltip" title="{{ $sp->mentor_comment }}">
                            {{ Str::limit($sp->mentor_comment, 30) }}
                        </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('chat.index', $sp) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Чат">
                                <i class="bi bi-chat-dots"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $sp->id }}" data-bs-toggle="tooltip" title="Редактировать">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                {{-- Исправленное модальное окно --}}
                <div class="modal fade" id="statusModal{{ $sp->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <form action="{{ route('mentor.status', $sp) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title">
                                        <i class="bi bi-pencil-square me-2" style="color: #3a5a8c;"></i>
                                        Редактировать проект
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body pt-2">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Статус</label>
                                        <select name="status" class="form-select rounded-pill">
                                            @foreach(\App\Enums\ProjectStatus::forSelect() as $val => $label)
                                                <option value="{{ $val }}" @if($sp->status->value === $val) selected @endif>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Оценка (1–5)</label>
                                        <input type="number" name="grade" min="1" max="5" class="form-control rounded-pill" value="{{ $sp->grade }}" placeholder="Например, 4">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Комментарий наставника</label>
                                        <textarea name="comment" class="form-control rounded-3" rows="3" placeholder="Замечания, рекомендации…">{{ $sp->mentor_comment }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Отмена</button>
                                    <button type="submit" class="btn rounded-pill px-4" style="background-color: #3a5a8c; color: white;">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr><td colspan="8" class="text-center">Нет назначенных студентов.</tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endsection
