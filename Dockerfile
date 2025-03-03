FROM php:8.2-fpm

RUN apt-get upgrade -y && apt-get update -y \
    && apt-get install -y \
        curl \
        git \
        zip \
        libzip-dev \
        nodejs \
        npm \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install \
        pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \