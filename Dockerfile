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

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nginx supervisor \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev postgresql-client \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP separadamente para garantir sucesso
RUN docker-php-ext-install pdo
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install xml
RUN docker-php-ext-install gd

# Instalar Bun
RUN curl -fsSL https://bun.sh/install | bash \
    && mv /root/.bun/bin/bun /usr/local/bin/ \
    && chmod +x /usr/local/bin/bun

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar apenas os arquivos de dependências primeiro
COPY composer.json composer.lock ./

# Instalar dependências PHP sem verificação prévia
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

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
