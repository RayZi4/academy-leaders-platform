@extends('layout.app')
@section('title', 'Создать проект')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Новый проект</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.projects.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Название проекта</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Описание</label>
                            <textarea name="description" rows="4" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Технологический стек (через запятую)</label>
                            <input type="text" name="tech_stack" class="form-control" placeholder="PHP, Laravel, MySQL">
                        </div>
                        <div class="mb-3">
                            <label>Сложность (1–5)</label>
                            <input type="number" name="complexity" min="1" max="5" value="3" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Наставник</label>
                            <select name="mentor_id" class="form-control">
                                <option value="">— Не назначать —</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}">{{ $mentor->name }} ({{ $mentor->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Создать</button>
                        <a href="{{ route('admin.projects') }}" class="btn btn-secondary">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
