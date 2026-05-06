# Manual de Usuario - ITMC

## Introducción
ITMC (Sistema de Gestión de Recursos Humanos) es una aplicación web para la gestión de empleados, solicitudes y beneficios.

## Acceso al Sistema

### URL
```
http://localhost:8080
```
(En producción, usa la URL correspondiente)

### Credenciales Iniciales
| Usuario | Cédula | Clave | Perfil |
|---------|---------|-------|---------|
| Admin   | 1       | 1     | ADMINISTRADOR DEL SISTEMA |

## Menú Principal

Al iniciar sesión, verás el menú con las siguientes opciones:

### 1. Gestión de Empleados
- **Registrar Empleado**: Crear nuevo empleado (solo Admin/Analista)
- **Consultar Empleado**: Buscar empleado por cédula
- **Modificar Empleado**: Editar datos de empleado
- **Listar Empleados**: Ver todos los empleados

### 2. Gestión de Usuarios
- **Registrar Usuario**: Crear acceso para empleado
- **Consultar Usuario**: Buscar usuario
- **Modificar Usuario**: Cambiar perfil/clave
- **Listar Usuarios**: Ver todos los usuarios

### 3. Solicitudes
- **Recibo de Pago**: Solicitar recibo mensual
- **Constancia de Trabajo**: Solicitar constancia
- **Soporte Red**: Solicitar soporte técnico (red)
- **Soporte Equipo**: Soporte técnico (equipos)
- **Cambio de Clave**: Cambiar tu clave
- **Plan Vacacional**: Solicitar vacaciones
- **Beneficio Estudiantil**: Solicitar beneficio
- **Juguetes**: Solicitar beneficio

### 4. Reportes
- **Reporte Empleados**: Ver listado
- **Reporte Usuarios**: Ver listado
- **Reporte Cambios**: Ver bitácora (auditoría)

## Perfiles y Permisos

| Perfil | Descripción | Permisos |
|--------|-------------|-----------|
| EMPLEADO | Personal que labora | Puede crear sus propias solicitudes |
| ANALISTA DE TALENTO HUMANO | RRHH | Gestiona empleados y solicitudes |
| ANALISTA DE SISTEMAS | TI | Gestiona usuarios y sistema |
| ADMINISTRADOR DEL SISTEMA | Admin total | Acceso a todos los módulos |

## Flujo de Solicitudes

1. Empleado inicia sesión
2. Selecciona tipo de solicitud
3. Llena formulario
4. Envía solicitud (estado: "Nueva")
5. Analista revisa (estado: "Pendiente")
6. Solicitud aprobada o rechazada

## Bitácora (Auditoría)

El sistema registra automáticamente:
- Quién realizó el cambio
- Qué tabla afectó
- Qué columna cambió
- Valor anterior y nuevo
- Fecha y hora

## Preguntas Frecuentes

### ¿Cómo cambio mi clave?
1. Menú → Cambio de Clave
2. Ingresa clave actual
3. Ingresa clave nueva (2 veces)
4. Confirma

### ¿Olvidé mi clave?
Contacta al Administrador del Sistema (cédula 1).

### ¿Cómo ver mis solicitudes?
1. Menú → Consultar Solicitudes
2. Filtra por fecha o estado
3. Ver detalles

## Soporte Técnico

Para soporte técnico:
- **Red**: Menú → Soporte Red
- **Equipos**: Menú → Soporte Equipo

Incluye: descripción del problema, ubicación, urgencia.

## Cerrar Sesión

Menú → Cerrar Sesión → Confirmar.

---

**© 2024 ITMC - Todos los derechos reservados**
