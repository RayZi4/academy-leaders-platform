@extends('layout.app')
@section('title', 'Создать проект')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h2 class="h4 mb-0">
                        <i class="bi bi-plus-circle-fill text-primary"></i>
                        Новый проект
                    </h2>
                    <p class="text-muted mt-2 mb-0 small">
                        Заполните информацию о проекте. После модерации он станет доступен студентам.
                    </p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('customer.store-project') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                <i class="bi bi-tag me-1"></i> Название проекта
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required
                                   placeholder="Например: Разработка мобильного приложения для волонтёров">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Краткое, но понятное название.</div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                <i class="bi bi-chat-text me-1"></i> Описание проекта
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="5" required
                                      placeholder="Опишите цели, задачи, ожидаемый результат...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Чем подробнее описание, тем легче студентам будет вникнуть в задачу.</div>
                        </div>

                        <div class="mb-4">
                            <label for="tech_stack" class="form-label fw-semibold">
                                <i class="bi bi-code-square me-1"></i> Технологический стек (через запятую)
                            </label>
                            <input type="text" class="form-control @error('tech_stack') is-invalid @enderror"
                                   id="tech_stack" name="tech_stack" value="{{ old('tech_stack') }}"
                                   placeholder="PHP, Laravel, MySQL, Docker">
                            @error('tech_stack')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Укажите желаемые технологии, если есть требования.</div>
                        </div>

                        <div class="mb-4">
                            <label for="complexity" class="form-label fw-semibold">
                                <i class="bi bi-bar-chart-steps me-1"></i> Сложность (1–5)
                            </label>
                            <select class="form-select @error('complexity') is-invalid @enderror"
                                    id="complexity" name="complexity" required>
                                <option value="1" {{ old('complexity') == 1 ? 'selected' : '' }}>1 — Очень легкий</option>
                                <option value="2" {{ old('complexity') == 2 ? 'selected' : '' }}>2 — Лёгкий</option>
                                <option value="3" {{ old('complexity') == 3 ? 'selected' : '' }} selected>3 — Средний</option>
                                <option value="4" {{ old('complexity') == 4 ? 'selected' : '' }}>4 — Сложный</option>
                                <option value="5" {{ old('complexity') == 5 ? 'selected' : '' }}>5 — Очень сложный</option>
                            </select>
                            @error('complexity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Оцените примерный объём работы.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('customer.my-projects') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left"></i> Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Отправить на модерацию
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4 small">
                <i class="bi bi-info-circle-fill me-1"></i>
                После отправки администратор проверит проект и примет решение. Вы получите уведомление.
            </div>
        </div>
    </div>
@endsection
