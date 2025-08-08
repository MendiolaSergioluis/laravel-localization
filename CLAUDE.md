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

#### Clase 4: Funcionalidad de cambio de idioma
- **Fecha**: 2025-08-07
- **Estado**: ✅ Completada
- **Objetivo**: Implementar funcionalidad para cambiar y persistir el idioma seleccionado
- **Pasos realizados**:
  1. Crear controlador `LanguageStoreController` para manejar cambios de idioma
  2. Agregar ruta POST para el cambio de idioma
  3. Implementar evento de cambio en el selector del frontend
  4. Configurar validación usando el enum Lang
- **Implementación**:
  - `LanguageStoreController`: Controlador invokable que valida idioma usando `Lang::tryFrom()`
  - Almacenamiento en sesión con `session()->put('language', $locale)`
  - Validación con fallback al idioma por defecto si el valor no es válido
  - `AuthenticatedLayout.vue`: Evento `onChange` que envía POST request usando `router.post()`
  - Integración con helper `route()` para generar URLs
- **Archivos creados/modificados**:
  - `app/Http/Controllers/LanguageStoreController.php` - Nuevo controlador
  - `routes/web.php` - Nueva ruta `/languate` (POST)
  - `resources/js/Layouts/AuthenticatedLayout.vue` - Función `onLanguageChange`
  - `resources/js/Pages/Dashboard.vue` - Limpieza de código de prueba

#### Clase 5: Implementar middleware SetLanguage para Laravel 12
- **Fecha**: 2025-08-07
- **Estado**: ✅ Completada
- **Objetivo**: Configurar middleware para establecer el idioma automáticamente en cada request
- **Pasos realizados**:
  1. Crear middleware `SetLanguage` para establecer el locale de la aplicación
  2. Registrar middleware en `bootstrap/app.php` (nueva estructura en Laravel 12)
  3. Configurar orden correcto del middleware en la pila web
- **Implementación**:
  - `SetLanguage.php`: Middleware que lee idioma de la sesión usando `session()->get('language')`
  - Validación con `Lang::tryFrom()` y fallback a `config('app.locale')` si no es válido
  - Establecimiento del locale con `app()->setLocale($locale)`
  - Registro en `bootstrap/app.php` usando `$middleware->web(append:)`
- **Métodos de middleware en Laravel 12**:
  - `append()` - Agregar middleware al final de la pila global
  - `prepend()` - Agregar middleware al inicio de la pila global  
  - `web(append:)` - Agregar middleware al grupo web
  - `api(append:)` - Agregar middleware al grupo API
  - `priority()` - Definir orden específico de ejecución de middleware
- **Archivos creados/modificados**:
  - `app/Http/Middleware/SetLanguage.php` - Nuevo middleware
  - `bootstrap/app.php` - Registro del middleware usando `web(append:)`

#### Clase 6: Implementar sistema completo de traducciones
- **Fecha**: 2025-08-07
- **Estado**: ✅ Completada
- **Objetivo**: Completar sistema de traducciones compartiendo archivos de idioma con el frontend
- **Pasos realizados**:
  1. Crear archivos de traducción de ejemplo para inglés y español
  2. Implementar carga automática de traducciones en `HandleInertiaRequests`
  3. Optimizar tipos TypeScript para incluir traducciones
  4. Configurar sistema de lazy loading para optimizar performance
- **Implementación**:
  - **Sistema de traducciones en HandleInertiaRequests**: 
    - Carga automática de todos los archivos `.php` del directorio `lang/{locale}/`
    - Conversión a formato dot notation usando `Arr::dot()` para acceso fácil desde frontend
    - Implementación con lazy loading para evitar carga innecesaria en cada request
    - Fallback a array vacío si no existe el directorio de idioma
  - **Archivos de traducción**:
    - `lang/en/dashboard.php`: Traducciones en inglés con placeholder `:name`
    - `lang/es/dashboard.php`: Traducciones en español
  - **Optimizaciones frontend**:
    - Interface `Language` separada para mejor tipado en TypeScript
    - Tipo `translations` como `Record<string, string>` para acceso a traducciones
    - Mostrar traducciones en Dashboard para verificar funcionamiento
- **Características técnicas**:
  - **Lazy loading**: Las traducciones solo se cargan cuando se necesitan
  - **Formato dot notation**: Acceso intuitivo a traducciones anidadas (ej: `auth.failed`)
  - **Fallback seguro**: Sistema nunca falla, siempre retorna datos válidos
- **Archivos modificados**:
  - `app/Http/Middleware/HandleInertiaRequests.php` - Sistema de traducciones completo
  - `resources/js/types/index.d.ts` - Tipos optimizados para traducciones
  - `resources/js/Pages/Dashboard.vue` - Mostrar traducciones para test
- **Archivos nuevos**:
  - `lang/en/dashboard.php` - Traducciones en inglés
  - `lang/es/dashboard.php` - Traducciones en español

#### Clase 7: Helper de traducciones para Vue.js
- **Fecha**: 2025-08-08
- **Estado**: ✅ Completada
- **Objetivo**: Crear función helper `__()` para facilitar el uso de traducciones desde components Vue.js
- **Pasos realizados**:
  1. Crear función helper de traducciones en TypeScript con soporte para placeholders
  2. Registrar función globalmente en la aplicación Vue.js
  3. Implementar uso de la función en Dashboard para mostrar mensaje personalizado
  4. Mejorar documentación del código con comentarios explicativos
- **Implementación**:
  - **Helper de traducciones `lang.ts`**:
    - Función `__()` que accede a `usePage().props.translations` de Inertia.js
    - Soporte para reemplazo de placeholders usando sintaxis `:placeholder`
    - Fallback al key original si la traducción no existe
    - Tipado TypeScript completo con parámetros opcionales
  - **Integración con Vue.js**:
    - Registro global en `app.ts` usando `app.config.globalProperties.__`
    - Disponible en todos los componentes sin necesidad de import
    - Mantenimiento de import explícito en componentes para mejor IntelliSense
  - **Uso práctico**:
    - `Dashboard.vue` ahora muestra saludo personalizado usando `__('dashboard.greeting', { name: user.name })`
    - Reemplazo automático del placeholder `:name` con el nombre del usuario
- **Características técnicas**:
  - **Tipo seguro**: Parámetros tipados con `Record<string, string>`
  - **Flexible**: Soporte para múltiples placeholders en una sola traducción
  - **Eficiente**: Acceso directo a props de Inertia sin overhead adicional
  - **Intuitivo**: Sintaxis similar a Laravel `__()` helper
- **Archivos creados**:
  - `resources/js/lang.ts` - Helper function con documentación completa
- **Archivos modificados**:
  - `resources/js/app.ts` - Registro global de helper y documentación mejorada
  - `resources/js/Pages/Dashboard.vue` - Uso del helper para mostrar saludo personalizado

#### Clase 8: Documentar optimización de cache para traducciones
- **Fecha**: 2025-08-08
- **Estado**: ✅ Completada
- **Objetivo**: Documentar como implementar cache en el sistema de traducciones para optimizar performance
- **Pasos realizados**:
  1. Agregar comentarios explicativos sobre implementación de cache
  2. Documentar el uso de `Cache::remember()` para traducciones
  3. Especificar tiempo de expiración del cache (1 hora)
  4. Preparar estructura para futura implementación
- **Implementación**:
  - **Comentarios en HandleInertiaRequests**:
    - Documentación completa de como implementar `Cache::remember()`
    - Clave de cache específica por idioma: `"translations.{$locale}"`
    - Tiempo de expiración configurado en 3600 segundos (1 hora)
    - Estructura preparada para migrar la lógica actual dentro del callback
  - **Ventajas del cache propuesto**:
    - Reducir carga de E/O al sistema de archivos en cada request
    - Mejorar tiempos de respuesta especialmente con muchos archivos de idioma
    - Cache automático por idioma, permitiendo cambios dinámicos
    - Expiración automática para permitir actualizaciones de traducciones
- **Características técnicas**:
  - **Cache por idioma**: Cada locale tiene su propia entrada en cache
  - **Lazy loading mantenido**: Solo se carga cache cuando se necesita
  - **TTL configurable**: 3600 segundos como valor por defecto
  - **Compatibilidad**: No requiere cambios en el frontend
- **Notas de implementación**:
  - Lista para implementar agregando `use Illuminate\Support\Facades\Cache;`
  - No requiere cambios en base de datos o configuración adicional
  - Compatible con drivers de cache: file, redis, memcached, etc.
- **Archivos modificados**:
  - `app/Http/Middleware/HandleInertiaRequests.php` - Documentación de cache como comentarios

---
*Próximas clases se documentarán aquí siguiendo el mismo formato*