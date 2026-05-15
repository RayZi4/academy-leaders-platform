@extends('layout.app')
@section('title', 'Заявки на регистрацию')
@section('content')
    <h1 class="mb-3"><i class="bi bi-person-plus-fill text-primary"></i> Заявки на регистрацию</h1>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr><th>ID</th><th>Имя / Организация</th><th>Email</th><th>Роль</th><th>Дата регистрации</th><th>Действия</th></tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role === 'mentor' ? 'Наставник' : 'Организация' }}</td>
                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <form action="{{ route('admin.approve-user', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="btn btn-outline-success"><i class="bi bi-check-lg"></i> Одобрить</button>
                            </form>
                            <form action="{{ route('admin.reject-user', $user) }}" method="POST" onsubmit="return confirm('Отклонить?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger"><i class="bi bi-x-lg"></i> Отклонить</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Нет новых заявок.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
