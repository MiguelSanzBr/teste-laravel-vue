#############################
##      1. BUILD STAGE     ##
#############################
FROM php:8.2-fpm-alpine AS build
WORKDIR /var/www/html

# Node e npm para build do Vue/Inertia
RUN apk add --no-cache nodejs npm

# Copia e instala dependências JS
COPY package.json package-lock.json ./
RUN npm ci

# Copia código-fonte
COPY . .

# Composer para instalar Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Compila assets do Vue/Inertia
RUN npm run build

# Ajusta permissões
RUN chown -R www-data:www-data storage bootstrap/cache


#############################
##      2. FINAL STAGE     ##
#############################
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Bibliotecas e extensões PHP necessárias
RUN apk add --no-cache \
    bash libzip-dev nginx oniguruma-dev postgresql-dev supervisor dcron \
    && docker-php-ext-install mbstring pdo pdo_pgsql zip \
    && rm -rf /var/cache/apk/*

# Copia app compilado da fase build
COPY --from=build /var/www/html /var/www/html

# Diretórios runtime
RUN mkdir -p /var/log/supervisor /var/run/nginx storage/logs

# Nginx / Supervisor / Entrypoint
COPY docker/nginx.conf            /etc/nginx/nginx.conf
COPY docker/supervisord.conf      /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh         /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
