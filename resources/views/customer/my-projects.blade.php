@extends('layout.app')
@section('title', 'Мои проекты')
@section('content')
    <h1 class="mb-3"><i class="bi bi-briefcase-fill text-primary"></i> Мои проекты</h1>
    <a href="{{ route('customer.create-project') }}" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Создать проект</a>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr><th>ID</th><th>Название</th><th>Статус</th><th>Стек</th><th>Сложность</th><th>Дата</th></tr>
            </thead>
            <tbody>
            @forelse($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>@if($project->approved) <span class="badge bg-success">Одобрен</span> @else <span class="badge bg-warning text-dark">На модерации</span> @endif</td>
                    <td>{{ $project->tech_stack ?? '—' }}</td>
                    <td>{{ $project->complexity }}/5</td>
                    <td>{{ $project->created_at->format('d.m.Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Вы ещё не создали проектов.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
