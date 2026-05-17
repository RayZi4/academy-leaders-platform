<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Академия молодых лидеров')</title>
    <!-- Bootstrap 5 + иконки -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2c3e66;
            --primary-dark: #1a2a44;
            --secondary: #f4a261;
            --light-bg: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #1e293b;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        /* Навбар */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        .nav-link {
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .nav-link:hover {
            opacity: 0.8;
        }
        /* Карточки */
        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 2rem;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .btn-outline-primary {
            border-radius: 2rem;
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        /* Таблицы */
        .table-responsive-custom {
            overflow-x: auto;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
        }
        .table-custom {
            width: 100%;
            background: white;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }
        .table-custom thead th {
            background: var(--primary);
            color: white;
            font-weight: 600;
            padding: 0.9rem 1rem;
            border-bottom: none;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
        }
        .table-custom tbody tr {
            transition: background 0.2s;
        }
        .table-custom tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .table-custom tbody tr:hover {
            background-color: #f1f5f9;
        }
        .table-custom td {
            padding: 0.9rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #eef2f6;
            color: #1e293b;
        }
        .table-custom td:first-child {
            border-left: 3px solid transparent;
        }
        .table-custom tr:hover td:first-child {
            border-left-color: var(--secondary);
        }
        @media (max-width: 768px) {
            .table-custom thead th,
            .table-custom td {
                padding: 0.6rem 0.8rem;
                font-size: 0.85rem;
            }
            .table-custom {
                font-size: 0.85rem;
            }
        }
        /* Бейджи */
        .badge {
            font-size: 0.8rem;
            font-weight: 500;
            padding: 0.35em 0.8em;
            border-radius: 2rem;
        }
        .bg-secondary {
            background-color: #94a3b8 !important;
        }
        /* Формы */
        .form-control, .form-select {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(44, 62, 102, 0.2);
        }
        .input-group-text {
            border-radius: 0.75rem 0 0 0.75rem;
            background-color: #f1f5f9;
        }
        /* Футер */
        footer {
            background: #1e293b;
            color: #94a3b8;
            margin-top: 3rem;
            padding: 2rem 0 1rem;
            font-size: 0.9rem;
        }
        footer a {
            color: #cbd5e1;
            text-decoration: none;
        }
        footer a:hover {
            color: white;
        }
        /* Адаптивные отступы */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            h1 {
                font-size: 1.8rem;
            }
            .card-title {
                font-size: 1.2rem;
            }
        }
        /* Карусель на главной */
        .carousel-item .bg-gradient {
            border-radius: 1.5rem;
        }
    </style>
    @stack('styles')
</head>
<body>
@include('layout.navbar')
<main class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @yield('content')
</main>
@include('layout.footer')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
