<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_project_id',
        'points_change',
        'reason',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function studentProject()
    {
        return $this->belongsTo(StudentProject::class);
    }
}
