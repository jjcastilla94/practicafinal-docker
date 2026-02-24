# Despliegue en Vercel, Render y Railway (Laravel + Vue)

Guia practica y profesional para estructurar, dockerizar y desplegar una aplicacion web con CI/CD usando GitHub Actions, Vercel, Render y Railway.

- Frontend: Vue 3 + Vite + Tailwind CSS
- Backend: Laravel (API REST)
- Base de Datos: MySQL
- Desarrollo: Docker Compose
- Despliegue: GitHub Actions + Vercel + Render + Railway

## Arquitectura

La app se divide en tres servicios:

- Frontend (Vercel) consume la API en Render.
- Backend (Render) se conecta a MySQL en Railway.
- Railway expone la base de datos para el entorno de produccion.

![Arquitectura general](images/render funcionando.png)

## Estructura del proyecto

```
.
├── backend/      # Laravel (API)
├── frontend/     # Vue 3 (SPA)
├── .github/      # Workflows de CI/CD
├── compose.yaml  # Docker Compose para desarrollo
└── .env.example  # Variables locales para Docker Compose
```

Archivos clave:

- [compose.yaml](compose.yaml) para desarrollo local.
- [backend/Dockerfile](backend/Dockerfile) para el backend.
- [frontend/Dockerfile](frontend/Dockerfile) para el frontend.
- [backend/config/cors.php](backend/config/cors.php) para CORS.
- Workflows: [deploy-backend.yaml](.github/workflows/deploy-backend.yaml) y [deploy-frontend.yaml](.github/workflows/deploy-frontend.yaml).

## URLs finales

- Frontend (Vercel): https://practicafinal-docker.vercel.app
- Backend API (Render): https://practicafinal-docker.onrender.com
- Endpoint de cursos: https://practicafinal-docker.onrender.com/api/courses
- Endpoint de estudiantes: https://practicafinal-docker.onrender.com/api/students

## Desarrollo local con Docker

1) Copia variables de entorno:

```
cp .env.example .env
cp backend/.env.example backend/.env
cp frontend/.env.example frontend/.env
```

2) Levanta todo:

```
docker compose up --build
```

3) Ejecuta migraciones:

```
docker compose exec backend php artisan migrate
```

4) Abre:

- Frontend: http://localhost:3000
- Backend API: http://localhost:8000

## Backend (Laravel)

Endpoints disponibles:

- GET /api/courses
- POST /api/courses
- PUT /api/courses/{id}
- DELETE /api/courses/{id}
- GET /api/students
- POST /api/students
- PUT /api/students/{id}
- DELETE /api/students/{id}

CORS:

- Configurado en [backend/config/cors.php](backend/config/cors.php)
- Variable: `CORS_ALLOWED_ORIGINS`

## Frontend (Vue)

- Variable de entorno:
  - `VITE_API_URL` apunta al backend (local o Render)

## Despliegue en Railway (MySQL)

1) Crea un proyecto MySQL en Railway.
2) Copia las variables de conexion publicas:

![Variables Railway](images/variables railway.png)
![Variables Railway (detalle)](images/variables bd railway.png)

Variables utilizadas en Render:

- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

## Despliegue en Render (Backend)

Configuracion recomendada:

- Root Directory: backend
- Runtime: Docker
- Plan: Free

![Config Render](images/render config.png)
![Despliegue Render](images/despliegue back render.png)

Variables de entorno en Render:

![Variables Render](images/variables render.png)

CORS en Render:

![CORS en Render](images/cors variable en render.png)

Deploy Hook (para CI/CD):

![Deploy Hook](images/secret key deploy hook.png)

## Despliegue en Vercel (Frontend)

Configuracion recomendada:

- Root Directory: frontend
- Framework: Vite
- Build Command: `npm run build`
- Output Directory: dist

![Config Vercel](images/vercel config.png)

Variable clave:

- `VITE_API_URL=https://practicafinal-docker.onrender.com`

Token para CI/CD:

![Token Vercel](images/token en vercel.png)

Proyecto desplegado:

![Vercel funcionando](images/vercel funcionando.png)
![Vercel desplegado](images/desplegada vercel.png)

## CI/CD con GitHub Actions

Secrets necesarios en GitHub:

- `RENDER_DEPLOY_HOOK`
- `VERCEL_TOKEN`
- `VERCEL_ORG_ID`
- `VERCEL_PROJECT_ID`

Capturas de referencia:

![Vercel Token Secret](images/secret key vercel token.png)
![Vercel Org ID Secret](images/secret key user id.png)
![Vercel Project ID Secret](images/secret key project id.png)

Workflows:

- Backend: [deploy-backend.yaml](.github/workflows/deploy-backend.yaml)
- Frontend: [deploy-frontend.yaml](.github/workflows/deploy-frontend.yaml)

## Verificacion final

1) Frontend carga cursos y estudiantes:

- https://practicafinal-docker.vercel.app

2) API responde:

- https://practicafinal-docker.onrender.com/api/courses
- https://practicafinal-docker.onrender.com/api/students

## Comandos utiles

```
docker compose up --build
docker compose down

docker compose exec backend php artisan migrate

docker compose exec backend php artisan tinker
```

## Notas finales

- Mantener CORS actualizado cuando cambie el dominio de Vercel.
- Para pruebas locales, usa `http://localhost:3000` en `CORS_ALLOWED_ORIGINS`.
- Si cambias el dominio de Vercel, actualiza `VITE_API_URL` en Vercel.
