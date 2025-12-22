FROM php:8.4-apache

# Включаем mod_rewrite (нужно Laravel)
RUN a2enmod rewrite headers

# Системные зависимости + PHP расширения
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libicu-dev libonig-dev pkg-config libzip-dev zlib1g-dev \
    && docker-php-ext-install pdo pdo_pgsql intl zip mbstring opcache \
    && docker-php-ext-enable intl zip mbstring opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Apache config под Laravel
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Копируем проект
COPY . .

# Права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
