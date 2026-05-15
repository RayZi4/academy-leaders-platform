<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Artisan;

Artisan::call('db:seed', ['--class' => 'TestUsersSeeder', '--force' => true]);
echo Artisan::output();
