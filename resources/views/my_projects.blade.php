@extends('layout.app')
@section('title', 'Мои проекты')
@section('content')
    <h1 class="mb-4"><i class="bi bi-folder-symlink text-primary"></i> Мои проекты</h1>

    <div class="row">
        @forelse($projects as $sp)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sp->project->title }}</h5>
                        <p class="card-text">
                            <span class="badge bg-secondary">{{ $sp->status->label() }}</span>
                        </p>
                        <div class="mb-2">
                            <small class="text-muted"><i class="bi bi-calendar-event"></i> Дедлайн:</small>
                            <strong>{{ $sp->deadline ? $sp->deadline->format('d.m.Y') : 'не установлен' }}</strong>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted"><i class="bi bi-star-fill text-warning"></i> Оценка:</small>
                            <strong>{{ $sp->grade ? $sp->grade . '/5' : '—' }}</strong>
                        </div>
                        @if($sp->mentor_comment)
                            <div class="alert alert-info py-2 mb-3">
                                <i class="bi bi-chat-dots-fill"></i>
                                <strong>Комментарий наставника:</strong><br>
                                {{ $sp->mentor_comment }}
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <div class="d-flex gap-2">
                            <a href="{{ route('chat.index', $sp) }}" class="btn btn-primary flex-fill" style="background-color: #3a5a8c; border-color: #3a5a8c;">
                                <i class="bi bi-chat-dots"></i> Чат
                            </a>
                            <button type="button" class="btn btn-success flex-fill" style="background-color: #2c6e5c; border-color: #2c6e5c;" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $sp->id }}">
                                <i class="bi bi-upload"></i> Загрузить версию
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Модальное окно загрузки версии (изменённые цвета) -->
            <div class="modal fade" id="uploadModal{{ $sp->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fs-5">
                                <i class="bi bi-cloud-upload-fill me-2" style="color: #3a5a8c;"></i>
                                Загрузить новую версию
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('version.upload', $sp) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body pt-2">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Файл</label>
                                    <input type="file" name="file" class="form-control" style="border-radius: 1rem;">
                                    <div class="form-text">Допустимые форматы: ZIP, архив проекта, PDF и др.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Ссылка на репозиторий (GitHub/GitLab)</label>
                                    <input type="url" name="repo_url" class="form-control" placeholder="https://github.com/user/repo" style="border-radius: 1rem;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Комментарий к версии</label>
                                    <textarea name="comment" class="form-control" rows="3" placeholder="Что изменилось, на что обратить внимание..." style="border-radius: 1rem;"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn rounded-pill px-4" style="background-color: #3a5a8c; color: white; border: none;">Загрузить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Вы ещё не взяли ни одного проекта. <a href="{{ route('catalog') }}">Выбрать проект</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
