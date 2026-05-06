<?php
session_start();
if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] >0) {

		$cedula = $_SESSION['cedula_empleado'];
    $status = $_SESSION['status'];

		if (isset($cedula) && !empty($cedula) && $status === TRUE) {

				session_unset();
				session_destroy();

				// Usar ruta relativa para mayor modularidad
				header('Location: ../../index.php');
			}else{
				header('Location: ../../index.php');
			}

	}else {
		header('Location: ../../index.php');
		session_destroy();
	}
}else {
	header('Location: ../../index.php');
	session_destroy();
}
?>
