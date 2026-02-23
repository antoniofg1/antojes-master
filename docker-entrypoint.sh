#!/bin/sh
set -e

echo "🚀 Starting deployment..."

# Ejecutar migraciones
echo "📦 Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction || echo "⚠️ Migrations failed or no migrations to run"

# Cargar fixtures solo si las tablas están vacías
echo "👥 Loading fixtures..."
php bin/console doctrine:fixtures:load --no-interaction || echo "⚠️ Fixtures failed - database might already have data"

echo "✅ Deployment complete!"

# Iniciar servidor con router personalizado
exec php -S 0.0.0.0:${PORT:-10000} -t /app/public /app/public/router.php
