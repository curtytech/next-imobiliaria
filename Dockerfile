FROM php:8.2-fpm

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nginx supervisor && \
    docker-php-ext-install pdo pdo_mysql zip bcmath && \
    rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Criar pasta de trabalho
WORKDIR /var/www/html

# Copiar arquivos do Laravel
COPY . .

# Instalar dependências PHP do Laravel
RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Configuração do Nginx
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Configuração do Supervisor (para rodar PHP-FPM e Nginx juntos)
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expor porta HTTP
EXPOSE 80

# Iniciar Supervisor
CMD ["/usr/bin/supervisord"]
