# Imagem base do PHP com FPM
FROM php:8.2-fpm

# Instalação de dependências essenciais
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

# Copia o conteúdo do diretório atual para o diretório /var/www/html no container
COPY . /var/www/html

# Instalação do Composer a partir da imagem oficial do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho no container
WORKDIR /var/www/html

# Garantir permissões corretas para os diretórios storage e cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache