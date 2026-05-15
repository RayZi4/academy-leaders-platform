@extends('layout.app')
@section('title', 'Регистрация')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus fs-1 text-primary"></i>
                        <h2 class="mt-2">Регистрация</h2>
                        <p class="text-muted">Присоединяйтесь к сообществу</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя / Название организации</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Регистрация как</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-badge-cc"></i></span>
                                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Студент</option>
                                    <option value="mentor" {{ old('role') == 'mentor' ? 'selected' : '' }}>Наставник</option>
                                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Организация / Заказчик</option>
                                </select>
                            </div>
                            @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key-fill"></i></span>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Зарегистрироваться</button>
                        </div>

                        <div class="text-center mt-3">
                            <a class="text-decoration-none small" href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
