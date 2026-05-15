<?php

namespace App\Http\Controllers;

use App\Models\StudentProject;
use App\Services\RatingService;
use App\Services\AuditService;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    // Список студентов с проектами (таблица)
    public function myStudents()
    {
        $mentor = auth()->user();
        $students = StudentProject::whereHas('project', function ($q) use ($mentor) {
            $q->where('mentor_id', $mentor->id);
        })->with('student', 'project')->get();

        return view('mentor.students', compact('students'));
    }

    // Профиль наставника со статистикой
    public function profile()
    {
        $mentor = auth()->user();
        $students = StudentProject::whereHas('project', function ($q) use ($mentor) {
            $q->where('mentor_id', $mentor->id);
        })->with('student', 'project')->get();

        $uniqueStudents = $students->pluck('student')->unique('id');
        $totalStudents = $uniqueStudents->count();
        $totalProjects = $students->count();
        $completedProjects = $students->filter(function ($sp) {
            return $sp->status->value === 'completed';
        })->count();

        return view('mentor.profile', compact('mentor', 'students', 'totalStudents', 'totalProjects', 'completedProjects'));
    }

    // Изменение статуса и оценки проекта студента
    public function changeStatus(Request $request, StudentProject $studentProject)
    {
        $user = auth()->user();
        $isMentor = ($user->id === $studentProject->project->mentor_id);
        $isAdmin = $user->isAdmin();

        if (!($isMentor || $isAdmin)) {
            abort(403, 'У вас нет прав для изменения статуса этого проекта.');
        }

        $request->validate([
            'status' => 'required|in:' . implode(',', array_column(ProjectStatus::cases(), 'value')),
            'grade' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $oldStatus = $studentProject->status->value;
        $newStatus = ProjectStatus::from($request->status);
        $studentProject->status = $newStatus;

        // ВАЖНО: сохраняем оценку, даже если она равна 0 или пустая строка
        $grade = $request->input('grade');
        if ($grade !== null && $grade !== '') {
            $studentProject->grade = (int)$grade;
        }

        if ($newStatus === ProjectStatus::COMPLETED && !$studentProject->completed_at) {
            $studentProject->completed_at = now();
        }

        if ($request->filled('comment')) {
            $studentProject->mentor_comment = $request->comment;
        }

        $studentProject->save();

        // ВСЕГДА пересчитываем рейтинг при изменении статуса или оценки
        RatingService::recalcStudent($studentProject->student);

        AuditService::log('change_status', 'student_project', $studentProject->id,
            ['status' => $oldStatus], ['status' => $newStatus->value, 'grade' => $studentProject->grade, 'comment' => $studentProject->mentor_comment]);

        return back()->with('success', 'Статус, оценка и комментарий сохранены.');
    }

    // Установка дедлайна
    public function setDeadline(Request $request, StudentProject $studentProject)
    {
        $user = auth()->user();
        $isMentor = ($user->id === $studentProject->project->mentor_id);
        $isAdmin = $user->isAdmin();

        if (!($isMentor || $isAdmin)) {
            abort(403, 'У вас нет прав для установки дедлайна.');
        }

        $request->validate(['deadline' => 'required|date|after:today']);
        $studentProject->deadline = $request->deadline;
        $studentProject->save();

        AuditService::log('set_deadline', 'student_project', $studentProject->id, null, ['deadline' => $request->deadline]);

        return back()->with('success', 'Дедлайн установлен.');
    }
    public function leaderboard()
    {
        $students = User::where('role', 'student')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();

        // Для каждого студента подсчитываем количество завершённых проектов
        foreach ($students as $student) {
            $student->completed_count = StudentProject::where('student_id', $student->id)
                ->where('status', 'completed')
                ->count();
        }

        return view('leaderboard', compact('students'));
    }
}
