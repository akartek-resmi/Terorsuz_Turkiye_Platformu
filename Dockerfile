FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        default-mysql-client \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql gd curl \
    && a2enmod rewrite headers \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/* \
    && printf '%s\n' \
        '#!/bin/sh' \
        'set -eu' \
        'PORT="${PORT:-80}"' \
        'sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf' \
        'sed -i "s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf' \
        'exec apache2-foreground' \
        > /usr/local/bin/start-apache.sh \
    && chmod +x /usr/local/bin/start-apache.sh

COPY . /var/www/html

RUN chown -R www-data:www-data \
    /var/www/html/wp-content/uploads \
    /var/www/html/assets/js

EXPOSE 80

CMD ["start-apache.sh"]
