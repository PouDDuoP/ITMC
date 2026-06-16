<?php
session_start();
date_default_timezone_set('America/La_Paz');

require_once '../inc/auth.php';
require_auth();
require_perfil();
    if (!empty($_POST['tipo_beneficio']) && !empty($_POST['id']))
    {
      $cedula_id = $_SESSION['cedula_empleado'];
      $id_hijo = $_POST['id'];
      $estado_solicitud = 1;
      $fecha_actual = date('Y-m-d');
      $tipo_beneficio = $_POST['tipo_beneficio'];

      $mes = date('m',strtotime($fecha_actual));
      $anio = date('Y',strtotime($fecha_actual));

      $fecha_solicitado = $anio.'-'.$mes;

      include('../model/mod_conexion.php');
      $conexionPGSQL = new ConexionPGSQL();
      $pgconn = $conexionPGSQL->conectar();

      include('../model/mod_beneficiario.php');
      $beneficiario = new Beneficiario();

      switch ($tipo_beneficio) {
        case '1':

        $consultar = $beneficiario->consultar_solicitud_beneficio_anual ($cedula_id,$id_hijo,$anio,$tipo_beneficio,$pgconn);

        if (pg_num_rows($consultar) < 1) {
          $registar_solicitud = $beneficiario->crear_solicitud_beneficio ($cedula_id,$id_hijo,$tipo_beneficio,$fecha_actual,$estado_solicitud,$pgconn);
          ?>
          <script type="text/javascript">
            alert('Solicitud de beneficio creada con exito');
            window.location="../view/view_menu.php";
            // window.history.back()
          </script>
          <?php
        } else {
          ?>
            <script type="text/javascript">
              alert('Usted a solo puede realizar este tipo de solicitud 1 vez al año por cada hijo que comprenda el rango de edad');
              window.location="../view/view_menu.php";
              // window.history.back();
            </script>
          <?php
        }
          break;
        case '2':

        $consultar = $beneficiario->consultar_solicitud_beneficio_anual ($cedula_id,$id_hijo,$anio,$tipo_beneficio,$pgconn);

        if (pg_num_rows($consultar) < 1) {
          $registar_solicitud = $beneficiario->crear_solicitud_beneficio ($cedula_id,$id_hijo,$tipo_beneficio,$fecha_actual,$estado_solicitud,$pgconn);
          ?>
          <script type="text/javascript">
            alert('Solicitud de beneficio creada con exito');
            window.location="../view/view_menu.php";
            // window.history.back()
          </script>
          <?php
        } else {
          ?>
            <script type="text/javascript">
            alert('Usted a solo puede realizar este tipo de solicitud 1 vez al año por cada hijo que comprenda el rango de edad');
              window.location="../view/view_menu.php";
              // window.history.back();
            </script>
          <?php
        }

          break;
        case '3':

        $consultar = $beneficiario->consultar_solicitud_beneficio_anual ($cedula_id,$id_hijo,$anio,$tipo_beneficio,$pgconn);

        if (pg_num_rows($consultar) < 1) {
          $registar_solicitud = $beneficiario->crear_solicitud_beneficio ($cedula_id,$id_hijo,$tipo_beneficio,$fecha_actual,$estado_solicitud,$pgconn);
          ?>
          <script type="text/javascript">
            alert('Solicitud de beneficio creada con exito');
            window.location="../view/view_menu.php";
            // window.history.back()
          </script>
          <?php
        } else {
          ?>
            <script type="text/javascript">
            alert('Usted a solo puede realizar este tipo de solicitud 1 vez al año por cada hijo que comprenda el rango de edad');
              window.location="../view/view_menu.php";
              // window.history.back();
            </script>
          <?php
        }

          break;
        case '4':

        $consultar = $beneficiario->consultar_solicitud_beneficio_mensual ($cedula_id,$id_hijo,$fecha_solicitado,$tipo_beneficio,$pgconn);

        if (pg_num_rows($consultar) < 1) {
          $registar_solicitud = $beneficiario->crear_solicitud_beneficio ($cedula_id,$id_hijo,$tipo_beneficio,$fecha_actual,$estado_solicitud,$pgconn);
          ?>
          <script type="text/javascript">
            alert('Solicitud de beneficio creada con exito');
            // window.location="../view/view_menu.php";
            window.history.back();
          </script>
          <?php
        } else {
          ?>
            <script type="text/javascript">
            alert('Usted a solo puede realizar este tipo de solicitud 1 vez al mes por cada hijo que comprenda el rango de edad');
              // window.location="../view/view_menu.php";
              window.history.back();
            </script>
          <?php
        }

          break;

        default:
        ?>
          <script type="text/javascript">
            alert('Tipo de beneficio no coincide');
            window.location="../view/view_menu.php";
          </script>
        <?php
          break;
      }
  }else {
    ?>
        <script type="text/javascript">
          alert('El parametro enviado no se distinge');
          window.location="../view/view_crear_solicitud.php";
          // window.history.back();
        </script>
    <?php
   }
?>
