@extends('layout.app')
@section('title', 'Профиль: ' . $user->name)
@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:150px;height:150px;">
                            <i class="bi bi-person fs-1 text-white"></i>
                        </div>
                    @endif
                    <h3>{{ $user->name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>
                    <p><strong>Роль:</strong>
                        @if($user->isStudent()) Студент
                        @elseif($user->isMentor()) Наставник
                        @elseif($user->isCustomer()) Организация / Заказчик
                        @else Администратор @endif
                    </p>
                    @if($user->bio)
                        <hr>
                        <p class="text-start"><strong>О себе / Описание:</strong><br>{{ $user->bio }}</p>
                    @endif
                    @if(auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-pencil-square"></i> Редактировать профиль
                        </a>
                        @if($user->isStudent())
                            <a href="{{ route('report.pdf', $user) }}" class="btn btn-secondary mt-3">
                                <i class="bi bi-file-pdf"></i> Скачать отчёт (PDF)
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-briefcase-fill text-primary"></i>
                    @if($user->isStudent())
                        Проекты студента
                    @elseif($user->isCustomer())
                        Проекты организации
                    @else
                        Проекты
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive-custom">
                        <table class="table-custom mb-0">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Статус</th>
                                <th>Сложность</th>
                                <th>Дедлайн / Дата</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    @if($user->isStudent())
                                        {{-- Для студента $project — это объект StudentProject --}}
                                        <td>{{ $project->project->title }}
                                        <td><span class="badge bg-secondary">{{ $project->status->label() }}</span>
                                        <td>{{ $project->project->complexity }}/5
                                        <td>{{ $project->deadline ? $project->deadline->format('d.m.Y') : '—' }}
                                    @elseif($user->isCustomer())
                                        {{-- Для организации $project — это объект Project --}}
                                        <td>{{ $project->title }}
                                        <td>
                                            @if($project->approved)
                                                <span class="badge bg-success">Одобрен</span>
                                            @else
                                                <span class="badge bg-warning text-dark">На модерации</span>
                                            @endif

                                        <td>{{ $project->complexity }}/5
                                        <td>{{ $project->created_at->format('d.m.Y') }}
                                    @endif
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Нет проектов.</tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
