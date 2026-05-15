<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class StatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $studentProject;

    public function __construct($studentProject)
    {
        $this->studentProject = $studentProject;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Статус проекта изменён',
            'message' => 'Проект "' . $this->studentProject->project->title . '" теперь: ' . $this->studentProject->status->label(),
            'url' => route('my.projects'),
        ];
    }
}
