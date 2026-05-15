<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "1. Checking vendor/autoload.php...\n";
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    die('vendor/autoload.php not found');
}
require __DIR__ . '/../vendor/autoload.php';
echo "OK\n";

echo "2. Creating application...\n";
$app = require __DIR__ . '/../bootstrap/app.php';
echo "OK\n";

echo "3. Checking config...\n";
echo "APP_DEBUG: " . (env('APP_DEBUG') ? 'true' : 'false') . "\n";
echo "APP_ENV: " . env('APP_ENV') . "\n";
echo "APP_KEY: " . (env('APP_KEY') ? 'set' : 'not set') . "\n";

echo "4. Attempting to create kernel and handle request...\n";
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
echo "OK\n";

echo "All checks passed.\n";
