# COMPLETADO — Transmetro Guatemala
## Panda Solutions — Laravel 11

**Fecha de finalización:** 2026-05-23  
**Estado:** ✅ TODAS LAS TAREAS COMPLETADAS

---

## Resumen de lo construido

### Infraestructura
- Laravel 11 con SQLite (local) / PostgreSQL (Railway)
- Deploy automático con `railway.json` + Nixpacks
- Seed completo con datos reales guatemaltecos

### Autenticación y roles
- Login con campo `usuario` sobre tabla `operadores` (no la tabla `users`)
- 3 roles: `admin`, `operador`, `supervisor`
- Middleware `CheckRol` para proteger rutas por rol
- Sidebar dinámico que muestra solo los módulos accesibles por rol

### Módulos implementados
| Módulo | Rutas | Funcionalidad |
|--------|-------|---------------|
| Dashboard | `/dashboard` | Tarjetas resumen, alertas pendientes, esperas, estaciones críticas |
| Líneas | `/lineas` (CRUD) | CRUD completo + asignación dinámica de estaciones con orden y distancia |
| Estaciones | `/estaciones` (CRUD) | CRUD + vista de accesos, guardias, parqueos + alerta automática al 50% ocupación |
| Buses | `/buses` (CRUD) | CRUD + validación límite por línea (máx. 2×estaciones) |
| Pilotos | `/pilotos` (CRUD) | CRUD + historial educativo dinámico (agregar/quitar filas) |
| Alertas | `/alertas` | Panel por rol + modal registro espera de bus |
| Reportes | `/reportes` | RF-19/20/21 con export PDF vía DomPDF |

### Reportes
- **RF-19:** Buses por línea con estado de mínimos operativos
- **RF-20:** Alertas de ocupación por estación con historial de atención
- **RF-21:** Tiempos de espera de buses — promedio, máximo, detalle

---

## Credenciales de prueba

| Usuario | Password | Rol |
|---------|----------|-----|
| `admin.municipal` | `password123` | Administrador (acceso total) |
| `operador.central` | `password123` | Operador (solo su estación) |
| `supervisor.lineas` | `password123` | Supervisor (líneas y alertas) |

---

## Decisiones técnicas importantes

1. **Auth con tabla `operadores`**: Se extendió `Authenticatable` en `Operador` y se sobrescribió `getAuthIdentifierName()` para usar `usuario` en vez de `email`.
2. **Alerta automática**: Se dispara en `generarAlertaSiNecesario()` cuando la ocupación supera el 50% de la capacidad.
3. **Límite de buses**: Validado en `puedeAgregarBus()` — máximo 2×(número de estaciones en la línea).
4. **PDF con DomPDF**: Los reportes usan vistas Blade independientes con CSS inline para máxima compatibilidad.

---

## Variables de entorno para Railway

Configurar en el panel de Railway:
```
APP_KEY=base64:...    # php artisan key:generate --show
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=pgsql
DB_HOST=...           # Desde el plugin PostgreSQL de Railway
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=...
```

El comando de inicio en `railway.json` ya ejecuta `migrate --force` y `db:seed --force` en cada deploy.

---

## Problemas encontrados y soluciones

- **SQLite sin `enum` nativo**: Laravel lo maneja con CHECK constraints automáticamente.
- **Campo `usuario` en auth**: Se usó `getAuthIdentifierName()` en vez de configurar un guard personalizado.
- **Vistas de reportes sin layout**: Los PDF usan HTML standalone con CSS inline para evitar dependencias de assets.

---

*Generado automáticamente por Claude Code — Panda Solutions 2026*
