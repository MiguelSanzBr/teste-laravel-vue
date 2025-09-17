#!/bin/bash
set -e

# Gera chave da aplicação se não existir
if [ ! -f /var/www/html/storage/laravel.key ]; then
    php artisan key:generate --force
fi

# Limpa caches
php artisan optimize:clear
# Executa migrations
php artisan migrate --force

# Sobe Supervisor (que gerencia PHP-FPM, Nginx e Cron)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
