<?php

namespace App\Services;

use App\Models\StudentProject;
use Carbon\Carbon;

class GanttService
{
    /**
     * Получить задачи для диаграммы Ганта наставника.
     *
     * @param int $mentorId
     * @return array
     */
    public static function forMentor(int $mentorId): array
    {
        $studentProjects = StudentProject::whereHas('project', function ($q) use ($mentorId) {
            $q->where('mentor_id', $mentorId);
        })->with('student', 'project')->get();

        $tasks = [];
        foreach ($studentProjects as $sp) {
            $start = $sp->started_at ?? $sp->created_at;
            $end = $sp->deadline ?? Carbon::now()->addDays(7);

            $progress = match ($sp->status->value) {
                'completed' => 100,
                'sent_to_customer', 'ready_to_send' => 90,
                'review', 'revision' => 60,
                'in_progress' => 40,
                'new' => 10,
                default => 30,
            };

            $tasks[] = [
                'id' => $sp->id,
                'name' => $sp->project->title . ' — ' . $sp->student->name,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'progress' => $progress,
                'status' => $sp->status->label(),
            ];
        }

        return $tasks;
    }
}
