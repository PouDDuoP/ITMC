<?php
session_start();

// Incluir configuración si existe
if (file_exists('../config.php')) {
    include('../config.php');
}

$_SESSION['cedula_empleado'];

date_default_timezone_set('America/La_Paz');
$fecha_actual = date('Y-m-d');

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] > 0) {
    if (!empty($_POST['cedula']) && !empty($_POST['clave'])) {

      $cedula_id = $_POST['cedula'];
      $clave = $_POST['clave'];

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_usuario.php');
      $usuario = new Usuario();

      $resultado = $usuario->autenticar_usuario_perfil($cedula_id, $clave, $_SESSION['perfil'], TRUE, $pgconn);

        if ($resultado && pg_num_rows($resultado) > 0) {
          $clave_nueva = $_POST['clave_nueva'];
          $confirmar_clave = $_POST['confirmar_clave'];

          if ($clave_nueva === $confirmar_clave && !empty($clave_nueva)) {
              $modificar = $usuario->modificar_clave($cedula_id, $clave_nueva, $_SESSION['perfil'], $pgconn);

              if ($modificar) {
                  // Registrar en bitácora
                  include_once('../model/mod_bitacora.php');
                  $bitacora = new Bitacora();

                  $session = $_SESSION['cedula_empleado'];
                  $usuario_id = $_SESSION['id'];
                  $operacion = 'Cambio de clave para '.$cedula_id;
                  $tabla = 'usuario';
                  $columna = 'clave';
                  $valor_original = '*****';
                  $valor_nuevo = '*****';

                  $auditoria = $bitacora->registrar_bitacora($session, $usuario_id, $operacion, $tabla, $columna, $valor_original, $valor_nuevo, $url, $fecha_actual, $pgconn);

                  ?>
                  <script type="text/javascript">
                    alert('Clave modificada con éxito');
                    window.location="../view/view_menu.php";
                  </script>
                  <?php
              } else {
                  ?>
                  <script type="text/javascript">
                    alert('Error al modificar la clave');
                    window.history.back();
                  </script>
                  <?php
              }
          } else {
              ?>
              <script type="text/javascript">
                alert('Las claves nuevas no coinciden');
                  window.history.back();
              </script>
              <?php
          }
        } else {
          ?>
          <script type="text/javascript">
            alert('La clave actual es incorrecta');
              window.history.back();
          </script>
          <?php
        }
    } else {
      ?>
      <script type="text/javascript">
        alert('Complete todos los campos');
          window.history.back();
      </script>
      <?php
    }
  } else {
    ?>
    <script type="text/javascript">
      alert('No tiene permisos para esta acción');
         window.location="../view/view_menu.php";
    </script>
    <?php
  }
} else {
  header('Location: index.php');
  session_destroy();
}
?>