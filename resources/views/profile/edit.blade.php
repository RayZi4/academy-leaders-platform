@extends('layout.app')
@section('title', 'Редактирование профиля')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Редактирование профиля</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 text-center">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle mb-2" width="100" height="100">
                            @else
                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:100px;height:100px;">
                                    <span class="text-white">Нет фото</span>
                                </div>
                            @endif
                            <div>
                                <label for="avatar" class="form-label">Изменить фото</label>
                                <input type="file" class="form-control" name="avatar" id="avatar" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="validateFileSize(this)">
                                <small class="text-muted">Максимальный размер: 2 МБ. Форматы: JPEG, PNG, GIF.</small>
                            </div>
                            @error('avatar')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        @if(!$user->isCustomer())
                            <div class="mb-3">
                                <label for="name" class="form-label">Имя</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label">Название организации</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                <small class="text-muted">Название организации нельзя изменить. Обратитесь к администратору.</small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">О себе / Описание</label>
                            <textarea class="form-control" name="bio" id="bio" rows="5">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile') }}" class="btn btn-secondary">Отмена</a>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateFileSize(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 2 * 1024 * 1024; // 2 MB
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Недопустимый формат файла. Разрешены: JPEG, PNG, GIF.');
                    input.value = '';
                    return;
                }
                if (file.size > maxSize) {
                    alert('Файл слишком большой. Максимальный размер 2 МБ.');
                    input.value = '';
                }
            }
        }
    </script>
@endsection
