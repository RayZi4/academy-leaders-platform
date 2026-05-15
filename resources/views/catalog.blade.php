@extends('layout.app')
@section('title', 'Каталог проектов')
@section('content')
    <h1>Доступные проекты</h1>
    <div class="row">
        @forelse($projects as $project)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                        <p><strong>Стек:</strong> {{ $project->tech_stack ?? '—' }}<br>
                            <strong>Сложность:</strong> {{ $project->complexity }}/5</p>
                        @auth
                            @if(auth()->user()->isStudent())
                                <form action="{{ route('project.take', $project) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Взять проект</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="alert alert-info">Пока нет доступных проектов.</div></div>
        @endforelse
    </div>
@endsection
