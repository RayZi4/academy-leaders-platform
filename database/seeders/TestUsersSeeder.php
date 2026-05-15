<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\StudentProject;
use App\Enums\ProjectStatus;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание студента
        $student = User::create([
            'name' => 'Студент Петров',
            'email' => 'student@test.ru',
            'password' => Hash::make('12345678'),
            'role' => 'student',
            'rating' => 0,
            'total_projects' => 0,
        ]);

        // Создание наставника
        $mentor = User::create([
            'name' => 'Наставник Иванов',
            'email' => 'mentor@test.ru',
            'password' => Hash::make('12345678'),
            'role' => 'mentor',
            'rating' => 0,
            'total_projects' => 0,
        ]);

        // Создание администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@test.ru',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'rating' => 0,
            'total_projects' => 0,
        ]);

        // Создание заказчика (опционально)
        User::create([
            'name' => 'Заказчик ООО "Ромашка"',
            'email' => 'customer@test.ru',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'rating' => 0,
            'total_projects' => 0,
        ]);

        // Создание проекта
        $project = Project::create([
            'title' => 'Разработка системы управления заявками',
            'description' => 'Создать веб-приложение для автоматизации заявок студентов',
            'tech_stack' => 'PHP, Laravel, SQLite, Bootstrap',
            'complexity' => 3,
            'mentor_id' => $mentor->id,
            'customer_id' => null,
            'template_id' => null,
        ]);

        // Назначение проекта студенту
        StudentProject::create([
            'student_id' => $student->id,
            'project_id' => $project->id,
            'status' => ProjectStatus::IN_PROGRESS,
            'deadline' => now()->addDays(14),
            'grade' => null,
            'mentor_comment' => null,
            'started_at' => now(),
            'completed_at' => null,
        ]);

        // Можно добавить второй проект
        $project2 = Project::create([
            'title' => 'Чат-бот для отдела кадров',
            'description' => 'Telegram-бот для ответов на частые вопросы',
            'tech_stack' => 'Python, Aiogram, SQLite',
            'complexity' => 2,
            'mentor_id' => $mentor->id,
            'customer_id' => null,
            'template_id' => null,
        ]);

        StudentProject::create([
            'student_id' => $student->id,
            'project_id' => $project2->id,
            'status' => ProjectStatus::NEW,
            'deadline' => now()->addDays(21),
            'grade' => null,
            'mentor_comment' => null,
            'started_at' => null,
            'completed_at' => null,
        ]);
    }
}
