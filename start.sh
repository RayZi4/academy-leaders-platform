#!/usr/bin/env bash
cd /var/www/html

echo "Creating avatar directory and setting permissions..."
mkdir -p storage/app/public/avatars
chmod -R 777 storage bootstrap/cache

echo "Creating storage link..."
php artisan storage:link || true

echo "Clearing config cache..."
php artisan config:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Starting Apache..."
apache2-foreground
