# 🚀 Guía de Despliegue en Render.com

## Paso 1: Preparar el repositorio

### A. Hacer commit de los cambios

```bash
git add .
git commit -m "Add production configuration and web interface"
git push origin main
```

## Paso 2: Crear cuenta en Render

1. Ve a: **https://render.com**
2. Registrate con GitHub (más fácil)
3. Autoriza el acceso a tus repositorios

## Paso 3: Desplegar el proyecto

### A. Crear servicio desde Blueprint (render.yaml)

1. En Render Dashboard, haz clic en **"New +"**
2. Selecciona **"Blueprint"**
3. Conecta tu repositorio de GitHub
4. Render detectará automáticamente el `render.yaml`
5. Haz clic en **"Apply"**

Render creará automáticamente:
- ✅ Web Service (API PHP)
- ✅ PostgreSQL Database (gratis)
- ✅ Variables de entorno configuradas

### B. Configurar variables de entorno adicionales

En el Dashboard del servicio web, ve a **Environment**:

```
APP_ENV=prod
APP_DEBUG=0
APP_SECRET=<generar-random-string-32-chars>
APP_API_KEY=test-api-key
DATABASE_URL=<auto-configurado-por-render>
```

## Paso 4: Ejecutar migraciones

Una vez desplegado, ve a **Shell** en Render y ejecuta:

```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

## Paso 5: Probar la API

Tu API estará disponible en:
```
https://chat-geolocalizado-api.onrender.com
```

### Probar endpoints:

```bash
# Login
curl -X POST https://chat-geolocalizado-api.onrender.com/api/login \
  -H "Content-Type: application/json" \
  -H "X-API-KEY: test-api-key" \
  -d '{"email":"maria.garcia@valencia.com","password":"password123"}'

# Home (necesitas el token del login)
curl https://chat-geolocalizado-api.onrender.com/api/home \
  -H "Authorization: Bearer TU_TOKEN_AQUI" \
  -H "X-API-KEY: test-api-key"
```

## Paso 6: Acceder a la documentación web

```
https://chat-geolocalizado-api.onrender.com/docs.html
```

## URLs importantes

- **API Base**: `https://chat-geolocalizado-api.onrender.com`
- **Login Web**: `https://chat-geolocalizado-api.onrender.com/docs.html`
- **Tests**: `https://chat-geolocalizado-api.onrender.com/index.html`
- **Dashboard**: `https://dashboard.render.com`

## Notas importantes

⚠️ **Plan Free de Render:**
- La app se "duerme" después de 15 min de inactividad
- Primera request puede tardar 30-60 segundos en "despertar"
- PostgreSQL limitado a 1GB
- Ideal para demos y proyectos académicos

## Alternativa: Railway.app

Si prefieres otra opción:

1. Ve a: **https://railway.app**
2. Conecta GitHub
3. Selecciona repositorio
4. Railway detecta PHP automáticamente
5. Añade PostgreSQL desde "Add Service"
6. Configura variables de entorno

## Solución de problemas

### Error de migraciones
```bash
php bin/console doctrine:schema:update --force
```

### Ver logs
En Render Dashboard → Logs

### Base de datos vacía
```bash
php bin/console doctrine:fixtures:load --no-interaction
```

## Actualizar deployment

Cada vez que hagas `git push` a main, Render desplegará automáticamente.

---

**✅ Proyecto listo para mostrar a tu profesor**
