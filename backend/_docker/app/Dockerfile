# ------ builder stage ------
FROM php:8.3-cli AS builder

WORKDIR /app

# Системные зависимости для компиляции GD
RUN apt-get update \
 && apt-get install -y \
      zip unzip git \
      libpng-dev libjpeg-dev libfreetype6-dev \
 && rm -rf /var/lib/apt/lists/*

# Устанавливаем composer
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin --filename=composer

# GD
RUN docker-php-ext-configure gd \
      --with-jpeg=/usr/include/ \
      --with-freetype=/usr/include/ \
 && docker-php-ext-install gd

# Laravel-зависимости без dev-пакетов и скриптов
RUN composer install \
      --no-dev \
      --optimize-autoloader \
      --no-scripts

COPY . .

RUN composer dump-autoload --optimize \
 && php artisan package:discover --ansi \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# ------ production stage ------
FROM php:8.3-fpm

# 1) Устанавливаем CA-сертификаты + зависимости + PHP-модули
RUN apt-get update \
 && apt-get install -y \
      ca-certificates \
      libpng-dev libzip-dev zip unzip git \
      libmagickwand-dev --no-install-recommends \
 && update-ca-certificates \
 && docker-php-ext-install \
      pdo_mysql \
      zip \
      gd \
      bcmath \
      soap \
 && pecl install imagick \
 && docker-php-ext-enable imagick \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer
COPY --from=builder /app /var/www/html
COPY _docker/app/php.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/html
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
