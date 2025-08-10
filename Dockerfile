# Multi-stage build com Node.js (mais estável)
FROM node:18-alpine AS frontend

WORKDIR /app

# Copiar arquivos de dependências
COPY package*.json ./

# Instalar dependências
RUN npm ci

# Copiar código fonte
COPY . .

# Build dos assets
RUN npm run build

# Stage principal do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema em uma única camada
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    nginx \
    supervisor \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    postgresql-client \
    nodejs \
    npm \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
        bcmath \
        mbstring \
        xml \
        gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar apenas composer.json e composer.lock primeiro (para cache)
COPY composer.json composer.lock ./

# Criar diretórios necessários antes do composer install
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

# Instalar dependências PHP com configurações otimizadas
RUN composer config --global process-timeout 2000 \
    && composer config --global memory-limit -1 \
    && composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --prefer-dist \
        --no-scripts

# Copiar package.json para dependências Node.js
COPY package*.json ./

# Instalar dependências Node.js
RUN npm ci --only=production

# Copiar todo o código da aplicação
COPY . .

# Copiar assets buildados do stage anterior
COPY --from=frontend /app/public/build ./public/build

# Executar scripts do composer após copiar todos os arquivos
RUN composer run-script post-autoload-dump

# Copiar configurações do Docker
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh

# Definir permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod +x /start.sh

# Expor porta
EXPOSE 80

# Comando de inicialização
CMD ["/start.sh"]
