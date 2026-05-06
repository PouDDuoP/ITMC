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
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
    if (!empty($_POST['cedula']) && !empty($_POST['email']) &&
        !empty($_POST['nombre']) && !empty($_POST['apellido']) &&
        !empty($_POST['cargo']) && !empty($_POST['departamento']) &&
        !empty($_POST['ext_telf']) && !empty($_POST['nro_telf']) && !empty($_POST['sueldo'])) {

    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $cargo = $_POST['cargo'];
    $ext_telf = $_POST['ext_telf'];
    $nro_telf = $_POST['nro_telf'];
    $departamento = $_POST['departamento'];
    $sueldo = $_POST['sueldo'];

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    $query_o = "SELECT  nombre, apellido, email, cargo, ext_telefono,nro_telefono, departamento, sueldo FROM itmc.empleado WHERE id = '$cedula'";
    $operacion_bit = pg_query($pgconn,$query_o) or die("Consulta errónea: ".pg_last_error());
    $iterador = pg_fetch_array($operacion_bit);

    include('../model/mod_empleado.php');
    $empleado = new Empleado();
    $operacion = $empleado->actualizar_empleado ($cedula,$nombre,$apellido,$email,$cargo,$ext_telf,$nro_telf,$departamento,$sueldo,$pgconn);

      if($operacion == "ok")
      {
        include_once ('../model/mod_bitacora.php');
        $bitacora = new Bitacora;

        $session=$_SESSION['cedula_empleado'];
        $usuario_id=$_SESSION['id'];
        $operacion = 'Modifico los datos del empleado '.$cedula;
        $tabla = 'usuario';
        $columna = 'ALL';

        $valor_original = $iterador['nombre'].','.$iterador['apellido'].','.$iterador['email'].','.$iterador['cargo'].','.$iterador['ext_telefono'].','.$iterador['nro_telefono'].','.$iterador['departamento'].','.$iterador['sueldo'];
        $valor_nuevo = $nombre.','.$apellido.','.$email.','.$cargo.','.$ext_telf.','.$nro_telf.','.$departamento.','.$sueldo;
        // Use relative URL for bitacora
        $url_relativa = 'controller/con_modificar_empleado.php';
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
          window.location="../view/view_consulta_empleado.php";
        </script>
    <?php
   }

  }else {
    ?>
        <script type="text/javascript">
          alert('este modolo solo esta habilitado para usuario administrador');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
} else {
  header('Location: index.php');
  session_destroy();
}
?>
