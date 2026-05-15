@extends('layout.app')
@section('title', 'Редактировать проект')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Редактирование проекта: {{ $project->title }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.projects.update', $project) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Название проекта</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Описание</label>
                            <textarea name="description" rows="4" class="form-control" required>{{ old('description', $project->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Технологический стек (через запятую)</label>
                            <input type="text" name="tech_stack" class="form-control" value="{{ old('tech_stack', $project->tech_stack) }}">
                        </div>
                        <div class="mb-3">
                            <label>Сложность (1–5)</label>
                            <input type="number" name="complexity" min="1" max="5" value="{{ old('complexity', $project->complexity) }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Наставник</label>
                            <select name="mentor_id" class="form-control">
                                <option value="">— Не назначать —</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}" {{ $project->mentor_id == $mentor->id ? 'selected' : '' }}>{{ $mentor->name }} ({{ $mentor->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('admin.projects') }}" class="btn btn-secondary">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
