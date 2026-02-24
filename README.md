# Despliegue en Vercel, Render y Railway (Laravel + Vue)

Guia practica y profesional para estructurar, dockerizar y desplegar una aplicacion web con CI/CD usando GitHub Actions, Vercel, Render y Railway. Esta documentacion refleja el flujo real que se siguio en este proyecto.

## Indice

1. [Introduccion](#1-introduccion)
2. [Arquitectura](#2-arquitectura)
3. [Tecnologias utilizadas](#3-tecnologias-utilizadas)
4. [Estructura del proyecto](#4-estructura-del-proyecto)
5. [Desarrollo local con Docker](#5-desarrollo-local-con-docker)
6. [Estructura del Frontend](#6-estructura-del-frontend)
7. [Estructura del Backend](#7-estructura-del-backend)
8. [Despliegue en Railway (MySQL)](#8-despliegue-en-railway-mysql)
9. [Despliegue en Render (Backend)](#9-despliegue-en-render-backend)
10. [Despliegue en Vercel (Frontend)](#10-despliegue-en-vercel-frontend)
11. [CI/CD con GitHub Actions](#11-cicd-con-github-actions)
12. [Verificacion final](#12-verificacion-final)
13. [URLs finales](#13-urls-finales)
14. [Comandos utiles](#14-comandos-utiles)
15. [Notas finales](#15-notas-finales)

## 1. Introduccion

**Que es Vercel**
Plataforma de despliegue optimizada para frontends (Vue, React, Next, etc). Provee CDN global y despliegues rapidos.

**Que es Render**
Plataforma para desplegar APIs y servicios backend con SSL y escalado administrado.

**Que es Railway**
Plataforma para bases de datos y servicios. Se usa aqui para MySQL en produccion.

## 2. Arquitectura

La app se divide en tres servicios:

- Frontend (Vercel) consume la API en Render.
- Backend (Render) se conecta a MySQL en Railway.
- Railway expone la base de datos para el entorno de produccion.


## 3. Tecnologias utilizadas

- Frontend: Vue 3 + Vite + Tailwind CSS
- Backend: Laravel (API REST)
- Base de datos: MySQL
- Desarrollo local: Docker Compose
- Despliegue: GitHub Actions + Vercel + Render + Railway

## 4. Estructura del proyecto

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

## 5. Desarrollo local con Docker

Requisitos:

- Docker y Docker Compose instalados.

Pasos:

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

## 6. Estructura del Frontend

Componentes principales:

- [frontend/src/App.vue](frontend/src/App.vue) como componente principal.
- [frontend/src/main.ts](frontend/src/main.ts) como punto de entrada.
- [frontend/src/style.css](frontend/src/style.css) para estilos globales.
- [frontend/src/services/api.ts](frontend/src/services/api.ts) como cliente HTTP.

Variable de entorno:

- `VITE_API_URL` apunta al backend (local o Render).

## 7. Estructura del Backend

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

## 8. Despliegue en Railway (MySQL)

1) Crea un proyecto MySQL en Railway.
2) Copia las variables de conexion publicas:

![Variables Railway](images/variables%20railway.png)
![Variables Railway (detalle)](images/variables%20bd%20railway.png)

Variables utilizadas en Render:

- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

## 9. Despliegue en Render (Backend)

Configuracion recomendada:

- Root Directory: backend
- Runtime: Docker
- Plan: Free

![Config Render](images/render%20config.png)
![Despliegue Render](images/despliegue%20back%20render.png)

Variables de entorno en Render:

![Variables Render](images/variables%20render.png)

CORS en Render:

![CORS en Render](images/cors%20variable%20en%20render.png)

Deploy Hook (para CI/CD):

![Deploy Hook](images/secret%20key%20deploy%20hook.png)

Carga los datos Render:

![Render funcionando](images/render%20funcionando.png)

## 10. Despliegue en Vercel (Frontend)

Configuracion recomendada:

- Root Directory: frontend
- Framework: Vite
- Build Command: `npm run build`
- Output Directory: dist

![Config Vercel](images/vercel%20config.png)

Variable clave:

- `VITE_API_URL=https://practicafinal-docker.onrender.com`

Token para CI/CD:

![Token Vercel](images/token%20en%20vercel.png)

Proyecto desplegado:

![Vercel funcionando](images/vercel%20funcionando.png)
![Vercel desplegado](images/desplegada%20vercel.png)

## 11. CI/CD con GitHub Actions

Secrets necesarios en GitHub:

- `RENDER_DEPLOY_HOOK`
- `VERCEL_TOKEN`
- `VERCEL_ORG_ID`
- `VERCEL_PROJECT_ID`

Capturas de referencia:

![Vercel Token Secret](images/secret%20key%20vercel%20token.png)
![Vercel Org ID Secret](images/secret%20key%20user%20id.png)
![Vercel Project ID Secret](images/secret%20key%20project%20id.png)

Workflows:

- Backend: [deploy-backend.yaml](.github/workflows/deploy-backend.yaml)
- Frontend: [deploy-frontend.yaml](.github/workflows/deploy-frontend.yaml)


## 12. URLs finales

- Frontend (Vercel): https://practicafinal-docker.vercel.app
- Backend API (Render): 
    - Endpoint de cursos: https://practicafinal-docker.onrender.com/api/courses
    - Endpoint de estudiantes: https://practicafinal-docker.onrender.com/api/students

## 13. Comandos utiles

```
docker compose up --build
docker compose down

docker compose exec backend php artisan migrate

docker compose exec backend php artisan tinker
```

## 14. Notas finales

- Mantener CORS actualizado cuando cambie el dominio de Vercel.
- Para pruebas locales, usa `http://localhost:3000` en `CORS_ALLOWED_ORIGINS`.
- Si cambias el dominio de Vercel, actualiza `VITE_API_URL` en Vercel.
