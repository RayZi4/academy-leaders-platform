FROM php:8.4-apache

# Устанавливаем системные зависимости и расширения PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && a2enmod rewrite

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем код проекта
COPY . .

# Устанавливаем зависимости Composer и кэшируем конфигурацию
RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Настраиваем права доступа для storage и cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Копируем скрипт запуска
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Открываем порт 80
EXPOSE 80

# Команда запуска
CMD ["/start.sh"]
