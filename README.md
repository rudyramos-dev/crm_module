# CRM Module — Laravel 11

## Descripción
Módulo CRM funcional construido con Laravel 11 + PostgreSQL como prueba técnica. Incluye gestión de clientes, pipeline de ventas tipo kanban con etapas configurables, registro de actividades y dashboard con métricas clave.

## Stack técnico
- Laravel 11 + PHP 8.2+
- PostgreSQL
- Livewire v3 (Kanban reactivo)
- Tailwind CSS v4 + Alpine.js
- Pest PHP (testing)

## Requisitos
- PHP >= 8.2
- PostgreSQL >= 14
- Composer
- Node.js >= 18 + npm

## Instalación

Instrucciones paso a paso:
1. Clonar repositorio y entrar al directorio
2. cp .env.example .env y configurar DB_CONNECTION=pgsql, DB_DATABASE, DB_USERNAME, DB_PASSWORD
3. composer install
4. php artisan key:generate
5. php artisan migrate --seed
6. npm install && npm run build
7. php artisan serve

## Variables de entorno relevantes

| Variable | Descripción | Ejemplo |
| --- | --- | --- |
| DB_CONNECTION | Driver de base de datos | pgsql |
| DB_HOST | Host de PostgreSQL | 127.0.0.1 |
| DB_PORT | Puerto de PostgreSQL | 5432 |
| DB_DATABASE | Nombre de la base de datos | crm_module |
| DB_USERNAME | Usuario de la base de datos | postgres |
| DB_PASSWORD | Contraseña de la base de datos | secret |

## Arquitectura y decisiones técnicas

### Repository Pattern + Service Layer
La arquitectura separa responsabilidades en flujo Controllers → Services → Repositories → Models. Los controladores no contienen lógica de negocio; solo reciben la petición y delegan. Los Services orquestan reglas de negocio y casos de uso. Los Repositories encapsulan el acceso a datos para permitir cambiar la implementación de persistencia sin tocar la lógica de negocio.

### Por qué Livewire para el Kanban
El kanban necesita interactividad y actualizaciones dinámicas sin la complejidad de una SPA completa. Livewire permite reactividad con estado del lado servidor usando mínimo JavaScript, conservando Blade y la estructura tradicional de Laravel.

### Enums tipados
DealStatus y ActivityType se implementan como backed enums de PHP 8.1+ para garantizar valores válidos por tipo. Esto elimina strings mágicos, reduce errores y mejora la mantenibilidad en validaciones, modelos y lógica de negocio.

## Estructura del proyecto

```text
app/
  Enums/
  Http/Controllers/
  Livewire/
  Models/
  Repositories/
  Services/
database/
  migrations/
resources/
  views/crm/
```

## Capturas de pantalla

### Dashboard
Muestra métricas clave: deals activos, tasa de cierre, valor en pipeline y deals ganados. Incluye tabla de actividades pendientes próximas y deals recientes.

### Clientes
Listado de clientes con contador de deals por cliente, acciones de editar y eliminar con confirmación.

### Pipeline Kanban
Tablero kanban con columnas por etapa configurable. Soporta drag & drop entre columnas, filtro reactivo por cliente y contador de deals y valor por columna.

### Actividades
Vista global de todas las actividades con filtro por tipo (llamada, email, reunión, nota) usando Alpine.js sin recargar la página. También accesible por cliente individual desde su perfil.

---

## Módulos incluidos

- **Clientes**: CRUD completo con soft delete, contactos y historial de actividades
- **Pipeline Kanban**: Etapas configurables, drag & drop con SortableJS, filtro reactivo con Livewire v3
- **Actividades**: Registro por cliente y deal, filtro por tipo, marcar como completada
- **Dashboard**: Métricas en tiempo real (deals activos, tasa de cierre, valor en pipeline, deals ganados), actividades pendientes y deals recientes
