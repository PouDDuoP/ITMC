<?php
/**
 * Configuración centralizada para ITMC
 * Define la URL base dinámicamente para mejorar la modularidad
 */

// Detectar protocolo (http/https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';

// Host y puerto
$host = $_SERVER['HTTP_HOST']; // Esto captura 'localhost:8080' automáticamente

// Ruta base: si estamos en Docker (ITMC/ no existe como subdirectorio), usar '/'
// Si estamos en desarrollo local con subdirectorio, ajustar según sea necesario
$base_path = ''; // Dejar vacío para Docker (app en raíz)

// Construir URL base
define('BASE_URL', $protocol . $host . $base_path);

// Para compatibilidad con rutas relativas (opcional)
define('BASE_PATH', $base_path);
?>
