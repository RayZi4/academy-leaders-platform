@extends('layout.app')
@section('title', 'О нас')
@push('styles')
    <style>
        /* --- Common Styles (unchanged) --- */
        .hero-about {
            background: linear-gradient(105deg, #1a2a44 0%, #2c3e66 100%);
            border-radius: 2rem;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }
        .hero-about::after {
            content: "✨";
            font-size: 10rem;
            position: absolute;
            bottom: -40px;
            right: -20px;
            opacity: 0.1;
            pointer-events: none;
        }
        .mission-card {
            background: white;
            border-radius: 2rem;
            padding: 2rem;
            height: 100%;
            transition: all 0.2s;
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.03);
        }
        .mission-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -10px rgba(0,0,0,0.08);
        }
        .value-item {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 1.5rem;
            transition: all 0.2s;
        }
        .value-item:hover {
            background: #f8fafc;
            transform: translateY(-3px);
        }
        .partner-item {
            background: white;
            border-radius: 1.25rem;
            padding: 1rem;
            transition: all 0.2s;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .partner-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        .section-title {
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            text-align: center;
        }
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #1a2a44, #2c3e66);
            border-radius: 3px;
        }
        .partner-category {
            margin-top: 2rem;
        }
        .partner-category h4 {
            border-left: 4px solid #2c3e66;
            padding-left: 1rem;
            margin-bottom: 1.5rem;
        }
        .project-card-link {
            text-decoration: none;
            transition: all 0.2s;
            display: block;
        }
        .project-card-link:hover {
            transform: translateY(-4px);
        }
        .project-card-link .project-card {
            height: 100%;
            transition: all 0.2s;
        }
        .project-card-link:hover .project-card {
            box-shadow: 0 15px 30px -10px rgba(0,0,0,0.1);
        }
        /* Новые стили для блока "Контакты" */
        .contacts-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        .contact-card {
            background: white;
            border-radius: 1.25rem;
            padding: 1.25rem;
            width: 240px;
            text-align: center;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }
        .contact-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1);
        }
        .contact-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
        }
        .contact-role {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.75rem;
        }
        .contact-vk-link {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.85rem;
            color: #2c3e66;
            text-decoration: none;
            border-bottom: 1px dashed #2c3e66;
            margin-top: 0.5rem;
        }
        .contact-vk-link:hover {
            color: #1a2a44;
            border-bottom-style: solid;
        }
    </style>
@endpush
@section('content')
    <div class="hero-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold text-white">О нас</h1>
                    <p class="lead text-white-50 mt-3">Автономная некоммерческая организация<br>«Центр общественно-значимых молодёжных инициатив "Академия молодых лидеров"»</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mission-card">
                    <i class="bi bi-star-fill fs-1 text-warning"></i>
                    <h3 class="mt-3">Наша миссия</h3>
                    <p class="text-muted">Создавать среду, в которой талантливые студенты могут реализовать свои IT-проекты под руководством опытных наставников, получая реальный опыт и портфолио для успешного старта карьеры.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mission-card">
                    <i class="bi bi-eye fs-1 text-primary"></i>
                    <h3 class="mt-3">Наше видение</h3>
                    <p class="text-muted">Стать ведущей платформой в России, связывающей молодых разработчиков, наставников и социально значимые проекты, способствуя цифровому развитию НКО и бизнеса.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light rounded-4 p-4 mb-5">
        <div class="container">
            <h2 class="text-center mb-4">Наши ценности</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="value-item">
                        <i class="bi bi-people-fill fs-1 text-primary"></i>
                        <h4 class="mt-2">Открытость</h4>
                        <p class="text-muted">Мы открыты для всех студентов, независимо от уровня подготовки.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-item">
                        <i class="bi bi-chat-dots-fill fs-1 text-primary"></i>
                        <h4 class="mt-2">Наставничество</h4>
                        <p class="text-muted">Каждый студент получает поддержку опытного IT-специалиста.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="value-item">
                        <i class="bi bi-briefcase-fill fs-1 text-primary"></i>
                        <h4 class="mt-2">Результат</h4>
                        <p class="text-muted">Мы помогаем создавать реальные продукты, которые меняют мир.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Партнёры и сотрудничество (без изменений) -->
    <div class="container mb-5">
        <div class="section-title">
            <h2>Партнёры и сотрудничество</h2>
        </div>

        <div class="partner-category">
            <h4>Образовательные и общественные партнёры</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-building me-2 text-primary"></i> НГЛУ им. Н.А. Добролюбова<br><small class="text-muted">Организация совместных проектов</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-building me-2 text-primary"></i> ННГУ им. Н.И. Лобачевского<br><small class="text-muted">Партнёрство в научных и студенческих инициативах</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-building me-2 text-primary"></i> РАНХиГС<br><small class="text-muted">Участие в совместных проектах</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-building me-2 text-primary"></i> НГТУ им. Р.Е. Алексеева<br><small class="text-muted">Сотрудничество в разработке</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-building me-2 text-primary"></i> Нижегородский радиотехнический колледж<br><small class="text-muted">Участие в форумах и карьерных мероприятиях</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-building me-2 text-primary"></i> Молодая Гвардия Единой России<br><small class="text-muted">Совместные проекты и мероприятия</small></div></div>
            </div>
        </div>

        <div class="partner-category">
            <h4>Государственные и властные структуры</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-bank me-2 text-primary"></i> Министерство молодёжной политики Нижегородской области<br><small class="text-muted">Информационная и организационная поддержка</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-bank me-2 text-primary"></i> Управление по труду и занятости населения<br><small class="text-muted">Помощь в трудоустройстве и карьерное консультирование</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-bank me-2 text-primary"></i> Администрация г. Нижнего Новгорода<br><small class="text-muted">Сотрудничество в рамках городских программ</small></div></div>
            </div>
        </div>

        <div class="partner-category">
            <h4>IT и бизнес-партнёры</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-laptop me-2 text-primary"></i> АО «Вектор развития»<br><small class="text-muted">Реализация совместных проектов, IT-разработки</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-laptop me-2 text-primary"></i> ООО «Юнилевер Русь»<br><small class="text-muted">Интеллектуальная поддержка и менторство</small></div></div>
            </div>
        </div>

        <div class="partner-category">
            <h4>Студенческое сообщество</h4>
            <div class="row g-3">
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-mortarboard me-2 text-primary"></i> НИУ ВШЭ<br><small class="text-muted">Участие в образовательных программах</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-mortarboard me-2 text-primary"></i> МГУ<br><small class="text-muted">Совместные мероприятия и программы</small></div></div>
                <div class="col-md-4"><div class="partner-item"><i class="bi bi-mortarboard me-2 text-primary"></i> Нижегородский колледж малого бизнеса<br><small class="text-muted">Участие в мероприятиях</small></div></div>
            </div>
        </div>
    </div>

    <!-- Наши проекты (без ссылок) -->
    <div class="bg-white rounded-4 p-4 mb-5">
        <div class="container">
            <div class="section-title">
                <h2>Наши проекты</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4"><div class="text-center p-3 project-card"><i class="bi bi-laptop fs-1 text-primary"></i><h5 class="mt-3">IT-мастерская</h5><p class="text-muted">Разработка сайтов, интернет-магазинов, технологических платформ для мероприятий.</p></div></div>
                <div class="col-md-4"><div class="text-center p-3 project-card"><i class="bi bi-newspaper fs-1 text-primary"></i><h5 class="mt-3">Журнал «Мой Нижний»</h5><p class="text-muted">Медиа для сообщества: статьи о студентах, анонсы мероприятий.</p></div></div>
                <div class="col-md-4"><div class="text-center p-3 project-card"><i class="bi bi-briefcase fs-1 text-primary"></i><h5 class="mt-3">Карьерный хаб</h5><p class="text-muted">Трудоустройство выпускников, стажировки, карьерные мероприятия.</p></div></div>
                <div class="col-md-4"><div class="text-center p-3 project-card"><i class="bi bi-graph-up fs-1 text-primary"></i><h5 class="mt-3">Лаборатория «Грант-драйв»</h5><p class="text-muted">Поиск финансирования, поддержка мероприятий и образовательных программ.</p></div></div>
                <div class="col-md-4"><div class="text-center p-3 project-card"><i class="bi bi-palette fs-1 text-primary"></i><h5 class="mt-3">Креативное бюро «АМЛ Production»</h5><p class="text-muted">Дизайн, реклама, разработка концепций мероприятий.</p></div></div>
                <div class="col-md-4"><div class="text-center p-3 project-card"><i class="bi bi-cup-straw fs-1 text-primary"></i><h5 class="mt-3">Клуб «Молодой парламентарий»</h5><p class="text-muted">Практические переговоры, деловые игры, развитие коммуникаций.</p></div></div>
            </div>
        </div>
    </div>

    <!-- --- НОВЫЙ БЛОК "КОНТАКТЫ" (вместо руководства) --- -->
    <div class="container mb-5">
        <div class="section-title">
            <h2>Контакты</h2>
        </div>
        <div class="contacts-grid">
            <!-- Александр Коннов -->
            <div class="contact-card">
                <div class="contact-name">Александр Коннов</div>
                <div class="contact-role">Руководитель Академии Молодых Лидеров</div>
                <a href="https://vk.com/polagart" target="_blank" rel="noopener noreferrer" class="contact-vk-link">
                    <i class="bi bi-vk"></i> <span>ВКонтакте</span>
                </a>
            </div>
            <!-- Петр Панов -->
            <div class="contact-card">
                <div class="contact-name">Петр Панов</div>
                <div class="contact-role">Первый заместитель руководителя Академии</div>
                <a href="https://vk.com/petr_beast" target="_blank" rel="noopener noreferrer" class="contact-vk-link">
                    <i class="bi bi-vk"></i> <span>ВКонтакте</span>
                </a>
            </div>
            <!-- Ольга Китаева -->
            <div class="contact-card">
                <div class="contact-name">Ольга Китаева</div>
                <div class="contact-role">Работа с партнерами и внешними связями Академии</div>
                <a href="https://vk.com/o.kitaeva" target="_blank" rel="noopener noreferrer" class="contact-vk-link">
                    <i class="bi bi-vk"></i> <span>ВКонтакте</span>
                </a>
            </div>
            <!-- Дарья Ермакова -->
            <div class="contact-card">
                <div class="contact-name">Дарья Ермакова</div>
                <div class="contact-role">PR менеджер проекта</div>
                <a href="https://vk.com/darya_ermakova" target="_blank" rel="noopener noreferrer" class="contact-vk-link">
                    <i class="bi bi-vk"></i> <span>ВКонтакте</span>
                </a>
            </div>
        </div>
    </div>

@endsection
