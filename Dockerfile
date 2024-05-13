FROM php:8.1-apache

# Встановлення необхідних залежностей
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) iconv mysqli pdo pdo_mysql gd zip

# Модуль rewrite для Apache
RUN a2enmod rewrite

# Основний код та скрипт entrypoint
COPY . /var/www/html
COPY config/entrypoint.sh /usr/local/bin/

# Даємо права на виконання скрипта
RUN chmod +x /usr/local/bin/entrypoint.sh

# Робоча директорія
WORKDIR /var/www/html

# Встановлення entrypoint
ENTRYPOINT ["entrypoint.sh"] 

# Конфігурація ServerName для Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
