FROM php:8.4-cli
# CACHE BUST v5 - 2026-10-01

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

# Create .env from environment variables, then start Laravel
CMD php -r "file_put_contents('.env', implode(PHP_EOL, array_map(function(\$v){return \$v.'=\"'.(getenv(\$v) ?: '').'\"';}, ['APP_NAME','APP_ENV','APP_DEBUG','APP_KEY','APP_URL','APP_TIMEZONE','LOG_CHANNEL','DB_CONNECTION','DB_HOST','DB_PORT','DB_DATABASE','DB_USERNAME','DB_PASSWORD','SESSION_DRIVER','SESSION_LIFETIME','SESSION_ENCRYPT','SESSION_PATH','SESSION_DOMAIN','BROADCAST_CONNECTION','FILESYSTEM_DISK','QUEUE_CONNECTION','CACHE_STORE'])).PHP_EOL));" && \
    php artisan config:clear && \
    php artisan config:cache && \
    php artisan migrate --force || true && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}