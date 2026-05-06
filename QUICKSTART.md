# ITMC - Inicio Rápido con Docker

## Requisitos
- Docker Desktop instalado
- Git (opcional)

## Pasos para levantar el sistema

### 1. Clonar o descargar el proyecto
```bash
git clone <repo-url> itmc
cd itmc
```

### 2. Levantar los servicios
```bash
docker-compose up -d --build
```

Esto:
- Construye la imagen `itmc-app` (PHP 7.4 + Apache)
- Crea el contenedor `itmc-db-1` (PostgreSQL 13)
- Crea el contenedor `itmc-web-1` (Apache + PHP)
- Ejecuta `init.sql` automáticamente (¡solo la primera vez!)

### 3. Acceder a la aplicación
Abre tu navegador:
```
http://localhost:8080
```

### 4. Login inicial
- **Cédula**: `1`
- **Clave**: `1`
- **Perfil**: ADMINISTRADOR DEL SISTEMA (selecciona automáticamente)

### 5. Probar funcionalidades
Desde el menú puedes:
- Registrar empleados
- Crear solicitudes (recibos, constancias, soporte)
- Gestionar usuarios
- Ver reportes y bitácora

## Comandos útiles

### Ver estado
```bash
docker ps
```

### Detener todo
```bash
docker-compose down
```

### Detener y eliminar TODO (incluyendo datos)
```bash
docker-compose down -v
```
⚠️ **Cuidado**: Esto elimina la base de datos completamente.

### Reconstruir desde cero
```bash
docker-compose down -v
docker-compose up -d --build
```
Esto recrea la base de datos automáticamente desde `init.sql`.

### Ver logs
```bash
docker logs itmc-web-1  # Web server
docker logs itmc-db-1    # Base de datos
```

## Estructura de archivos importante
```
ITMC/
├── controller/      # Lógica de negocio
├── model/         # Acceso a datos
├── view/          # Interfaz de usuario
│   ├── inc/        # Cabeceras, navegación
│   ├── styles/    # CSS
│   └── js/         # JavaScript
├── config.php     # Configuración centralizada
├── init.sql       # Script de inicialización BD
├── Dockerfile
└── docker-compose.yml
```

## Solución de problemas

### Error: "relation already exists"
- Detén y elimina TODO: `docker-compose down -v`
- Vuelve a levantar: `docker-compose up -d --build`

### La aplicación no carga
- Verifica que Docker esté corriendo
- Verifica logs: `docker logs itmc-web-1`
- Asegúrate de que el puerto 8080 esté libre

### Error de login
- Verifica que el contenedor `itmc-db-1` esté "Healthy"
- Revisa los logs de PostgreSQL: `docker logs itmc-db-1`
