<?php
session_start();

// Include config if exists
if (file_exists('../config.php')) {
    include('../config.php');
}

$_SESSION['cedula_empleado'];

date_default_timezone_set('America/La_Paz');
$fecha_actual = date('Y-m-d');

if (isset($_SESSION['cedula_empleado']) && !empty($_SESSION['cedula_empleado']) && $_SESSION['status'] === TRUE) {
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3) {
    if (!empty($_POST['perfil']) && !empty($_POST['id']) &&
        !empty($_POST['cedula']) && !empty($_POST['status'])) {

    $cedula_id = $_POST['cedula'];
    $perfil = $_POST['perfil'];
    $id = $_POST['id'];
    $status = $_POST['status'];

    include_once ('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    include_once ('../model/mod_usuario.php');
    $usuario = new Usuario();
    $operacion = $usuario->modificar_usuario($id,$cedula_id,$perfil,$status,$pgconn);

    include_once ('../model/mod_bitacora.php');
    $bitacora = new Bitacora;

      if($operacion == "ok")
      {

        $session=$_SESSION['cedula_empleado'];
        $usuario_id=$_SESSION['id'];
        $operacion = 'Modifico Usuario con id '.$id.', usuario '.$cedula_id.' y perfil '.$perfil;
        $tabla = 'usuario';
        $columna = 'status';

        $query_o = "SELECT status FROM itmc.usuario WHERE cedula_empleado = '$cedula_id' AND id = $id AND perfil = $perfil";
        $operacion_bit = pg_query($pgconn,$query_o) or die("Consulta errónea: ".pg_last_error());
        $iterador = pg_fetch_array($operacion_bit);

        $valor_original = $iterador['status'];
        $valor_nuevo = $status;
        // Use relative URL for bitacora
        $url_relativa = 'controller/con_modificar_usuario.php';
        $audioria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url_relativa,$fecha_actual,$pgconn);

        ?>
          <script type="text/javascript">
            alert('Usuario modificado satisfactoriamente');
             window.location="../view/view_menu.php";
          </script>
        <?php
      }else{
      ?>
        <script type="text/javascript">
          alert('Recuerde completar el formulario para realizar la busqueda');
          window.history.back();
        </script>
      <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde completar el formulario para realizar la busqueda');
          // window.location="view/view_consulta_usuario.php";
          window.history.back();
        </script>
    <?php
   }

  }else {
    ?>
        <script type="text/javascript">
          alert('este modulo solo esta habilitado para usuario administrador');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
} else {
  header('Location: index.php');
  session_destroy();
}
?>
