# Multi-stage build otimizado com Bun
FROM oven/bun:1 AS frontend

WORKDIR /app

# Copiar arquivos de dependências
COPY package.json bun.lockb ./

# Instalar dependências com Bun
RUN bun install --frozen-lockfile

# Copiar código fonte
COPY . .

# Build dos assets
RUN bun run build

# Stage principal do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nginx supervisor \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev postgresql-client \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
        pdo pdo_mysql pdo_pgsql \
        zip bcmath mbstring xml gd \
    && rm -rf /var/lib/apt/lists/*

# Instalar Bun corretamente
RUN curl -fsSL https://bun.sh/install | bash \
    && mv /root/.bun/bin/bun /usr/local/bin/ \
    && chmod +x /usr/local/bin/bun

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar apenas os arquivos de dependências primeiro
COPY composer.json composer.lock ./

# Instalar dependências PHP com verificação de extensões
RUN php -m | grep -E '(pdo|pgsql|zip|mbstring)' \
    && COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Copiar arquivos de dependências do Bun
COPY package.json bun.lockb ./

# Instalar dependências com Bun
RUN bun install --frozen-lockfile --production

# Copiar todo o código da aplicação
COPY . .

# Copiar assets buildados do stage anterior
COPY --from=frontend /app/public/build ./public/build

# Copiar configurações
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /start.sh

# Definir permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod +x /start.sh

# Expor porta
EXPOSE 80

# Comando de inicialização
CMD ["/start.sh"]
