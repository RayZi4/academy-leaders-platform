@extends('layout.app')
@section('title', 'Вход в аккаунт')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h2 class="mt-2">Добро пожаловать</h2>
                        <p class="text-muted">Войдите в свой аккаунт</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
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

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Запомнить меня</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Войти</button>
                        </div>

                        <div class="text-center mt-3">
                            <a class="text-decoration-none small" href="{{ route('password.request') }}">Забыли пароль?</a>
                            <span class="mx-1">|</span>
                            <a class="text-decoration-none small" href="{{ route('register') }}">Нет аккаунта? Регистрация</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
