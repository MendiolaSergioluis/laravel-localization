# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application with Laravel Breeze authentication, Vue.js 3 with TypeScript, Inertia.js for SPA functionality, and TailwindCSS for styling. The project uses Laravel Sail for Docker-based development and includes a full stack with MySQL, Redis, Meilisearch, and Mailpit. Server-side rendering (SSR) is enabled for better SEO and performance.

## Development Commands

### Starting Development Environment
- `sail up` - Start Docker containers with all services
- `composer run dev` - Start all development services (server, queue, logs, vite) concurrently

### Building and Assets
- `sail npm run build` - Build production assets with Vite (includes TypeScript compilation and SSR build)
- `sail npm run dev` - Start Vite development server with hot reload
- `sail artisan serve` - Start Laravel development server (if not using Sail)

### Testing
- `composer run test` - Clear config and run all PHPUnit tests
- `sail artisan test` - Run tests through Sail
- `sail test --filter TestName` - Run specific test

### Code Quality
- `sail pint` - Format PHP code using Laravel Pint
- `sail artisan config:clear` - Clear configuration cache
- `sail artisan route:clear` - Clear route cache
- `sail artisan view:clear` - Clear view cache

### Database
- `sail artisan migrate` - Run database migrations
- `sail artisan migrate:fresh --seed` - Fresh migration with seeding
- `sail artisan tinker` - Open Laravel REPL

## Architecture

### Backend Structure
- **Models**: Located in `app/Models/` - Eloquent ORM models
- **Controllers**: Located in `app/Http/Controllers/` - HTTP request handlers
- **Providers**: Located in `app/Providers/` - Service providers for dependency injection
- **Routes**: Web routes in `routes/web.php`, console commands in `routes/console.php`
- **Database**: Migrations in `database/migrations/`, factories in `database/factories/`, seeders in `database/seeders/`

### Frontend Structure
- **Vue Components**: TypeScript Vue.js 3 components in `resources/js/Pages/` and `resources/js/Components/`
- **Layouts**: Inertia layouts in `resources/js/Layouts/`
- **Assets**: CSS in `resources/css/`, TypeScript in `resources/js/`
- **Public**: Static assets served from `public/`
- **Styling**: TailwindCSS 3.2 with Vite integration
- **SSR**: Server-side rendering entry point at `resources/js/ssr.ts`
- **Authentication**: Laravel Breeze with Inertia.js integration

### Configuration
- **Environment**: Configure via `.env` file (copy from `.env.example`)
- **Config**: Application configuration files in `config/`
- **Caching**: Uses file-based caching, Redis available via Sail

### Docker Services
- **Laravel App**: Main application container on port 80
- **MySQL**: Database server on port 3306
- **Redis**: Cache/session store on port 6379
- **Meilisearch**: Search engine on port 7700
- **Mailpit**: Email testing on port 8025
- **Selenium**: Browser testing support

## Testing Environment
- Uses SQLite for testing (configured in phpunit.xml)
- Test database automatically created and isolated
- Feature tests in `tests/Feature/`, unit tests in `tests/Unit/`
- Uses array drivers for cache, mail, and sessions during testing

## Authentication Routes
- `/login` - Login page (Vue.js component)
- `/register` - Registration page (Vue.js component)
- `/dashboard` - User dashboard (requires authentication)
- `/profile` - User profile management (requires authentication)

## Important Notes
- Always use `sail` prefix for npm commands to run inside Docker container
- If you encounter rollup architecture issues, run: `sail exec laravel.test rm -rf node_modules package-lock.json && sail npm install`
- TypeScript compilation is handled automatically during build process
- SSR is enabled by default for better SEO and performance

## Multilingual Course Implementation

### Course Workflow Process
**Objetivo**: Implementar soporte para múltiples lenguajes en Laravel siguiendo un curso estructurado.

**Workflow establecido**:
1. **Durante cada clase**: Tomar notas detalladas del proceso de implementación
2. **Al finalizar cada clase**:
   - Actualizar este documento con el registro de lo aprendido/implementado
   - Generar commit con mensaje descriptivo de la clase
   - Push a GitHub para mantener historial

**Estado actual**: Preparando estructura para comenzar con la primera clase

### Registro de Clases

#### Clase 0: Preparación inicial
- **Fecha**: 2025-08-04
- **Estado**: En preparación
- **Objetivo**: Configurar el entorno y documentar el plan de trabajo
- **Notas**: 
  - Proyecto base: Laravel 12 + Breeze + Vue.js + TypeScript + Inertia.js
  - Framework de testing: PHPUnit 11.5.28 (PEST no compatible con versión actual)
  - Preparando estructura de documentación para el curso

#### Clase 1: Creación del Enum de Idiomas
- **Fecha**: 2025-08-04
- **Estado**: ✅ Completada
- **Objetivo**: Crear la estructura base para manejar múltiples idiomas
- **Pasos realizados**:
  1. Ejecutar `sail artisan lang:publish` para publicar archivos de idioma
  2. Crear directorio `app/Lang/`
  3. Crear archivo `app/Lang/Lang.php` con enum para idiomas
- **Implementación**:
  - Enum `Lang` con 4 idiomas: EN, ES, IT, PT
  - Método `label()` que retorna nombres en idioma nativo:
    - English, Español, Italiano, Português
  - Estructura preparada para uso en frontend con lista amigable
- **Archivos creados**:
  - `app/Lang/Lang.php` - Enum principal de idiomas

#### Clase 2: Compartir idiomas con el frontend via Inertia
- **Fecha**: 2025-08-06
- **Estado**: ✅ Completada
- **Objetivo**: Hacer disponibles los idiomas en el frontend mediante Inertia.js
- **Pasos realizados**:
  1. Crear `LanguageResource` para transformar datos del enum
  2. Configurar `AppServiceProvider` para remover wrapping de recursos JSON
  3. Modificar `HandleInertiaRequests` para compartir idiomas globalmente
  4. Probar visualización en Dashboard del frontend
- **Implementación**:
  - `LanguageResource`: Transforma enum Lang en formato JSON con 'value' y 'label'
  - `AppServiceProvider`: `JsonResource::withoutWrapping()` para formato limpio
  - `HandleInertiaRequests`: Compartir `languages` collection globalmente
  - `Dashboard.vue`: Mostrar datos de idiomas para verificar funcionamiento
- **Archivos modificados**:
  - `app/Http/Resources/LanguageResource.php` - Nuevo recurso JSON
  - `app/Providers/AppServiceProvider.php` - Configuración JSON sin wrapping
  - `app/Http/Middleware/HandleInertiaRequests.php` - Compartir idiomas
  - `resources/js/Pages/Dashboard.vue` - Test de visualización

#### Clase 3: Implementar selector de idiomas en la interfaz
- **Fecha**: 2025-08-06
- **Estado**: ✅ Completada
- **Objetivo**: Crear selector de idiomas funcional en el layout autenticado
- **Pasos realizados**:
  1. Compartir idioma actual (`language`) desde backend
  2. Definir tipos TypeScript para nuevas props
  3. Implementar dropdown de idiomas en `AuthenticatedLayout`
  4. Configurar preselección del idioma actual
- **Implementación**:
  - `HandleInertiaRequests`: Agregar `app()->getLocale()` como prop `language`
  - `index.d.ts`: Definir tipos para `language` (string) y `languages` (array)
  - `AuthenticatedLayout.vue`: Dropdown con `select` HTML nativo
  - Preselección automática del idioma actual usando `selected` attribute
- **Archivos modificados**:
  - `app/Http/Middleware/HandleInertiaRequests.php` - Compartir idioma actual
  - `resources/js/types/index.d.ts` - Definir tipos TypeScript
  - `resources/js/Layouts/AuthenticatedLayout.vue` - Selector de idiomas

---
*Próximas clases se documentarán aquí siguiendo el mismo formato*