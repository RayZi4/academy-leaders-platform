<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'project_id',
        'status',
        'deadline',
        'grade',
        'mentor_comment',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'deadline' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'status' => ProjectStatus::class,
    ];

    // Отношения
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function versions()
    {
        return $this->hasMany(ProjectVersion::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function ratingLogs()
    {
        return $this->hasMany(RatingLog::class);
    }

    // Проверка, просрочен ли дедлайн
    public function isOverdue(): bool
    {
        if (!$this->deadline) return false;
        return now()->startOfDay()->gt($this->deadline);
    }
}
