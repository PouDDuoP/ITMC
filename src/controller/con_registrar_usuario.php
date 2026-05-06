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
  if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 3)
  {
    if (!empty($_POST['cedula']) && !empty($_POST['password']) && !empty($_POST['perfil']))
    {
      $cedula_id = $_POST['cedula'];
      $clave = $_POST['password'];
      $perfil_req = $_POST['perfil'];
      $status = TRUE;

      include_once('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include_once('../model/mod_empleado.php');
      $empleado = new Empleado();
      $consultar = $empleado->consultar_empleado_cedula ($cedula_id,$pgconn);

      if($consultar['id'] === $cedula_id) {
        if ($consultar['status'] == 't') {

        include_once('../model/mod_perfil.php');
        $perfil = new Perfil();
        $consultarP = $perfil->consultar_perfil ($perfil_req,$status,$pgconn);

          if ($consultarP != '' && !empty($consultarP) && $consultarP != false ) {

            include_once('../model/mod_usuario.php');
            $usuario = new Usuario();
            $consultarU = $usuario->validar_prefil ($cedula_id,$perfil_req,$pgconn);

            if ($consultarU['perfil'] == $perfil_req) {
              ?>
                  <script type="text/javascript">
                    alert('El usuario ya posee el perfil');
                    //                   window.location="../view/view_registrar_usuario_consulta.php";
                      window.history.back();
                  </script>
              <?php
            } else {
              $registrar_usuario = $usuario->registrar_usuario($cedula_id,$clave,$perfil_req,$pgconn);

              include_once ('../model/mod_bitacora.php');
          		$bitacora = new Bitacora;

          		$session=$_SESSION['cedula_empleado'];
          		$usuario_id=$_SESSION['id'];
          		$operacion = 'Registro Usuario '.$cedula_id.' con perfil '.$perfil_req;
          		$tabla = 'usuario';
          		$columna = 'ALL';
          		$valor_original = '';
          		$valor_nuevo = '';
              // Use relative URL for bitacora
              $url_relativa = 'controller/con_registrar_usuario.php';
          		$audioria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url_relativa,$fecha_actual,$pgconn);

              ?>
                  <script type="text/javascript">
                    alert('Usuario registrado con exito');
                    window.location="../view/view_menu.php";
                  </script>
              <?php
            }

          } else {
            ?>
                <script type="text/javascript">
                  alert('El perfil seleccionado no esta presete en la base de datos o esta inhablitado');
                  window.location="../view/view_registrar_usuario_consulta.php";
                </script>
            <?php
          }
        } else {
          ?>
              <script type="text/javascript">
                alert('El empleado con numero de cedula [<?php echo $cedula_id;?>] esta inhabilitado');
                window.location="../view/view_registrar_usuario_consulta.php";
              </script>
          <?php
        }
      }else {
        ?>
            <script type="text/javascript">
              alert('No exsite el empleado con numero de cedula [<?php echo $cedula_id;?>]');
              window.location="../view/view_registrar_usuario_consulta.php";
            </script>
        <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde completar el formulario para poder registrar al usuario');
          window.location="../view/view_registrar_usuario_consulta.php";
        </script>
    <?php
   }
  }else {
    ?>
        <script type="text/javascript">
          alert('Este modulo solo esta habilitado para usuario administrador');
          window.location="../view/view_menu.php";
        </script>
    <?php
  }
} else {
  header('Location: ../index.php');
  session_destroy();
}
?>
