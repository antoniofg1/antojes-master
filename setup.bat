@echo off
echo ====================================
echo SETUP COMPLETO - Chat Geolocalizado
echo ====================================
echo.

echo [1/5] Creando base de datos...
php bin/console doctrine:database:create --if-not-exists
echo ✓ Base de datos creada
echo.

echo [2/5] Ejecutando migraciones...
php bin/console doctrine:migrations:migrate --no-interaction
echo ✓ Migraciones ejecutadas
echo.

echo [3/5] Cargando fixtures (usuarios de Valencia)...
php bin/console doctrine:fixtures:load --no-interaction
echo ✓ 21 usuarios cargados con coordenadas de Valencia
echo.

echo [4/5] Limpiando cache...
php bin/console cache:clear
echo ✓ Cache limpiada
echo.

echo ====================================
echo ✓ SETUP COMPLETADO
echo ====================================
echo.
echo Usuarios de prueba creados:
echo - maria.garcia@valencia.com : password123
echo - carlos.martinez@valencia.com : password123
echo - test@example.com : password123
echo Total: 21 usuarios activos en Valencia
echo.
echo API Key: test-api-key
echo.
echo Endpoints principales:
echo - Documentacion: http://localhost:8000/api
echo - Registro: POST /api/usuarios
echo - Login: POST /api/login
echo - Home: GET /api/home
echo - Chat: GET /api/general
echo.
echo [5/5] Iniciando servidor...
echo.
php -S localhost:8000 -t public
