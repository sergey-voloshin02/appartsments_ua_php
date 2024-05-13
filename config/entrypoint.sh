#!/bin/bash

# Запуск скрипта миграций
php /var/www/html/config/migrate.php

# Запуск Apache в foreground
apache2-foreground