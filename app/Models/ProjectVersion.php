<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_project_id',
        'version_number',
        'file_path',
        'repo_url',
        'comment',
    ];

    public function studentProject()
    {
        return $this->belongsTo(StudentProject::class);
    }
}
