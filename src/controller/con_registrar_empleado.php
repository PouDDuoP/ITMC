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
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 2) {
    if (!empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['fecha_ingreso']) && !empty($_POST['cargo']) && !empty($_POST['departamento']) && !empty($_POST['ext_telf']) && !empty($_POST['nro_telf']) && !empty($_POST['sueldo']) && !empty($_POST['email'])) {

      $cedula_id = $_POST['cedula'];
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $fecha_ingreso = $_POST['fecha_ingreso'];
      $cargo = $_POST['cargo'];
      $departamento = $_POST['departamento'];
      $ext_telf = $_POST['ext_telf'];
      $nro_telf = $_POST['nro_telf'];
      $clave = $_POST['cedula']; // La clave inicial es la cédula
      $sueldo = $_POST['sueldo'];
      $email = $_POST['email'];
      $perfil = 1; // Perfil por defecto: EMPLEADO

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_empleado.php');
      $empleado = new Empleado();
      $consultar = $empleado->consultar_empleado_cedula ($cedula_id,$pgconn);

      include('../model/mod_usuario.php');
      $usuario = new Usuario();

      if($consultar['id'] === $_POST['cedula']) {
        ?>
        <script type="text/javascript">
          alert('El usuario ya existe porfavor verificar los datos ingresados');
          window.location="../view/view_registrar_empleado.php";
        </script>
        <?php
      } else {
        $registrar_empleado = $empleado->registrar_empleado ($cedula_id,$nombre,$apellido,$email,$cargo,$fecha_ingreso,$ext_telf,$nro_telf,$departamento,$sueldo,$pgconn);
        $registrar_usuario = $usuario->registrar_usuario ($cedula_id,$clave,$perfil,$pgconn);

        include_once('../model/mod_bitacora.php');
        $bitacora = new Bitacora();

        $session=$_SESSION['cedula_empleado'];
        $usuario_id=$_SESSION['id'];
        $operacion = 'Registro Empleado '.$cedula_id;
        $tabla = 'empleado';
        $columna = 'ALL';
        $valor_original = '';
        $valor_nuevo = '';

        $auditoria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url,$fecha_actual,$pgconn);

        $operacion = 'Registro Usuario '.$cedula_id.' con perfil '.$perfil;
        $tabla = 'usuario';

        $auditoria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url,$fecha_actual,$pgconn);

        ?>
        <script type="text/javascript">
          alert('Empleado Registrado con exito,tambien se a creado el usuario [<?php echo $cedula_id;?>] con perfil de [empleado], [la clave es su cedula] recuerde cambiar al acceder por primera vez');
          window.location="../view/view_menu.php";
        </script>
        <?php
      }
    } else {
      ?>
        <script type="text/javascript">
          alert('Recuerde completar el formulario para poder registrar al usuario');
          window.location="../view/view_registrar_empleado.php";
        </script>
      <?php
    }
  } else {
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