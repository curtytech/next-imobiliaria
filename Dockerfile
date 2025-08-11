# Dockerfile otimizado com Bun e tratamento de erros
FROM oven/bun:1 AS frontend

WORKDIR /app

# Copiar arquivos de dependências
COPY package.json bun.lockb ./

# Instalar dependências
RUN bun install --frozen-lockfile

# Copiar código fonte
COPY . .

# Build dos assets
RUN bun run build

# Stage principal do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema em etapas
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
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurar e instalar extensões PHP uma por vez
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install xml
RUN docker-php-ext-install gd

# Verificar extensões instaladas
RUN php -m | grep -E "(pdo|pgsql|zip|mbstring)"

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar Composer globalmente
RUN composer config --global process-timeout 2000 \
    && composer config --global memory-limit -1

WORKDIR /var/www/html

# Criar diretórios necessários primeiro
RUN mkdir -p storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copiar arquivos do composer
COPY composer.json composer.lock ./

# Instalar dependências PHP sem scripts
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --verbose

# Copiar todo o código
COPY . .

# Copiar assets buildados do stage frontend
COPY --from=frontend /app/public/build ./public/build

# Executar scripts do composer após copiar todos os arquivos
RUN composer run-script post-autoload-dump --no-interaction || true

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
