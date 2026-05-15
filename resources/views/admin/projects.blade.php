@extends('layout.app')
@section('title', 'Все проекты')
@section('content')
    <h1 class="mb-3"><i class="bi bi-kanban-fill text-primary"></i> Все проекты</h1>

    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Стек</th>
                <th>Сложность</th>
                <th>Наставник</th>
                <th>Статус модерации</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->id }}
                    <td>{{ htmlspecialchars($project->title) }}
                    <td>{{ $project->tech_stack ?? '—' }}
                    <td>{{ $project->complexity }}/5
                    <td>{{ $project->mentor?->name ?? 'Не назначен' }}
                    <td>
                        @if($project->approved)
                            <span class="badge bg-success">Одобрен</span>
                        @else
                            <span class="badge bg-warning text-dark">На модерации</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Редактировать
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Удалить проект?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $projects->links() }}
    </div>
@endsection
