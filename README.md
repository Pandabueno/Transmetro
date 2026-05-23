# Sistema de Control Transmetro Guatemala

Desarrollado por **Panda Solutions**. Sistema web para gestión del transporte público Transmetro de la Ciudad de Guatemala.

## Stack tecnológico

- Laravel 11 (PHP 8.2+)
- MySQL 8+
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

# 5. Configurar base de datos en .env
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=transmetro
# DB_USERNAME=root
# DB_PASSWORD=tu_password

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

Configurar en el panel de Railway:

```
APP_KEY=         (generar con php artisan key:generate)
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.railway.app
DB_HOST=         (MySQL Railway internal host)
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=     (MySQL Railway password)
```

## URL de producción

https://transmetro-production.railway.app *(actualizar después del deploy)*

## Licencia

Panda Solutions © 2026
