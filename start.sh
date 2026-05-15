#!/usr/bin/env bash
cd /var/www/html

echo "Setting permissions..."
touch /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Clearing config cache..."
php artisan config:clear

echo "Running migrations..."
php artisan migrate --force

echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
apache2-foreground
