# Multi-stage build para otimizar o tamanho da imagem
FROM node:18-alpine AS frontend

WORKDIR /app

# Copiar arquivos de dependências do frontend
COPY package*.json ./

# Instalar dependências usando npm install em vez de npm ci
RUN npm install --omit=dev

# Copiar código fonte
COPY . .

# Build dos assets
RUN npm run build

# Stage principal do PHP
FROM php:8.2-fpm

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nginx supervisor \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath mbstring xml gd \
    && rm -rf /var/lib/apt/lists/*

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar arquivos de dependências
COPY composer.json composer.lock package*.json ./

# Instalar dependências PHP e Node.js
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && npm install --omit=dev

# Copiar código da aplicação
COPY . .

# Build dos assets
RUN npm run build

# Criar diretórios necessários e ajustar permissões
RUN mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copiar configurações
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Script de inicialização
COPY ./docker/start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
