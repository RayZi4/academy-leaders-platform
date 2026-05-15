<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'default_tech_stack',
        'default_complexity',
        'default_deadline_days',
    ];

    protected $casts = [
        'default_complexity' => 'integer',
        'default_deadline_days' => 'integer',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'template_id');
    }
}
