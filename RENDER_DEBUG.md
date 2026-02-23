# 🔍 Guía de Debug para Render

## Problema: "Failed to fetch"

### 1. Verificar que el servidor está arrancado

En el **Dashboard de Render** > Tu servicio > **Logs**, busca:
```
✅ Starting server...
```

Si ves errores antes de esta línea, el servidor no está arrancando.

### 2. Verificar la Base de Datos

#### En Render Dashboard:
1. Ve a **Dashboard** > **Databases** > `psql-postgres`
2. Verifica que el estado sea **Available**
3. Copia la **External Database URL** (o Internal)

#### Conectarte manualmente (SOLO para debug):
```bash
# Desde la Shell del servicio en Render
php bin/console dbal:run-sql "SELECT 1"
```

### 3. Verificar Variables de Entorno

En **Dashboard** > Tu servicio > **Environment**, verifica que existan:
- ✅ `APP_ENV=prod`
- ✅ `APP_API_KEY=test-api-key`
- ✅ `APP_SECRET` (generado automáticamente)
- ✅ `DATABASE_URL` (conectado a la BD)

### 4. Probar el endpoint de Health

Abre en el navegador:
```
https://tu-servicio.onrender.com/health
```

Deberías ver algo como:
```json
{
  "status": "ok",
  "timestamp": 1708704000,
  "env": {
    "APP_ENV": "prod",
    "APP_API_KEY_SET": "yes",
    "APP_SECRET_SET": "yes",
    "DATABASE_URL_SET": "yes"
  },
  "database": {
    "users_count": 5,
    "error": null
  }
}
```

### 5. Página de Verificación

Abre:
```
https://tu-servicio.onrender.com/check.html
```

Esta página hará una prueba automática del servidor.

### 6. Errores Comunes

#### Error: "Failed to fetch"
**Causa:** El servidor no está respondiendo o hay problemas de CORS.
**Solución:**
- Verifica los logs en Render
- Asegúrate de que el servidor arrancó (`✅ Starting server...` en logs)
- Usa `/check.html` para diagnosticar

#### Error: "Unexpected token '<'"
**Causa:** El router PHP no está funcionando correctamente.
**Solución:** Ya está solucionado con `router.php`

#### Error: "users_count": 0, "error": "SQLSTATE..."
**Causa:** Las migraciones no se ejecutaron.
**Solución:** En la Shell de Render:
```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

### 7. NO necesitas phpMyAdmin

Render usa **PostgreSQL**, no MySQL. Para gestionar la BD:

**Opción 1: SQL Editor en Render**
- Dashboard > Databases > SQL Editor

**Opción 2: Conectar con cliente externo**
- Descarga **pgAdmin** o **DBeaver**
- Usa la "External Database URL" de Render

**Opción 3: Shell de Render**
```bash
php bin/console dbal:run-sql "SELECT * FROM user LIMIT 5"
```

### 8. Reinicios automáticos

Render reinicia el servicio automáticamente cuando:
- Haces push a GitHub
- Cambias variables de entorno
- El servicio falla

El reinicio tarda ~2-3 minutos.

## URLs importantes

Reemplaza `tu-servicio` con el nombre de tu servicio en Render:

- **Raíz:** `https://tu-servicio.onrender.com/`
- **Health:** `https://tu-servicio.onrender.com/health`
- **Check:** `https://tu-servicio.onrender.com/check.html`
- **Interfaz:** `https://tu-servicio.onrender.com/index.html`
- **Docs:** `https://tu-servicio.onrender.com/docs.html`
- **API Login:** `https://tu-servicio.onrender.com/api/login`

## Verificación final

1. ✅ Servidor arrancado (ver logs)
2. ✅ Base de datos conectada (`/health` muestra `users_count`)
3. ✅ `/check.html` muestra "✅ Servidor funcionando"
4. ✅ El amigo puede abrir `/index.html`

Si todo está ✅ pero sigue "Failed to fetch", puede ser:
- Firewall/Antivirus del amigo
- Red corporativa bloqueando
- Usar HTTP en vez de HTTPS
