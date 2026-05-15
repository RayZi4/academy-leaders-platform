@extends('layout.app')
@section('title', 'Лог аудита')
@section('content')
    <h1 class="mb-4"><i class="bi bi-journal-text text-primary"></i> Лог аудита</h1>

    <div class="table-responsive-custom">
        <table class="table-custom">
            <thead>
            <tr>
                <th>Пользователь</th>
                <th>Действие</th>
                <th>Сущность</th>
                <th>Изменения</th>
                <th>Время</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>
                        {{ htmlspecialchars($log->user?->name ?? 'Система') }}
                        <small class="text-muted">({{ htmlspecialchars($log->user?->role ?? '') }})</small>
                    </td>
                    <td>{{ htmlspecialchars(str_replace('_', ' ', $log->action)) }}
                    <td>{{ htmlspecialchars($log->entity_type . ':' . $log->entity_id) }}
                    <td>
                        @php
                            $old = $log->old_value ? json_decode($log->old_value, true) : null;
                            $new = $log->new_value ? json_decode($log->new_value, true) : null;
                            $changes = [];
                            if ($old && $new) {
                                foreach ($new as $key => $value) {
                                    $oldValue = $old[$key] ?? null;
                                    if ($oldValue != $value) {
                                        $cleanKey = htmlspecialchars($key);
                                        $cleanOld = htmlspecialchars($oldValue ?? '');
                                        $cleanNew = htmlspecialchars($value ?? '');
                                        $changes[] = "$cleanKey: было \"$cleanOld\", стало \"$cleanNew\"";
                                    }
                                }
                            } elseif ($new && !$old) {
                                $changes[] = 'Создано';
                            } elseif ($old && !$new) {
                                $changes[] = 'Удалено';
                            }
                        @endphp
                        @if(count($changes) > 0)
                            <div style="max-width: 300px; white-space: normal; word-break: break-word;">
                                {{ implode('; ', array_slice($changes, 0, 3)) }}
                                @if(count($changes) > 3)
                                    <span class="text-muted">(и ещё {{ count($changes) - 3 }})</span>
                                @endif
                            </div>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $log->created_at->format('d.m.Y H:i:s') }}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $logs->links() }}
    </div>
@endsection
