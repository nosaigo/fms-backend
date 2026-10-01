FROM php:8.4-cli
# CACHE BUST v7 - 2026-10-01

RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev zip unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

EXPOSE 8080

CMD php artisan config:clear && \
    php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}