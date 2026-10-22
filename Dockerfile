
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
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Serve Laravel from its public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n' \
    >> /etc/apache2/apache2.conf \
    && printf '%s\n' \
    '#!/bin/sh' \
    'set -eu' \
    'PORT="${PORT:-10000}"' \
    'sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf' \
    'sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf' \
    'chown -R www-data:www-data storage bootstrap/cache' \
    'exec apache2-foreground' \
    > /usr/local/bin/start-laravel \
    && chmod +x /usr/local/bin/start-laravel

EXPOSE 10000

CMD ["/usr/local/bin/start-laravel"]
