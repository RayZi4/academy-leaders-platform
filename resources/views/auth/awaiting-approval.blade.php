@extends('layout.app')
@section('title', 'Ожидание подтверждения')
@section('content')
    <div class="container text-center mt-5">
        <div class="card">
            <div class="card-body">
                <h1>Ваша учётная запись ожидает подтверждения</h1>
                <p class="lead">Спасибо за регистрацию. Администратор проверит ваши данные и активирует аккаунт в ближайшее время.</p>
                <p>Вы получите уведомление на email после принятия решения.</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Выйти</button>
                </form>
            </div>
        </div>
    </div>
@endsection
