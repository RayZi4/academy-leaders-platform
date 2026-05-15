<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProjectController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;

Route::get('/ping', function () {
    return 'pong';
});
// Главные страницы (доступны всем, включая неавторизованных)
Route::get('/', [PageController::class, 'welcome'])->name('welcome');
Route::get('/catalog', [PageController::class, 'catalog'])->name('catalog');
Route::get('/leaderboard', [PageController::class, 'leaderboard'])->name('leaderboard');
Route::get('/about', function () {
    return view('about');
})->name('about');

// Временный маршрут для перенаправления после входа (Breeze)
Route::get('/dashboard', function () {
    return redirect()->route('catalog');
})->name('dashboard');

// Страница ожидания подтверждения для наставников/организаций
Route::get('/awaiting-approval', function () {
    return view('auth.awaiting-approval');
})->name('awaiting-approval')->middleware('auth');

// Группа для авторизованных и одобренных пользователей
Route::middleware(['auth', 'approved'])->group(function () {

    // Профиль (только просмотр)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/{user}', [ProfileController::class, 'showStudent'])->name('profile.student');

    // Студент: работа с проектами
    Route::post('/project/{project}/take', [StudentProjectController::class, 'takeProject'])->name('project.take');
    Route::get('/my-projects', [StudentProjectController::class, 'myProjects'])->name('my.projects')->middleware('role:student');
    Route::post('/student-project/{studentProject}/upload', [StudentProjectController::class, 'uploadVersion'])->name('version.upload');

    // Чат
    Route::get('/chat/{studentProject}', [MessageController::class, 'index'])->name('chat.index');
    Route::post('/chat/{studentProject}/send', [MessageController::class, 'send'])->name('chat.send');
    Route::patch('/chat/message/{message}', [MessageController::class, 'update'])->name('chat.message.update');
    Route::delete('/chat/message/{message}', [MessageController::class, 'destroy'])->name('chat.message.destroy');

    // Наставник и администратор
    Route::middleware(['role:mentor,admin'])->group(function () {
        Route::get('/mentor/profile', [MentorController::class, 'profile'])->name('mentor.profile');
        Route::get('/mentor/students', [MentorController::class, 'myStudents'])->name('mentor.students');
        Route::patch('/student-project/{studentProject}/status', [MentorController::class, 'changeStatus'])->name('mentor.status');
        Route::post('/student-project/{studentProject}/deadline', [MentorController::class, 'setDeadline'])->name('mentor.deadline');
        Route::get('/mentor/gantt', [PageController::class, 'gantt'])->name('mentor.gantt');
        Route::get('/gantt-data', [PageController::class, 'ganttData'])->name('gantt.data');
    });

    // Заказчик
    Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/projects', [CustomerController::class, 'myProjects'])->name('my-projects');
        Route::get('/projects/create', [CustomerController::class, 'create'])->name('create-project');
        Route::post('/projects', [CustomerController::class, 'store'])->name('store-project');
    });

    // Администратор
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/pending-registrations', [AdminController::class, 'pendingRegistrations'])->name('pending-registrations');
        Route::patch('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('approve-user');
        Route::delete('/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('reject-user');
        Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
        Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
        Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
        Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}', [AdminController::class, 'destroyProject'])->name('projects.destroy');
        Route::get('/pending-projects', [AdminController::class, 'pendingProjects'])->name('pending-projects');
        Route::patch('/projects/{project}/approve', [AdminController::class, 'approveProject'])->name('approve-project');
        Route::delete('/projects/{project}/reject', [AdminController::class, 'rejectProject'])->name('reject-project');
        Route::get('/audit', [AdminController::class, 'audit'])->name('audit');
    });

    // PDF-отчёт студента
    Route::get('/report/student/{user}/pdf', [ReportController::class, 'studentPdf'])->name('report.pdf');
});

// Редактирование профиля – доступно всем авторизованным (даже неодобренным)
Route::middleware(['auth'])->group(function () {
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Маршруты аутентификации (Laravel Breeze)
require __DIR__.'/auth.php';
