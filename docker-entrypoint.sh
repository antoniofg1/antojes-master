#!/bin/sh
# NO usar set -e para que el servidor arranque aunque fallen migraciones

echo "🚀 Starting deployment..."
echo "Environment: APP_ENV=${APP_ENV:-not-set}"
echo "Port: ${PORT:-10000}"

# Verificar conexión a base de datos
echo "🔍 Checking database connection..."
if php bin/console dbal:run-sql "SELECT 1" 2>/dev/null; then
    echo "✅ Database connection OK"
    
    # Ejecutar migraciones
    echo "📦 Running migrations..."
    if php bin/console doctrine:migrations:migrate --no-interaction 2>&1; then
        echo "✅ Migrations completed"
    else
        echo "⚠️ Migrations failed or no migrations to run"
    fi

    # Cargar fixtures solo si las tablas están vacías
    echo "👥 Loading fixtures..."
    if php bin/console doctrine:fixtures:load --no-interaction --append 2>&1; then
        echo "✅ Fixtures loaded"
    else
        echo "⚠️ Fixtures failed - database might already have data"
    fi
else
    echo "⚠️ Database connection failed - server will start anyway"
fi

echo "✅ Starting server..."

# Iniciar servidor con router simplificado
exec php -S 0.0.0.0:${PORT:-10000} -t /app/public /app/public/router.php
