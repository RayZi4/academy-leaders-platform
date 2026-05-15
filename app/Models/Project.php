<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'tech_stack',
        'complexity',
        'mentor_id',
        'customer_id',
        'template_id',
        'approved',
    ];

    protected $casts = [
        'complexity' => 'integer',
        'approved' => 'boolean',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function template()
    {
        return $this->belongsTo(ProjectTemplate::class, 'template_id');
    }

    public function studentProjects()
    {
        return $this->hasMany(StudentProject::class);
    }

    // Скоуп для одобренных проектов
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('approved', false);
    }
}
