<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\StudentProject;
use App\Services\AuditService;

class RunCodeLinter implements ShouldQueue
{
    use Queueable;

    protected $studentProject;
    protected $filePath;

    public function __construct(StudentProject $studentProject, $filePath)
    {
        $this->studentProject = $studentProject;
        $this->filePath = storage_path('app/public/' . $filePath);
    }

    public function handle(): void
    {
        if (!file_exists($this->filePath)) return;

        $ext = pathinfo($this->filePath, PATHINFO_EXTENSION);
        if ($ext === 'php') {
            $output = shell_exec("php -l " . escapeshellarg($this->filePath) . " 2>&1");
        } elseif ($ext === 'js') {
            $output = shell_exec("node -c " . escapeshellarg($this->filePath) . " 2>&1");
        } else {
            return;
        }

        if (str_contains($output, 'No syntax errors') === false) {
            $comment = $this->studentProject->mentor_comment ?? '';
            $this->studentProject->mentor_comment = $comment . "\n[Автопроверка]: " . $output;
            $this->studentProject->save();
        }

        AuditService::log('linter_check', 'student_project', $this->studentProject->id, null, ['result' => $output]);
    }
}
