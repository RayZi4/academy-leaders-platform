FROM thecodingmachine/laravel:php8.4-apache-node18

COPY . /app

RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache
