<?php
session_start();
require_once __DIR__ . '/../../inc/auth.php';
require_auth();
require_perfil();

session_unset();
session_destroy();

header('Location: ../../index.php');
?>
