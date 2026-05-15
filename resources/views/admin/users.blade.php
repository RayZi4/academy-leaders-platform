@extends('layout.app')
@section('title', 'Управление пользователями')
@section('content')
    <h1 class="mb-3"><i class="bi bi-people-fill text-primary"></i> Пользователи</h1>
    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}
                    <td>{{ htmlspecialchars($user->name) }}
                    <td>{{ htmlspecialchars($user->email) }}
                    <td>{{ $user->role }}
                    <td>
                        @if($user->is_approved)
                            <span class="badge bg-success">Одобрен</span>
                        @else
                            <span class="badge bg-warning text-dark">Ожидает</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Редактировать
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Удалить пользователя?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $users->links() }}
    </div>
@endsection
