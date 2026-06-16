<?php
session_start();

// Include config if exists
if (file_exists('../config.php')) {
    include('../config.php');
}

date_default_timezone_set('America/La_Paz');
$fecha_actual = date('Y-m-d');

require_once '../inc/auth.php';
require_auth();
require_perfil([4, 2]);
    if (!empty($_POST['cedula']) && !empty($_POST['status'])) {

    $cedula = $_POST['cedula'];
    $status = $_POST['status'];
    $session=$_SESSION['cedula_empleado'];
    $usuario_id=$_SESSION['id'];

    include('../model/mod_conexion.php');
    $conexionPGSQL = new ConexionPGSQL();
    $pgconn = $conexionPGSQL->conectar();

    $query_o_id = "SELECT status FROM itmc.empleado WHERE id = $1";
    $operacion_bit_id = pg_query_params($pgconn,$query_o_id,array($cedula)) or die("Consulta errÃ³nea: ".pg_last_error());
    $iterador_id = pg_fetch_array($operacion_bit_id);

    include('../model/mod_empleado.php');
    $empleado = new Empleado();
    $operacion = $empleado->HabiOrInha_empleado ($cedula,$status,$pgconn);

    include_once ('../model/mod_bitacora.php');
    $bitacora = new Bitacora;

      if($operacion == "ok")
      {

        $operacion = 'Modifico el status del empleado '.$cedula.' a '.$status;
        $tabla = 'empleado';
        $columna = 'status';

        $valor_original = $iterador_id['status'];
        $valor_nuevo = $status;
        // Use relative URL for bitacora
        $url_relativa = 'controller/con_HabiOrInha_empleado.php';
        $audioria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url_relativa,$fecha_actual,$pgconn);

        include_once ('../model/mod_usuario.php');
        $usuario = new Usuario();

        if ($status == 't') {
          $perfil = 1;
          $operacionU = $usuario->HabiOrInha_usuario_perfil ($cedula,$status,$perfil,$pgconn);

    			$operacion = 'Modifico el Usuario de '.$cedula.' con perfil'.$perfil;
    			$tabla = 'usuario';
    			$columna = 'status';

    		$query_o = "SELECT status FROM itmc.usuario WHERE cedula_empleado = $1 AND status = $2 AND perfil = $3";
    			$operacion_bit = pg_query_params($pgconn,$query_o,array($cedula, $status, $perfil)) or die("Consulta errÃ³nea: ".pg_last_error());
    			$iterador = pg_fetch_array($operacion_bit);

    			$valor_original = $iterador['status'];
    			$valor_nuevo = $status;
          $audioria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url_relativa,$fecha_actual,$pgconn);

        } elseif ($status == 'f') {
          $operacionU = $usuario->HabiOrInha_usuario ($cedula,$status,$pgconn);

    			$operacion = 'Modifico Todos los Usuarios de '.$cedula;
    			$tabla = 'usuario';
    			$columna = 'status';

    		$query_o = "SELECT status FROM itmc.usuario WHERE cedula_empleado = $1 AND status = $2";
    			$operacion_bit = pg_query_params($pgconn,$query_o,array($cedula, $status)) or die("Consulta errÃ³nea: ".pg_last_error());
    			$iterador = pg_fetch_array($operacion_bit);

    			while ($iterador = pg_fetch_array($operacion_bit)) {
    				$resultado = $iterador['status'];
    			}


    			$valor_original = $resultado;
    			$valor_nuevo = $status;
          $audioria = $bitacora->registrar_bitacora($session,$usuario_id,$operacion,$tabla,$columna,$valor_original,$valor_nuevo,$url_relativa,$fecha_actual,$pgconn);
        }

        if($operacionU == "ok")
        {
          ?>
            <script type="text/javascript">
              alert('Empleado y usuarios del empleado modificado satisfactoriamente');
                  window.location="../view/view_menu.php";
            </script>
          <?php
          }else{
            ?>
              <script type="text/javascript">
                alert('Empleado modificado satisfactoriamente');
               window.location="../view/view_menu.php";
              </script>
            <?php
          }
      }else{
      ?>
        <script type="text/javascript">
          alert('Error al intentar realizar la operacion');
          window.history.back();
        </script>
      <?php
      }
    }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde completar el formulario para realizar la busqueda');
          window.history.back();
        </script>
    <?php
   }

  
?>
