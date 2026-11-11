
# Build the Vite frontend
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# Install production PHP dependencies
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


# Run Laravel with Apache
FROM php:8.3-apache-bookworm




RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        bcmath \
        intl \
        opcache \
        zip \
    && echo "===== AVAILABLE MPM MODULES =====" \
    && ls -la /etc/apache2/mods-available/mpm_* \
    && echo "===== ENABLED MPM MODULES =====" \
    && find /etc/apache2/mods-enabled -maxdepth 1 -name 'mpm_*' -ls \
    && echo "===== APACHE MODULE CONFIGURATION =====" \
    && grep -RInE 'LoadModule[[:space:]]+mpm_' /etc/apache2 \
    && echo "===== APACHE MODULE LIST =====" \
    && apache2ctl -M



WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build


# Laravel package discovery
RUN php artisan package:discover --ansi


# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    && printf '%s\n' \
        '<Directory /var/www/html/public>' \
        '    AllowOverride All' \
        '    Require all granted' \
        '</Directory>' \
        >> /etc/apache2/apache2.conf


# Railway startup script
RUN printf '%s\n' \
    '#!/bin/sh' \
    'set -eu' \
    'PORT="${PORT:-8080}"' \
    'sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf' \
    'sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf' \
    'mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache' \
    'chown -R www-data:www-data storage bootstrap/cache' \
    'exec apache2-foreground' \
    > /usr/local/bin/start-laravel \
    && chmod +x /usr/local/bin/start-laravel


EXPOSE 8080

CMD ["/usr/local/bin/start-laravel"]
