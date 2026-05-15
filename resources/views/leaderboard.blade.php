@extends('layout.app')
@section('title', 'Рейтинг студентов')
@section('content')
    <h1 class="mb-4"><i class="bi bi-trophy-fill text-warning"></i> Топ-10 студентов по рейтингу</h1>

    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr>
                <th>Место</th>
                <th>Студент</th>
                <th>Email</th>
                <th>Рейтинг</th>
                <th>Завершено проектов</th>
                <th>Детали</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td style="width: 80px;">
                        @if($index == 0)
                            <span class="badge bg-warning text-dark">🥇 1 место</span>
                        @elseif($index == 1)
                            <span class="badge bg-secondary">🥈 2 место</span>
                        @elseif($index == 2)
                            <span class="badge bg-danger">🥉 3 место</span>
                        @else
                            <span class="badge bg-light text-dark">{{ $index+1 }} место</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($student->avatar)
                                <img src="{{ Storage::url($student->avatar) }}" width="35" height="35" class="rounded-circle">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width:35px;height:35px;">
                                    <i class="bi bi-person text-white"></i>
                                </div>
                            @endif
                            <span>{{ $student->name }}</span>
                        </div>
                    </td>
                    <td>{{ $student->email }}</td>
                    <td><strong>{{ number_format($student->rating, 2) }}</strong></td>
                    <td>{{ $student->completed_count ?? 0 }}</td>
                    <td>
                        <a href="{{ route('profile.student', $student) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-eye"></i> Профиль
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if($students->isEmpty())
        <div class="alert alert-info text-center">Пока нет студентов в рейтинге.</div>
    @endif
@endsection
