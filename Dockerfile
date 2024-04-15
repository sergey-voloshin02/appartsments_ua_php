FROM php:8.1-apache

# Установка дополнительных зависимостей
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo pdo_mysql gd zip

# Включение модуля rewrite для Apache
RUN a2enmod rewrite

# Указание директории для рабочего пространства
WORKDIR /var/www/html