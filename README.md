# 🌐 API Antojes - Chat Geolocalizado

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/template/antojes-api)

> API REST con geolocalización para chat social - Symfony 7.2 + PostgreSQL

## 🚀 Deploy en 1 Clic

**Haz clic en el botón de arriba** para desplegar automáticamente en Railway.

O sigue estos pasos:

### Opción 1: Railway (Recomendado)

1. Ve a: https://railway.app
2. Login con GitHub
3. **Crear Workspace primero:**
   - Menú superior → "New Team" → Dale un nombre → "Create"
4. **Deploy proyecto:**
   - "New Project" → "Deploy from GitHub repo"
   - Selecciona `antojes-master` → "Deploy"

### Opción 2: Render

1. Ve a: https://render.com
2. Login con GitHub
3. "New +" → "Blueprint"
4. Selecciona `antojes-master`
5. "Apply"

## 📡 Endpoints Principales

- **POST** `/api/login` - Autenticación
- **GET** `/api/home` - Usuarios cercanos (5km)
- **GET** `/api/general` - Chat general
- **POST** `/api/actualizar` - Actualizar ubicación
- **GET** `/api/privado` - Chats privados
- **POST** `/api/enviar-mensaje` - Enviar mensaje

Todos los endpoints retornan formato estándar:
```json
{
  "data": { ... },
  "error": null
}
```

## 🔑 Autenticación

Todos los endpoints requieren:
- Header `X-API-KEY: test-api-key`
- Header `Authorization: Bearer {token}` (excepto login)

## 👤 Usuario de Prueba

```
Email: maria.garcia@valencia.com
Password: password123
```

## 📚 Documentación

Después del deploy, accede a:
- **Documentación Web:** `https://tu-url/docs.html`
- **Interfaz de Pruebas:** `https://tu-url/index.html`

## 🛠️ Tecnologías

- **Backend:** Symfony 7.2.9
- **Base de Datos:** PostgreSQL (Railway/Render) / MySQL 8.0 (Local)
- **ORM:** Doctrine 3.6
- **Auth:** JWT (lcobucci/jwt 4.0)
- **PHP:** 8.2+

## 📦 Instalación Local

```bash
# Clonar repo
git clone https://github.com/antoniofg1/antojes-master.git
cd antojes-master

# Instalar dependencias
composer install

# Configurar .env
# DATABASE_URL=mysql://root@127.0.0.1:3306/antojes_db

# Crear base de datos
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Cargar datos de prueba (21 usuarios de Valencia)
php bin/console doctrine:fixtures:load

# Iniciar servidor
php -S localhost:8000 -t public
```

Accede a: http://localhost:8000/docs.html

## 🗄️ Base de Datos

7 tablas:
- `user` - Usuarios con geolocalización
- `chat` - Salas de chat (general/privado)
- `chat_member` - Miembros de chats
- `message` - Mensajes
- `user_block` - Bloqueos
- `user_follow` - Seguimientos
- `friend_request` - Solicitudes de amistad

## 📄 Licencia

Proyecto académico - Uso educativo
