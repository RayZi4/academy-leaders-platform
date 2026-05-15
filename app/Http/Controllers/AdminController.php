<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\AuditLog;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ==================== УПРАВЛЕНИЕ ПОЛЬЗОВАТЕЛЯМИ ====================

    /**
     * Список всех пользователей
     */
    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Форма редактирования пользователя
     */
    public function editUser(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Обновление данных пользователя
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:student,mentor,customer,admin',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $oldData = $user->only(['name', 'email', 'role']);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        $newData = $user->only(['name', 'email', 'role']);

        AuditService::log('update_user', 'user', $user->id, $oldData, $newData);

        return redirect()->route('admin.users')->with('success', 'Пользователь обновлён.');
    }

    /**
     * Удаление пользователя
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Вы не можете удалить свою учётную запись.');
        }

        $userData = $user->only(['name', 'email', 'role']);
        $user->delete();

        AuditService::log('delete_user', 'user', $user->id, $userData, null);

        return redirect()->route('admin.users')->with('success', 'Пользователь удалён.');
    }

    // ==================== ПОДТВЕРЖДЕНИЕ РЕГИСТРАЦИЙ (НАСТАВНИКИ, ОРГАНИЗАЦИИ) ====================

    /**
     * Список заявок на регистрацию (неподтверждённые наставники и заказчики)
     */
    public function pendingRegistrations()
    {
        $users = User::whereIn('role', ['mentor', 'customer'])
            ->where('is_approved', false)
            ->get();
        return view('admin.pending-registrations', compact('users'));
    }

    /**
     * Одобрить регистрацию пользователя
     */
    public function approveUser(User $user)
    {
        $user->is_approved = true;
        $user->approved_at = now();
        $user->save();

        AuditService::log('approve_user_registration', 'user', $user->id, null, ['approved' => true]);

        return redirect()->route('admin.pending-registrations')->with('success', "Пользователь {$user->name} одобрен.");
    }

    /**
     * Отклонить регистрацию пользователя (удалить запись)
     */
    public function rejectUser(User $user)
    {
        $userData = $user->toArray();
        $user->delete();
        AuditService::log('reject_user_registration', 'user', $user->id, $userData, null);

        return redirect()->route('admin.pending-registrations')->with('success', "Пользователь {$userData['name']} отклонён и удалён.");
    }

    // ==================== УПРАВЛЕНИЕ ПРОЕКТАМИ ====================

    /**
     * Список всех проектов (для админ-панели)
     */
    public function projects()
    {
        $projects = Project::with('mentor')->paginate(20);
        return view('admin.projects', compact('projects'));
    }

    /**
     * Форма создания нового проекта
     */
    public function createProject()
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('admin.projects-create', compact('mentors'));
    }

    /**
     * Сохранение нового проекта (созданного админом)
     */
    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack' => 'nullable|string',
            'complexity' => 'required|integer|min:1|max:5',
            'mentor_id' => 'nullable|exists:users,id',
        ]);

        $project = Project::create($request->all());
        AuditService::log('create_project', 'project', $project->id, null, $project->toArray());

        return redirect()->route('admin.projects')->with('success', 'Проект создан.');
    }

    /**
     * Форма редактирования проекта
     */
    public function editProject(Project $project)
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('admin.projects-edit', compact('project', 'mentors'));
    }

    /**
     * Обновление данных проекта
     */
    public function updateProject(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tech_stack' => 'nullable|string',
            'complexity' => 'required|integer|min:1|max:5',
            'mentor_id' => 'nullable|exists:users,id',
        ]);

        $oldData = $project->toArray();
        $project->update($request->all());
        $newData = $project->toArray();

        AuditService::log('update_project', 'project', $project->id, $oldData, $newData);

        return redirect()->route('admin.projects')->with('success', 'Проект обновлён.');
    }

    /**
     * Удаление проекта
     */
    public function destroyProject(Project $project)
    {
        $projectData = $project->toArray();
        $project->delete();
        AuditService::log('delete_project', 'project', $project->id, $projectData, null);

        return redirect()->route('admin.projects')->with('success', 'Проект удалён.');
    }

    // ==================== МОДЕРАЦИЯ ПРОЕКТОВ ОТ ЗАКАЗЧИКОВ ====================

    /**
     * Список проектов, ожидающих подтверждения (от заказчиков)
     */
    public function pendingProjects()
    {
        $projects = Project::pending()->with('customer')->get();
        return view('admin.pending-projects', compact('projects'));
    }

    /**
     * Одобрить проект (сделать видимым для студентов)
     */
    public function approveProject(Project $project)
    {
        $project->approved = true;
        $project->save();

        AuditService::log('approve_project', 'project', $project->id, null, ['approved' => true]);

        return redirect()->route('admin.pending-projects')->with('success', 'Проект одобрен и доступен студентам.');
    }

    /**
     * Отклонить проект (удалить)
     */
    public function rejectProject(Project $project)
    {
        $projectData = $project->toArray();
        $project->delete();
        AuditService::log('reject_project', 'project', $project->id, $projectData, null);

        return redirect()->route('admin.pending-projects')->with('success', 'Проект отклонён и удалён.');
    }

    // ==================== АУДИТ ====================

    /**
     * Лог действий пользователей
     */
    public function audit()
    {
        $logs = AuditLog::with('user')->latest()->paginate(50);
        return view('admin.audit', compact('logs'));
    }
}
