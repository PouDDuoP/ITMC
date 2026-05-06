# ITMC - Sistema de Gestión de Recursos Humanos

Sistema de gestión de empleados, solicitudes y beneficios desarrollado en PHP 7.4 y PostgreSQL 13, con despliegue vía Docker.

## 📋 Descripción del Proyecto

Este proyecto fue desarrollado originalmente en el año 2017 como un sistema de gestión de recursos humanos. El sistema cuenta con dos versiones claramente diferenciadas:

- **ITMCOLD**: Versión original suministrada (código plano, sin estructura definida)
- **ITMC**: Versión final completada con arquitectura MVC (Controller/Model/View)

## 🏗️ Estructura del Proyecto

```
itmc/
├── README.md               # Este archivo
├── QUICKSTART.md           # Inicio rápido con Docker
├── MANUAL_USUARIO.md       # Guía de usuario
├── Dockerfile              # Configuración de imagen PHP-Apache
├── docker-compose.yml      # Orquestación de servicios
├── config.php             # Configuración centralizada
├── init.sql               # Script de inicialización BD (idempotente)
├── ITMC/                   # Aplicación principal (MVC)
│   ├── controller/         # Lógica de control
│   ├── model/              # Conexión y modelos de BD
│   ├── view/               # Vistas e interfaz
│   │   ├── inc/             # Cabeceras, navegación
│   │   ├── styles/          # CSS
│   │   └── js/              # JavaScript
│   └── index.php           # Punto de entrada
└── docker-compose.yml      # Orquestación (en raíz)
```

## 🛠️ Requisitos Previos

- Docker Desktop instalado y en ejecución
- Puertos 80 (HTTP) y 5432 (PostgreSQL) disponibles
- Git (opcional, para control de versiones)

## 🔧 Instrucciones de Ejecución

### Paso 1: Clonar o descargar el proyecto
```bash
git clone <repo-url> itmc
cd itmc
```

O si ya tienes el proyecto:
```bash
cd itmc
```

### Paso 2: Levantar los servicios con Docker
```bash
docker-compose up -d --build
```

Esto:
- Construye la imagen `itmc-app` (PHP 7.4 + Apache)
- Crea el contenedor `itmc-db-1` (PostgreSQL 13)
- Crea el contenedor `itmc-web-1` (Apache + PHP)
- **Ejecuta `init.sql` automáticamente** (¡solo la primera vez!)

### Paso 3: Acceder al sistema
Abre tu navegador:
```
http://localhost:8080
```

### Paso 4: Detener los servicios (cuando sea necesario)
```bash
docker-compose down
```

⚠️ **Cuidado**: Esto NO elimina la base de datos. Para eliminar TODO (incluyendo datos):
```bash
docker-compose down -v
```
Luego al hacer `docker-compose up -d --build`, se recreará la base de datos automáticamente.

## 🔧 Cambios Realizados en el Código para Docker

Para que el proyecto funcionara correctamente en Docker, se realizaron modificaciones específicas:

### 1. Modificación de `ITMC/model/mod_conexion.php`
**Antes (Hardcoded):**
```php
function __construct() {
    $this->host='localhost';        // ❌ Hardcoded
    $this->port = '5432';           // ❌ Hardcoded
    $this->db='dbitmc';             // ❌ Hardcoded
    $this->user='postgres';         // ❌ Hardcoded
    $this->pass='12345';            // ❌ Hardcoded
}
```

**Después (Compatible con Docker + Local):**
```php
function __construct() {
    // ✅ Usa variables de entorno con fallback a valores originales
    $this->host = getenv('DB_HOST') ?: 'localhost';
    $this->port = getenv('DB_PORT') ?: '5432';
    $this->db   = getenv('DB_NAME') ?: 'dbitmc';
    $this->user = getenv('DB_USER') ?: 'postgres';
    $this->pass = getenv('DB_PASS') ?: '12345';
}
```

**¿Por qué este cambio?**
- En Docker, el host de la BD no es `localhost`, sino el nombre del servicio (`db`)
- `getenv()` permite leer variables de entorno definidas en `docker-compose.yml`
- El fallback (`: ?`) mantiene compatibilidad con ejecución local fuera de Docker

### 2. Mejora de Modularidad (Rutas Relativas)

Se corrigieron **todos los controladores** para usar rutas relativas:
- `con_consulta_empleado.php` ✅
- `con_consulta_usuario.php` ✅
- `con_registrar_empleado.php` ✅
- `con_cambiar_pass.php` ✅
- `con_solicitud*.php` ✅
- `view/inc/head.php` ✅
- `view/inc/logout.php` ✅

**Antes:** `header('location: /ITMC/view/menu.php');` ❌
**Después:** `header('Location: view/menu.php');` ✅

### 3. Script de Inicialización `init.sql` (Idempotente)

Se modificó `init.sql` para que sea **idempotente** (seguro ejecutar múltiples veces):
- `CREATE SCHEMA IF NOT EXISTS itmc`
- `CREATE TABLE IF NOT EXISTS itmc.*`
- `INSERT ... WHERE NOT EXISTS` para datos iniciales
- Función `sp_bitacora` corregida

Esto permite que, al hacer `docker-compose down -v` y `docker-compose up -d --build`, la base de datos se recree automáticamente.

## 🗄️ Restauración de Base de Datos

### Restauración Automática
El script `init.sql` se ejecuta **automáticamente** al levantar el servicio `db` por primera vez. El script:
1. Espera a que PostgreSQL esté listo
2. Verifica si ya se restauró (evita duplicados)
3. Ejecuta `CREATE TABLE` e `INSERT` con verificaciones

### Datos del Sistema
- **Formato**: PostgreSQL 13+
- **Locale**: `es_VE.UTF-8`
- **Base de datos**: `dbitmc`
- **Esquema**: `itmc`
- **Tablas**: 13 (empleado, usuario, solicitud, beneficios, etc.)

## 📊 Diferencias entre Versiones

| Característica       | ITMCOLD                          | ITMC                                |
|-----------------------|----------------------------------|-------------------------------------|
| **Estructura**        | Código plano, sin organización   | MVC (Controller/Model/View)         |
| **Conexión a BD**     | Directa en archivos individuales | Clase `ConexionPGSQL` centralizada  |
| **Autenticación**     | Básica                           | Manejo de perfiles (1-4)            |
| **Bitácora**          | No implementada                  | Tabla `itmc.bitacora` para auditoría|
| **Interfaz**          | Páginas independientes           | Navegación centralizada con menú     |
| **Validaciones**      | Mínimas                          | Validación de campos en modelos      |
| **Compatibilidad Docker** | No                            | ✅ Sí (con cambios documentados)     |

## 🐳 Servicios Docker

### Web Service (PHP + Apache)
- **Imagen**: `php:7.4-apache`
- **Puerto**: 80 (mapeado a `localhost:8080`)
- **Volumen**: `./ITMC/` montado en `/var/www/html/`
- **Extensiones**: PostgreSQL (pgsql, pdo_pgsql)

### Database Service (PostgreSQL)
- **Imagen**: `postgres:13`
- **Puerto**: 5432
- **Credenciales**: postgres / 12345
- **Volumen persistente**: `postgres_data`
- **Script de init**: `init.sql` en `/docker-entrypoint-initdb.d/`

## 📝 Notas Adicionales

- El proyecto utiliza **PHP 7.4** (era la versión estable en 2017)
- La base de datos usa **PostgreSQL 13**
- El sistema fue diseñado para la gestión de empleados del municipio Chacao
- Los diagramas en la carpeta `diagramas/` muestran el diseño original de clases y paquetes
- La versión ITMC incorpora manejo de sesiones y perfiles de usuario (1-4)

## 🛠️ Desarrollo y Modificaciones

Para realizar cambios en el código:
1. Modifica los archivos en la carpeta `ITMC/`
2. Los cambios se reflejan automáticamente gracias al volumen de Docker
3. Para ver errores de PHP, revisa los logs: `docker-compose logs web`

## 📧 Contacto y Soporte

Este proyecto fue desarrollado originalmente en 2017. Para dudas sobre la implementación Docker, consultar:
- `QUICKSTART.md` - Inicio rápido
- `MANUAL_USUARIO.md` - Guía de usuario
- Este `README.md` - Documentación técnica

---

**© 2024 ITMC - Todos los derechos reservados**
