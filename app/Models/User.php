<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'telegram',
        'bio',
        'rating',
        'total_projects',
        'is_approved',
        'approved_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    // Отношения
    public function studentProjects()
    {
        return $this->hasMany(StudentProject::class, 'student_id');
    }

    public function mentorProjects()
    {
        return $this->hasMany(Project::class, 'mentor_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    // Проверки ролей
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isApproved(): bool
    {
        if ($this->isStudent() || $this->isAdmin()) {
            return true;
        }
        return (bool) $this->is_approved;
    }
    public function customerProjects()
    {
        return $this->hasMany(Project::class, 'customer_id');
    }
}
