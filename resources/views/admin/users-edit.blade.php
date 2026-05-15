@extends('layout.app')
@section('title', 'Редактирование пользователя')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Редактирование пользователя: {{ $user->name }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Имя</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Роль</label>
                            <select name="role" class="form-control" required>
                                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Студент</option>
                                <option value="mentor" {{ $user->role == 'mentor' ? 'selected' : '' }}>Наставник</option>
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Заказчик</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Новый пароль (оставьте пустым, чтобы не менять)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Подтверждение пароля</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
