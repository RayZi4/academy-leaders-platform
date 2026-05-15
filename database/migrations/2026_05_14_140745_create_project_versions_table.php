<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_project_id')->constrained()->cascadeOnDelete();
            $table->integer('version_number');
            $table->string('file_path')->nullable();
            $table->string('repo_url')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_versions');
    }
};
