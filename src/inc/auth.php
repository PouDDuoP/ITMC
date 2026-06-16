<?php

/**
 * Centralized session authentication for ITMC.
 * Replace duplicated session guards across controllers and views.
 *
 * Usage:
 *   require_once '../inc/auth.php';
 *   session_start();
 *   require_auth();
 *   require_perfil();        // any authenticated user (>0)
 *   require_perfil(4);        // admin only
 *   require_perfil([4, 2]);   // admin or talento humano
 */

/**
 * Validate the user is authenticated with an active session.
 * Redirects to login (index.php) and destroys session on failure.
 */
function require_auth() {
    if (!isset($_SESSION['cedula_empleado']) || empty($_SESSION['cedula_empleado']) || $_SESSION['status'] !== true) {
        @session_destroy();
        $base = dirname($_SERVER['SCRIPT_NAME']);
        header('location: ' . $base . '/../index.php');
        exit;
    }
}

/**
 * Validate the user has one of the allowed profiles.
 * Call without arguments to require any authenticated profile (>0).
 * Redirects to menu on failure.
 *
 * @param array|int|null $allowed Single profile int, array of ints, or null for any >0.
 */
function require_perfil($allowed = null) {
    $hasValidProfile = false;

    if ($allowed === null) {
        $hasValidProfile = isset($_SESSION['perfil']) && $_SESSION['perfil'] > 0;
    } else {
        $profiles = is_array($allowed) ? $allowed : [$allowed];
        $hasValidProfile = isset($_SESSION['perfil']) && in_array((int)$_SESSION['perfil'], $profiles, true);
    }

    if (!$hasValidProfile) {
        @session_destroy();
        $base = dirname($_SERVER['SCRIPT_NAME']);
        header('location: ' . $base . '/../view/view_menu.php');
        exit;
    }
}
