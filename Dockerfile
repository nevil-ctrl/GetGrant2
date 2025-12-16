FROM php:8.4-fpm

# Системные зависимости + PHP расширения
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libicu-dev libonig-dev pkg-config libzip-dev zlib1g-dev \
    && docker-php-ext-install pdo pdo_pgsql intl zip mbstring \
    && docker-php-ext-enable intl zip mbstring

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

# Копируем проект
COPY . /var/www/html

# Права для Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache
