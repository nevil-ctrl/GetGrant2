FROM php:8.4-apache

# Включаем модули Apache
RUN a2enmod rewrite headers

# Устанавливаем системные зависимости + PHP расширения
RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libicu-dev libonig-dev pkg-config libzip-dev zlib1g-dev \
    libpng-dev libjpeg-dev libfreetype6-dev build-essential \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql intl zip mbstring opcache \
    && pecl install redis \
    && docker-php-ext-enable redis gd intl zip mbstring opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Apache конфиг
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# PHP настройки
RUN echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize = 64M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.max_accelerated_files=4000" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# Копируем проект
COPY . .

# Права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
