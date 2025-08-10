# Etapa 1 — Instalar dependências do Composer
FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

RUN composer dump-autoload --optimize

# Etapa 2 — Configuração do Laravel (PHP + Nginx)
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip nginx supervisor && \
    docker-php-ext-install pdo pdo_mysql zip && \
    rm -rf /var/lib/apt/lists/*

# Copiar arquivos do Laravel
WORKDIR /var/www/html
COPY --from=composer_builder /app ./

# Configuração do Nginx
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Configuração do Supervisor (para rodar PHP-FPM e Nginx juntos)
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Definir permissões corretas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Porta exposta
EXPOSE 80

# Comando inicial
CMD ["/usr/bin/supervisord"]
