<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\StudentProject;
use App\Models\ProjectVersion;
use App\Services\RatingService;
use App\Services\AuditService;
use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProjectController extends Controller
{
    // Список проектов текущего студента
    public function myProjects()
    {
        $projects = Auth::user()->studentProjects()->with('project')->get();
        return view('my_projects', compact('projects'));
    }

    // Взять проект
    public function takeProject(Project $project)
    {
        $student = Auth::user();
        if (!$student->isStudent()) {
            abort(403, 'Только студенты могут брать проекты.');
        }

        $existing = StudentProject::where('student_id', $student->id)
            ->where('project_id', $project->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Вы уже взяли этот проект.');
        }

        $studentProject = StudentProject::create([
            'student_id' => $student->id,
            'project_id' => $project->id,
            'status' => ProjectStatus::NEW,
            'started_at' => now(),
        ]);

        AuditService::log('assign_project', 'student_project', $studentProject->id, null, ['project_id' => $project->id]);
        return redirect()->route('my.projects')->with('success', 'Проект успешно взят!');
    }

    // Загрузка новой версии проекта
    public function uploadVersion(Request $request, StudentProject $studentProject)
    {
        // Проверка прав: студент может загружать только свои проекты
        $user = Auth::user();
        $isStudent = ($user->id === $studentProject->student_id);
        $isMentor = ($user->id === $studentProject->project->mentor_id);
        $isAdmin = $user->isAdmin();

        if (!($isStudent || $isMentor || $isAdmin)) {
            abort(403, 'У вас нет прав для загрузки версии этого проекта.');
        }

        $request->validate([
            'file' => 'nullable|file|max:20480',
            'repo_url' => 'nullable|url',
            'comment' => 'nullable|string'
        ]);

        $versionNumber = $studentProject->versions()->max('version_number') + 1;

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('project_versions', 'public');
        }

        ProjectVersion::create([
            'student_project_id' => $studentProject->id,
            'version_number' => $versionNumber,
            'file_path' => $path,
            'repo_url' => $request->repo_url,
            'comment' => $request->comment,
        ]);

        // Если проект был в статусе "new" или "revision" – переводим в "in_progress"
        if (in_array($studentProject->status, [ProjectStatus::NEW, ProjectStatus::REVISION])) {
            $studentProject->status = ProjectStatus::IN_PROGRESS;
            $studentProject->save();
        }

        AuditService::log('upload_version', 'project_version', $studentProject->id, null, ['version' => $versionNumber]);

        return back()->with('success', 'Версия загружена.');
    }
}
