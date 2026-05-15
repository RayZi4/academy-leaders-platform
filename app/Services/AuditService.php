<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Запись действия в лог аудита.
     *
     * @param string $action        Например 'change_status', 'upload_file', 'assign_project'
     * @param string $entityType    Модель ('student_project', 'user', 'project')
     * @param int    $entityId      ID сущности
     * @param mixed  $oldValue      Старое значение (массив или null)
     * @param mixed  $newValue      Новое значение
     */
    public static function log(string $action, string $entityType, int $entityId, $oldValue = null, $newValue = null): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_value' => $oldValue ? json_encode($oldValue) : null,
            'new_value' => $newValue ? json_encode($newValue) : null,
        ]);
    }
}
