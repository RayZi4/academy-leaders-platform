<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$commands = ['route:clear', 'config:clear', 'view:clear', 'cache:clear'];
foreach ($commands as $cmd) {
    $app->make(Illuminate\Contracts\Console\Kernel::class)->call($cmd);
    echo "Executed $cmd\n";
}
echo "All caches cleared. Now try the main site.";
