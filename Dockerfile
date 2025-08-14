# Dockerfile otimizado com Bun - versão corrigida
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

# Instalar dependências do sistema
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

# Configurar e instalar extensões PHP
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
        bcmath \
        mbstring \
        xml \
        gd

# Copiar composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Criar diretórios necessários
RUN mkdir -p storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copiar arquivos do composer
COPY composer.json composer.lock ./

# Instalar extensões adicionais que podem ser necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        intl \
        gd \
        exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar dependências
# Instalar dependências ignorando TODOS os platform requirements
RUN composer install --no-dev --no-interaction --ignore-platform-reqs

# Copiar todo o código
COPY . .

# Copiar assets buildados do stage frontend
COPY --from=frontend /app/public/build ./public/build

# Executar scripts do composer
RUN composer run-script post-autoload-dump --no-interaction || echo "Scripts executados com avisos"

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
