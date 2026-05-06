<?php
session_start();

// Incluir configuración si existe
if (file_exists('../config.php')) {
    include('../config.php');
}

$_SESSION['cedula_empleado'];

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
    if (!empty($_POST['cedula']) || $_POST['cedula'] != 0 || is_string($_POST['cedula']) == false) {

      $cedula_id = $_POST['cedula'];

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_empleado.php');
      $empleado = new Empleado();
      $consultar = $empleado->consultar_empleado_cedula ($cedula_id,$pgconn);

        if(!empty($consultar) && $consultar != '' && $consultar != false)
        {
          $cedula = $consultar['id'];
          if($cedula === $cedula_id) {

            $consultar_datos = $empleado->consultar_empleado ($cedula_id,$pgconn);
            $arraydatos = array();
            while ($columna = pg_fetch_array($consultar_datos)) {
                $arraydatos = $columna;
              }
            $json = json_encode($arraydatos);

            // Usar ruta relativa - no depende del host
            echo "<form name='datos'>";
            echo "<input type='hidden' name='consulta' value='$json'>";
            echo "</form>";
            echo "<script type='text/javascript'>
                    document.datos.method = 'POST';
                    document.datos.action = '../view/view_consulta_empleado_resultado.php';
                    document.datos.submit();
                  </script>";
            exit; // Importante: detener ejecución después de redirect
          }
        } else {
          // No existe el empleado
          echo "<script type='text/javascript'>
                  alert('No existe el empleado con numero de cedula $cedula_id');
                  window.history.back();
                </script>";
          exit;
        }
    } else {
        echo "<script type='text/javascript'>
                alert('Nro de cedula ingresado no valido');
                window.history.back();
              </script>";
        exit;
    }
  } else {
      echo "<script type='text/javascript'>
              alert('este modulo solo esta habilitado para usuario administrador');
              window.location='../view/view_menu.php';
            </script>";
      exit;
  }
} else {
  header('Location: index.php');
  session_destroy();
}
?>