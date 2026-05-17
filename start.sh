#!/usr/bin/env bash
cd /var/www/html

echo "Setting permissions..."
touch /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# СОЗДАЁМ СИМВОЛИЧЕСКУЮ ССЫЛКУ ДЛЯ ПУБЛИЧНОГО ДОСТУПА К ФАЙЛАМ (аватарки)
echo "Creating storage link..."
php artisan storage:link || true

echo "Clearing and caching config..."
php artisan config:clear
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Starting Apache..."
apache2-foreground
