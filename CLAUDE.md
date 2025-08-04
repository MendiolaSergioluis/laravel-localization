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