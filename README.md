# ITMC - Sistema de Gestión de Recursos Humanos

Sistema de gestión de empleados, solicitudes y beneficios desarrollado en PHP 7.4 y PostgreSQL 13, con despliegue vía Docker.

## 📋 Descripción del Proyecto

Este proyecto fue desarrollado originalmente en el año 2017 por estudiantes universitarios como un sistema de gestión de recursos humanos para la gestión de empleados del municipio Chacao. El sistema cuenta con dos versiones claramente diferenciadas:

- **ITMCOLD**: Versión original suministrada (código plano, sin estructura definida)
- **ITMC**: Versión final completada con arquitectura MVC (Controller/Model/View)

> **Nota**: Este proyecto fue apoyado en modalidad de consultoría — asesoría en arquitectura, refactorización de seguridad, revisión de código y modernización del stack.

## 🏗️ Estructura del Proyecto

```
itmc/
├── README.md               # Este archivo
├── QUICKSTART.md           # Inicio rápido con Docker
├── MANUAL_USUARIO.md       # Guía de usuario
├── Dockerfile              # Configuración de imagen PHP-Apache
├── docker-compose.yml      # Orquestación de servicios
├── config.php              # Configuración centralizada
├── init.sql                # Script de inicialización BD (idempotente)
├── src/                    # Aplicación principal (MVC)
│   ├── inc/                # Componentes reutilizables (auth.php)
│   ├── controller/         # Lógica de control
│   ├── model/              # Conexión y modelos de BD
│   ├── view/               # Vistas e interfaz
│   │   ├── inc/            # Headers, navbar, scripts
│   │   ├── styles/         # CSS
│   │   └── js/             # JavaScript
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
| **Autenticación (2026)** | —                               | Centralizada via `src/inc/auth.php`  |
| **PII expuesto**      | —                               | ❌ Eliminado (consulta.json quitado) |
| **Código muerto**     | —                               | ❌ 5 archivos eliminados             |

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

## 🔐 Refactorización de Seguridad y Arquitectura (2026)

En 2026 se realizó una refactorización integral del código con foco en seguridad, mantenibilidad y eliminación de deuda técnica:

### 1. Autenticación Centralizada

Se creó `src/inc/auth.php` como punto único de control de acceso, eliminando la lógica de sesión dispersa en 62+ archivos:

**Antes (disperso en cada archivo):**
```php
session_start();
if ($_SESSION['autenticado'] != 'SI') {
    header('Location: login.php');
    exit();
}
```

**Después (centralizado):**
```php
require_once __DIR__ . '/../inc/auth.php';
require_auth();
require_perfil([1, 2, 3]); // según el rol necesario
```

Esto elimina:
- ❌ Código duplicado de validación de sesión en cada vista/controlador
- ❌ Riesgo de olvidar validar autenticación en un archivo nuevo
- ❌ Comparaciones de tipo sueltas (`$_SESSION['autenticado'] != 'SI'`)

### 2. Eliminación de PII (Personal Identifiable Information)

Se eliminó el endpoint `consulta.json` que exponía datos sensibles de empleados (cédula, nombres, fechas) como JSON público sin autenticación. También se eliminó `phpinfo.php` que exponía información del servidor.

### 3. Corrección de Bug en `require_perfil()`

Se corrigió la comparación de tipos en todas las llamadas a `require_perfil()` — el valor de sesión llegaba como string pero se comparaba contra entero sin castear:

**Antes:** `$_SESSION['perfil'] != 1` → comparación lava entre string e int
**Después:** `(int)$_SESSION['perfil'] !== 1` → comparación estricta

### 4. Limpieza de Código Muerto

Se eliminaron archivos sin uso:
- `src/model/consulta_departamento_practica.php` — modelo duplicado de prueba
- `src/model/mod_departamentopractica.php` — modelo duplicado de prueba
- `src/model/sumapractica.php` — consulta de prueba no referenciada
- `src/model/mod_auditoria.php` — modelo sin referencias (reemplazado por `mod_bitacora.php`)
- `src/view/view_crear_solicitudNOUSO.php` — vista huérfana no referenciada

### 5. Corrección de Parse Errors y BOM

- Se eliminaron llaves de cierre extra (`}`) en 16 controladores y 5 modelos que causaban errores de parse
- Se eliminaron etiquetas `?>` PHP huérfanas al final de archivos que causaban headers already sent
- Se eliminó BOM (Byte Order Mark) de 28 archivos PHP que interrumpían la salida HTTP
- Se eliminó la sección "Cambios Reales" del `init.sql` que contenía datos de prueba sensibles

## 📝 Notas Adicionales

- El proyecto utiliza **PHP 7.4** (era la versión estable en 2017)
- La base de datos usa **PostgreSQL 13**
- El sistema fue diseñado para la gestión de empleados del municipio Chacao
- Los diagramas en la carpeta `diagramas/` muestran el diseño original de clases y paquetes
- La versión ITMC incorpora manejo de sesiones y perfiles de usuario (1-4)

## 🛠️ Desarrollo y Modificaciones

Para realizar cambios en el código:
1. Modifica los archivos en la carpeta `src/`
2. Los cambios se reflejan automáticamente gracias al volumen de Docker
3. Para ver errores de PHP, revisa los logs: `docker-compose logs web`
4. Para agregar un nuevo controlador/vista, solo requerís `auth.php` para la autenticación

## 📧 Contacto y Soporte

Este proyecto fue desarrollado originalmente en 2017. Para dudas sobre la implementación, consultar:
- `QUICKSTART.md` - Inicio rápido
- `MANUAL_USUARIO.md` - Guía de usuario
- Este `README.md` - Documentación técnica

---

**© 2024-2026 ITMC - Todos los derechos reservados**
