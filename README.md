# Sistema de Control Transmetro Guatemala

Desarrollado por **Panda Solutions**. Sistema web para gestión del transporte público Transmetro de la Ciudad de Guatemala.

## Stack tecnológico

- Laravel 11 (PHP 8.2+)
- **SQLite** (desarrollo local) / **PostgreSQL** (producción en Railway)
- Blade + Tailwind CSS
- Railway (hosting)

## Instalación local

```bash
# 1. Clonar repositorio
git clone https://github.com/Pandabueno/Transmetro.git
cd Transmetro

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS y compilar assets
npm install && npm run build

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. La base de datos local es SQLite — no necesitas instalar nada extra
#    El archivo se crea automáticamente en database/database.sqlite

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. Iniciar servidor
php artisan serve
```

Acceder en: http://localhost:8000

## Usuarios de prueba

| Usuario | Contraseña | Rol |
|---|---|---|
| admin.municipal | password123 | Administrador |
| operador.central | password123 | Operador de Estación |
| supervisor.lineas | password123 | Supervisor de Líneas |

## Variables de entorno en Railway

Configurar en el panel de Railway. **Agregar plugin PostgreSQL** en Railway y usar las variables que genera automáticamente:

```
APP_KEY=         (generar con php artisan key:generate)
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.railway.app
DB_CONNECTION=pgsql
DB_HOST=         (Railway PostgreSQL internal host)
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=     (Railway PostgreSQL password)
```

## URL de producción

https://transmetro-production.railway.app *(actualizar después del deploy)*

## Licencia

Panda Solutions © 2026
