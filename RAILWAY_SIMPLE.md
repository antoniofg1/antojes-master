# 🚂 Railway.app - Despliegue en 3 CLICS

## Ventajas sobre Render
- ✅ **Más rápido** (no se duerme tanto)
- ✅ **3 clics** vs 10 pasos de Render
- ✅ **Sin tarjeta** de crédito
- ✅ **$5 gratis** cada mes

---

## PASO 1: Ir a Railway (1 clic)

🔗 **Abre este enlace:**

### **https://railway.app/new**

---

## PASO 2: Login con GitHub (1 clic)

1. Haz clic en **"Login with GitHub"**
2. Autoriza Railway

---

## PASO 3: Deploy desde GitHub (1 clic)

1. Haz clic en **"Deploy from GitHub repo"**
2. Busca: **`antojes-master`**
3. Selecciónalo
4. Haz clic en **"Deploy Now"**

✅ **¡LISTO!** Railway hace todo automáticamente.

---

## PASO 4: Añadir PostgreSQL (OPCIONAL - 2 clics)

Si quieres base de datos:

1. En tu proyecto, haz clic en **"+ New"**
2. Selecciona **"Database" → "PostgreSQL"**

Railway conecta la DB automáticamente.

---

## PASO 5: Cargar datos (1 comando)

Una vez desplegado:

1. Ve a tu servicio
2. Abre la pestaña **"Deployments"**
3. Haz clic en el deployment activo
4. Arriba a la derecha: **"View Logs"**
5. Al lado: **botón de terminal** (Shell)
6. Ejecuta:

```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
```

---

## 🎯 Tu URL estará en:

Railway te dará una URL tipo:
```
https://antojes-master-production-xxxx.up.railway.app
```

**Documentación:**
```
https://antojes-master-production-xxxx.up.railway.app/docs.html
```

---

## ⏱️ TIEMPO TOTAL: 5 minutos

vs Render que toma 15-20 minutos.

---

## Variables de entorno (si las necesitas)

Railway detecta automáticamente:
- `APP_ENV=prod`
- `PORT` (automático)
- `DATABASE_URL` (si añades PostgreSQL)

Añade manualmente solo:
```
APP_API_KEY=test-api-key
APP_SECRET=genera-un-string-aleatorio-aqui
```

Haz clic en **"Variables"** → **"+ New Variable"**

---

## 🔄 Actualizaciones automáticas

Cada `git push` despliega automáticamente.

---

## 💰 Costos

- **$5 gratis** cada mes
- Tu app usa ~$2-3 al mes
- **Suficiente** para demos

---

## ✅ ENVÍA A TU PROFESOR:

```
🌐 App: https://antojes-master-production-xxxx.up.railway.app/docs.html
📚 Login: maria.garcia@valencia.com / password123
💻 GitHub: https://github.com/antoniofg1/antojes-master
```

---

**¿Problemas?** Railway tiene mejor soporte que Render.
