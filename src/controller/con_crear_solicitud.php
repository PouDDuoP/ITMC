<?php
session_start();
date_default_timezone_set('America/La_Paz');

require_once '../inc/auth.php';
require_auth();
require_perfil();
    // if (!empty($_POST['departamento']) && !empty($_POST['constancias']) && !empty($_POST['descripcion']))
    if (!empty($_POST['constancias']) && !empty($_POST['descripcion']))
    {
      $cedula_id = $_SESSION['cedula_empleado'];
      $estado_solicitud = 1;
      $fecha_actual = date('Y-m-d');
      $tipo_solicitud = $_POST['tipo_solicitud'];
      $departamento = 3;
      // $departamento = $_POST['departamento'];
      $descripcion = $_POST['descripcion'];

      $mes = date('m',strtotime($fecha_actual));
      $anio = date('Y',strtotime($fecha_actual));
      $fecha_solicitado = $anio.'-'.$mes;

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_solicitud.php');
      $solicitud = new Solicitud();
      $consultar = $solicitud->consultar_solicitud_fecha ($cedula_id,$fecha_solicitado,$tipo_solicitud,$pgconn);

        if (pg_num_rows($consultar) < 3) {
            ?>
          <script type="text/javascript">
            alert('Solicitud creada con exito');
            window.location="../view/view_menu.php";
          </script>
          <?php
          $registar_solicitud = $solicitud->crear_solicitud ($fecha_actual,$cedula_id,$descripcion,$tipo_solicitud,$estado_solicitud,$departamento,$pgconn);
        } else {
          ?>
            <script type="text/javascript">
              alert('Usted a solo puede realizar este tipo de solicitud 3 veses al mes');
              window.location="../view/view_menu.php";
            </script>
          <?php
        }
      }else {
    ?>
        <script type="text/javascript">
          alert('Recuerde completar el formulario para poder crear la solicitud');
          // window.location="../view/view_crear_solicitud.php";
          window.history.back();
        </script>
    <?php
   }
?>
