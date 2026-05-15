@extends('layout.app')
@section('title', 'Академия молодых лидеров')
@push('styles')
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        .stat-card {
            transition: all 0.2s;
            border: none;
            border-radius: 2rem;
            background: white;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        }
        .stat-card:hover {
            transform: translateY(-6px);
        }
        .project-card {
            border-radius: 1.5rem;
            border: none;
            background: white;
            transition: all 0.2s;
        }
        .project-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.1);
        }
        .leader-item {
            background: white;
            border-radius: 3rem;
            padding: 0.8rem 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .leader-item:hover {
            background: #fef9e6;
            transform: translateX(8px);
        }
        .testimonial-card {
            background: white;
            border-radius: 2rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 15px 30px -10px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }
        .testimonial-card:hover {
            transform: translateY(-3px);
        }
        .zigzag-left {
            margin-left: 0;
            margin-right: auto;
        }
        .zigzag-right {
            margin-left: auto;
            margin-right: 0;
        }
        @media (max-width: 768px) {
            .zigzag-left, .zigzag-right {
                margin-left: 0;
                margin-right: 0;
            }
        }
        .hero {
            background: linear-gradient(105deg, #1a2a44 0%, #2c3e66 100%);
            border-radius: 2rem;
            padding: 4rem 2rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: "⚡";
            font-size: 12rem;
            position: absolute;
            bottom: -30px;
            right: -20px;
            opacity: 0.1;
            pointer-events: none;
        }
        .btn-outline-accent {
            border: 1px solid #2c3e66;
            color: #2c3e66;
            border-radius: 3rem;
            padding: 0.3rem 1.2rem;
            transition: all 0.2s;
        }
        .btn-outline-accent:hover {
            background: #2c3e66;
            color: white;
        }
        .btn-link-accent {
            color: #2c3e66;
            text-decoration: none;
            border-bottom: 1px dashed #2c3e66;
        }
        .btn-link-accent:hover {
            color: #1a2a44;
            border-bottom-style: solid;
        }
    </style>
@endpush
@section('content')
    {{-- Hero секция --}}
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold text-white">Создавай <span class="border-bottom border-3 border-warning">реальные IT‑проекты</span></h1>
                    <p class="lead text-white-50 mt-3 mb-4">Работай с наставником, пополняй портфолио и получай оффер в IT‑компанию</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5">Стать участником →</a>
                    @else
                        <a href="{{ route('catalog') }}" class="btn btn-light btn-lg rounded-pill px-5">Выбрать проект →</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    {{-- Статистика с анимацией и «разбегающимися» карточками --}}
    <div class="container mb-5">
        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-3 animate-float">
                    <h2 class="display-5 fw-bold text-primary mb-0 counter" data-target="{{ $totalProjects ?? 0 }}">0</h2>
                    <p class="text-muted">реализовано проектов</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-3 animate-float" style="animation-delay: 0.2s;">
                    <h2 class="display-5 fw-bold text-primary mb-0 counter" data-target="{{ $totalStudents ?? 0 }}">0</h2>
                    <p class="text-muted">студентов</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-3 animate-float" style="animation-delay: 0.4s;">
                    <h2 class="display-5 fw-bold text-success mb-0 counter" data-target="{{ $completedProjects ?? 0 }}">0</h2>
                    <p class="text-muted">успешно завершено</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card text-center p-3 animate-float" style="animation-delay: 0.6s;">
                    <h2 class="display-5 fw-bold text-warning mb-0">15+</h2>
                    <p class="text-muted">наставников</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Актуальные проекты (сетка без сдвигов) --}}
    <div class="container mb-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <h2 class="h2 mb-2">Актуальные проекты</h2>
            <a href="{{ route('catalog') }}" class="btn btn-outline-accent btn-sm">Все проекты →</a>
        </div>
        <div class="row g-4">
            @forelse($latestProjects ?? [] as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="project-card p-3 h-100">
                        <h5 class="card-title">{{ $project->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($project->description, 90) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="badge bg-primary rounded-pill">Сложность {{ $project->complexity }}/5</span>
                            <small class="text-muted">{{ Str::limit($project->tech_stack ?? '—', 25) }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-info">Проекты появятся скоро. Загляните позже!</div></div>
            @endforelse
        </div>
    </div>

    {{-- Лидеры рейтинга (асимметричный блок) --}}
    @if(isset($topStudents) && $topStudents->count())
        <div class="container mb-5">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                        <h2 class="h2 mb-2">Лидеры рейтинга <i class="bi bi-trophy-fill text-warning"></i></h2>
                        <a href="{{ route('leaderboard') }}" class="btn btn-link-accent">Весь рейтинг →</a>
                    </div>
                    <div>
                        @foreach($topStudents as $index => $student)
                            <div class="leader-item d-flex align-items-center gap-3">
                                <div class="flex-shrink-0">
                                    @if($student->avatar)
                                        <img src="{{ Storage::url($student->avatar) }}" width="45" height="45" class="rounded-circle">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ $student->name }}</strong>
                                    <div class="small text-muted">Рейтинг: {{ number_format($student->rating, 2) }}</div>
                                </div>
                                <div>
                                    @if($index == 0) <span class="badge bg-warning text-dark">🥇 1 место</span>
                                    @elseif($index == 1) <span class="badge bg-secondary">🥈 2 место</span>
                                    @elseif($index == 2) <span class="badge bg-danger">🥉 3 место</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Отзывы — «лесенкой» (асимметрично, но аккуратно) --}}
    <div class="container mb-5">
        <h2 class="h2 text-center mb-5">Отзывы участников</h2>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="testimonial-card zigzag-left" style="max-width: 90%;">
                    <i class="bi bi-quote fs-1 text-primary opacity-50"></i>
                    <p class="mt-2 fst-italic">“Благодаря Академии я получил первый опыт работы в команде и сразу трудоустроился в IT.”</p>
                    <div class="d-flex gap-3 align-items-center mt-3">
                        <i class="bi bi-person-circle fs-3"></i>
                        <div><strong>Алексей</strong><br><small>выпускник</small></div>
                    </div>
                </div>
                <div class="testimonial-card zigzag-right" style="max-width: 85%; margin-top: -1rem;">
                    <i class="bi bi-quote fs-1 text-primary opacity-50"></i>
                    <p class="mt-2 fst-italic">“Реальные проекты от НКО – возможность применить знания и помочь другим.”</p>
                    <div class="d-flex gap-3 align-items-center mt-3">
                        <i class="bi bi-person-circle fs-3"></i>
                        <div><strong>Мария</strong><br><small>студентка</small></div>
                    </div>
                </div>
                <div class="testimonial-card zigzag-left" style="max-width: 80%; margin-top: -1rem;">
                    <i class="bi bi-quote fs-1 text-primary opacity-50"></i>
                    <p class="mt-2 fst-italic">“Организация получила качественный продукт. Рекомендуем как заказчикам, так и разработчикам.”</p>
                    <div class="d-flex gap-3 align-items-center mt-3">
                        <i class="bi bi-building fs-3"></i>
                        <div><strong>Елена</strong><br><small>руководитель НКО</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Призыв --}}
    <div class="container mb-5">
        <div class="bg-dark text-white rounded-4 p-5 text-center" style="background: linear-gradient(120deg, #1a2a44, #2c3e66);">
            <h2 class="display-6 fw-bold">Готов начать свой путь в IT?</h2>
            <p class="lead mt-2 mb-4">Присоединяйся к сообществу молодых лидеров</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5">Зарегистрироваться →</a>
            @else
                <a href="{{ route('catalog') }}" class="btn btn-light btn-lg rounded-pill px-5">Выбрать проект →</a>
            @endguest
        </div>
    </div>

    <script>
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.target);
                    let current = 0;
                    const step = Math.ceil(target / 40);
                    const timer = setInterval(() => {
                        current += step;
                        if (current >= target) {
                            el.innerText = target;
                            clearInterval(timer);
                        } else {
                            el.innerText = current;
                        }
                    }, 25);
                    observer.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        counters.forEach(c => observer.observe(c));
    </script>
@endsection
