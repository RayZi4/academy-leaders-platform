<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\StudentProject;
use App\Services\GanttService;

class PageController extends Controller
{
    // Главная страница
    public function welcome()
    {
        // Последние одобренные проекты (лимит 6)
        $latestProjects = Project::approved()->latest()->take(6)->get();

        // Топ-5 студентов по рейтингу
        $topStudents = User::where('role', 'student')
            ->orderBy('rating', 'desc')
            ->take(5)
            ->get();

        // Общая статистика
        $totalProjects = Project::approved()->count();
        $totalStudents = User::where('role', 'student')->count();
        $completedProjects = StudentProject::where('status', 'completed')->count();

        return view('welcome', compact('latestProjects', 'topStudents', 'totalProjects', 'totalStudents', 'completedProjects'));
    }

    public function catalog()
    {
        $projects = Project::approved()
            ->whereDoesntHave('studentProjects', function ($q) {
                if (auth()->check()) {
                    $q->where('student_id', auth()->id());
                }
            })
            ->take(12)
            ->get();

        return view('catalog', compact('projects'));
    }

    public function leaderboard()
    {
        $students = User::where('role', 'student')
            ->orderBy('rating', 'desc')
            ->take(10)
            ->get();

        return view('leaderboard', compact('students'));
    }

    public function gantt()
    {
        $tasks = GanttService::forMentor(auth()->id());
        return view('mentor.gantt', compact('tasks'));
    }

    public function ganttData()
    {
        $tasks = GanttService::forMentor(auth()->id());
        return response()->json($tasks);
    }
}
