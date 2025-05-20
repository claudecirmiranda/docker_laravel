FROM php:8.3-apache

# Instalar extensões e utilitários
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zlib1g-dev libzip-dev unzip git curl nano \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Instalar Node.js
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Ajustar permissões padrão
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Expor a porta
EXPOSE 80
