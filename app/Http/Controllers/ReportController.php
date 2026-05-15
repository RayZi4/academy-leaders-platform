<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function studentPdf(User $user)
    {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $user->id && auth()->user()->role !== 'mentor') {
            abort(403, 'Доступ запрещён.');
        }

        if ($user->role !== 'student') {
            abort(404, 'Пользователь не является студентом.');
        }

        $projects = $user->studentProjects()->with('project')->get();

        $pdf = Pdf::loadView('reports.student', compact('user', 'projects'));

        // Настройка для корректного отображения кириллицы
        $pdf->setOptions([
            'defaultFont' => 'dejavu sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('student_' . $user->id . '_report.pdf');
    }
}
