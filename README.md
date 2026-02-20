# Despliegue en Vercel, Render y Railway (Laravel + Vue)

Este repositorio es una guia practica para estructurar, dockerizar y desplegar una aplicacion web siguiendo CI/CD con GitHub Actions, Vercel, Render y Railway.

- Frontend: Vue 3 + Vite + Tailwind CSS
- Backend: Laravel (API REST)
- Base de Datos: MySQL
- Desarrollo: Docker Compose
- Despliegue: GitHub Actions + Vercel + Render + Railway

## Estructura del proyecto

```
.
├── backend/      # Laravel (API)
├── frontend/     # Vue 3 (SPA)
├── .github/      # Workflows de CI/CD
├── compose.yaml  # Docker Compose para desarrollo
└── .env.example  # Variables locales para Docker Compose
```

## Pasos locales (detallado)

Copia variables de entorno:

```
cp .env.example .env
cp backend/.env.example backend/.env
cp frontend/.env.example frontend/.env
```

Levanta todo:

```
docker compose up --build
```

Ejecuta migraciones:

```
docker compose exec backend php artisan migrate
```

Abre:

- Frontend: http://localhost:3000
- Backend API: http://localhost:8000

## Backend (Laravel)

- Endpoints API:
  - GET /api/courses
  - POST /api/courses
  - PUT /api/courses/{id}
  - DELETE /api/courses/{id}
  - GET /api/students
  - POST /api/students
  - PUT /api/students/{id}
  - DELETE /api/students/{id}

- CORS:
  - Configurado en [backend/config/cors.php](backend/config/cors.php)
  - Variables: `CORS_ALLOWED_ORIGINS`

## Frontend (Vue)

- Variable de entorno:
  - `VITE_API_URL` apunta al backend (local o Render)

## Dónde quedó todo

- Docker Compose local: compose.yaml
- Backend Laravel: backend/Dockerfile
- Frontend Vue: frontend/Dockerfile
- CORS: backend/config/cors.php
- Guía completa: README.md
- Sail legacy (por si lo necesitas): backend/compose.sail.yaml

## Despliegue (resumen rápido)

Render (backend):

- Root Directory: backend
- Runtime: Docker
- Variables: APP_KEY, DB_CONNECTION, DATABASE_URL, CORS_ALLOWED_ORIGINS (con tu dominio Vercel)
- Deploy Hook guardado como RENDER_DEPLOY_HOOK

Vercel (frontend):

- Root Directory: frontend
- Variable: VITE_API_URL con la URL de Render
- Secrets en GitHub: VERCEL_TOKEN, VERCEL_ORG_ID, VERCEL_PROJECT_ID

Railway (MySQL):

- Usa DATABASE_URL en Render con la cadena de Railway

## Workflows

- Backend: [deploy-backend.yaml](.github/workflows/deploy-backend.yaml)
- Frontend: [deploy-frontend.yaml](.github/workflows/deploy-frontend.yaml)

## Comandos utiles

```
docker compose up --build
docker compose down

docker compose exec backend php artisan migrate

docker compose exec backend php artisan tinker
```
