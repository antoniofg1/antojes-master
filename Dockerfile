FROM php:8.2-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código
WORKDIR /app
COPY . /app

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Exponer puerto 10000 (Render usa este por defecto)
EXPOSE 10000

# Comando de inicio - usa variable PORT de Render
CMD php -S 0.0.0.0:${PORT:-10000} -t public
