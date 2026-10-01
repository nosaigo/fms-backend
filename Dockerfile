FROM php:8.4-cli
# CACHE BUST v6 - 2026-10-01

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Create required directories and set permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && \
    chmod -R 777 storage bootstrap/cache

EXPOSE 8080

# Startup script writes .env from environment variables, then starts Laravel
CMD /bin/sh -c 'printenv | grep -E "^(APP_|DB_|LOG_|SESSION_|MAIL_|CACHE_|QUEUE_|BROADCAST_|FILESYSTEM_)" | awk -F= "{print \$1\"=\"\$2}" > .env && \
    echo "" >> .env && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}'