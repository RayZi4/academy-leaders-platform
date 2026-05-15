<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Отчёт студента</title>
    <style>
        body {
            font-family: 'dejavu sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        h1, h2 {
            color: #2c3e66;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #2c3e66;
            color: white;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
<h1>Академия молодых лидеров</h1>
<h2>Отчёт по проектам студента: {{ $user->name }}</h2>
<p>Email: {{ $user->email }} | Рейтинг: {{ $user->rating }}</p>
<table>
    <thead>
    <tr>
        <th>Название проекта</th>
        <th>Статус</th>
        <th>Оценка</th>
        <th>Дедлайн</th>
        <th>Дата завершения</th>
    </tr>
    </thead>
    <tbody>
    @foreach($projects as $sp)
        <tr>
            <td>{{ $sp->project->title }}</td>
            <td>{{ $sp->status->label() }}</td>
            <td>{{ $sp->grade ?? '—' }}</td>
            <td>{{ $sp->deadline?->format('d.m.Y') ?? '—' }}</td>
            <td>{{ $sp->completed_at?->format('d.m.Y') ?? '—' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="footer">
    Отчёт сгенерирован: {{ now()->format('d.m.Y H:i') }}
</div>
</body>
</html>
