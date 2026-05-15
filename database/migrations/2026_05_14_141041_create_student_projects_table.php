<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->enum('status', [
                'new', 'in_progress', 'review', 'revision',
                'ready_to_send', 'sent_to_customer', 'completed'
            ])->default('new');
            $table->date('deadline')->nullable();
            $table->integer('grade')->nullable(); // 1-5
            $table->text('mentor_comment')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_projects');
    }
};
