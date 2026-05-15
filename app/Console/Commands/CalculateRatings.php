<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\RatingService;

class CalculateRatings extends Command
{
    protected $signature = 'ratings:calculate';
    protected $description = 'Пересчитать рейтинг всех студентов';

    public function handle()
    {
        $students = User::where('role', 'student')->get();
        foreach ($students as $student) {
            RatingService::recalcStudent($student);
        }
        $this->info('Рейтинг пересчитан для ' . $students->count() . ' студентов.');
    }
}
