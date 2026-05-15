#!/usr/bin/env bash
cd /var/www/html
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
