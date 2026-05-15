<?php

namespace App\Services;

use App\Models\User;
use App\Models\StudentProject;
use App\Models\RatingLog;

class RatingService
{
    /**
     * Пересчитать рейтинг студента на основе всех его завершённых проектов.
     */
    public static function recalcStudent(User $student): float
    {
        $projects = StudentProject::where('student_id', $student->id)
            ->whereNotNull('grade')
            ->with('project')
            ->get();

        if ($projects->isEmpty()) {
            $student->rating = 0;
            $student->total_projects = 0;
            $student->save();
            return 0;
        }

        $total = 0;
        foreach ($projects as $sp) {
            $complexity = $sp->project->complexity;
            $grade = $sp->grade;
            // Бонус за соблюдение дедлайна (если завершён вовремя)
            $deadlineBonus = ($sp->deadline && $sp->completed_at && $sp->completed_at <= $sp->deadline) ? 1 : 0;
            $score = $complexity * $grade * (0.8 + 0.2 * $deadlineBonus);
            $total += $score;
        }

        $rating = round($total / $projects->count(), 2);
        $student->rating = $rating;
        $student->total_projects = $projects->count();
        $student->save();

        return $rating;
    }

    /**
     * Добавить (или вычесть) очки рейтинга с записью причины.
     */
    public static function addPoints(User $student, StudentProject $project, int $points, string $reason): void
    {
        RatingLog::create([
            'student_id' => $student->id,
            'student_project_id' => $project->id,
            'points_change' => $points,
            'reason' => $reason,
        ]);

        $student->rating += $points;
        $student->save();
    }
}
