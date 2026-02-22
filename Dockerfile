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

# Crear directorio var si no existe
RUN mkdir -p /app/var

# Copiar script de entrada
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Exponer puerto 10000 (Render usa este por defecto)
EXPOSE 10000

# Comando de inicio - ejecuta migraciones y luego el servidor
ENTRYPOINT ["docker-entrypoint.sh"]
