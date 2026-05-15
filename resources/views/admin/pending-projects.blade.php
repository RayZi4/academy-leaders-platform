@extends('layout.app')
@section('title', 'Проекты на модерации')
@section('content')
    <h1 class="mb-4"><i class="bi bi-clock-history text-primary"></i> Проекты, ожидающие подтверждения</h1>

    @if($projects->isEmpty())
        <div class="alert alert-info text-center">Нет проектов на модерации.</div>
    @else
        <div class="table-responsive-custom">
            <table class="table-custom">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Заказчик</th>
                    <th>Описание</th>
                    <th>Стек</th>
                    <th>Сложность</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}
                        <td>{{ htmlspecialchars($project->title) }}
                        <td>
                            @if($project->customer)
                                {{ htmlspecialchars($project->customer->name) }}
                                <small class="text-muted">({{ htmlspecialchars($project->customer->email) }})</small>
                            @else
                                Неизвестен
                            @endif
                        </td>
                        <td>{{ htmlspecialchars(Str::limit($project->description, 80)) }}
                        <td>{{ htmlspecialchars($project->tech_stack ?? '—') }}
                        <td>{{ $project->complexity }}/5
                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.approve-project', $project) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Одобрить проект?')">
                                        <i class="bi bi-check-lg"></i> Одобрить
                                    </button>
                                </form>
                                <form action="{{ route('admin.reject-project', $project) }}" method="POST" onsubmit="return confirm('Отклонить проект?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x-lg"></i> Отклонить
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('admin.projects') }}" class="btn btn-outline-secondary">К списку проектов</a>
    </div>
@endsection
